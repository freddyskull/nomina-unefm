# Despliegue en Producción

Pasos para publicar el Portal de Nómina UNEFM en el servidor de producción.

## 1. Requisitos en el servidor

- Docker Engine + Docker Compose (`docker compose` v2+).
- Puertos abiertos en el firewall: `80` (HTTP) y `443` (HTTPS).
- Acceso de red del servidor hacia Oracle: `150.187.4.18:1521`.

## 2. DNS

En el panel DNS de la universidad crear un registro A:

```
nomina.unefm.edu.ve  A  <IP pública del servidor>
```

El código ya usa ese dominio en:
- `nginx/nginx.conf` → `server_name nomina.unefm.edu.ve`
- `docker-compose.yml` → `APP_URL=https://nomina.unefm.edu.ve`

> Si el dominio final fuera otro, cambiar **ambos** archivos.

## 3. Certificados SSL

El proxy nginx exige un certificado para arrancar en el puerto 443. Dos opciones:

### Opción A: Let's Encrypt (certbot)

Con el DNS ya apuntando al servidor:

```bash
docker run --rm -p 80:80 -v "$(pwd)/certs:/etc/letsencrypt" \
  certbot/certbot certonly --standalone -d nomina.unefm.edu.ve
```

Luego mover los certificados donde los espera el proxy:

```bash
cp certs/live/nomina.unefm.edu.ve/fullchain.pem certs/nomina.unefm.edu.ve.crt
cp certs/live/nomina.unefm.edu.ve/privkey.pem  certs/private/nomina.unefm.edu.ve.key
```

### Opción B: Certificados de la universidad

Si UNEFM entrega los certificados, colocarlos directamente:

```
certs/nomina.unefm.edu.ve.crt
certs/private/nomina.unefm.edu.ve.key
```

> Sin estos archivos nginx **no arranca** (`nomina-unefm-proxy` queda reiniciando).

## 4. Base de datos Oracle

Confirmar que `application/config/database.php` apunte a la base correcta
(por defecto `150.187.4.18:1521`, servicio `orcl.cuji2.unefm.edu.ve`). Probar
el acceso desde el servidor antes del despliegue.

## 5. Despliegue

```bash
cd /ruta/al/repositorio/nomina-unefm
git pull

# Construir (primera vez) y levantar servicios
docker compose up -d --build

# Ver estado
docker compose ps

# Ver logs
docker compose logs -f app
docker compose logs -f proxy
```

Esto levanta dos contenedores en la red `nomina_net`:
- `nomina-unefm-app`: aplicación (Apache + PHP 7.4 + OCI8), expone solo puerto interno 80.
- `nomina-unefm-proxy`: nginx como reverse proxy en los puertos `80/443`.

## 6. Verificación

- `https://nomina.unefm.edu.ve` → redirige HTTP a HTTPS y carga el login.
- Generar una constancia de trabajo y escanear el QR → debe abrir
  `https://nomina.unefm.edu.ve/validar_constancia/index/<token>`.
- La página de validación debe mostrar el estado de la constancia y los días de vigencia.

## Notas

- No usar `docker-compose.dev.yml` en producción (es solo para desarrollo local).
- Al hacer `docker compose up -d` desde el proyecto **no** sobrescribir `APP_URL`.
- Copiar/actualizar el repositorio en el servidor con `git pull` y `docker compose up -d --build` para desplegar nuevas versiones.