# Despliegue en Producción

Pasos para publicar el Portal de Nómina UNEFM en el servidor de producción.

## 1. Requisitos en el servidor

- Docker Engine + Docker Compose (`docker compose` v2+).
- No se exponen puertos propios: la app queda interna y es servida por el
  **nginx compartido** de `unefm-municipalizacion` (`unefm-nginx`), que ya
  ocupa los puertos `80/443` del host.
- Acceso de red del servidor hacia Oracle: `150.187.4.18:1521`.

## 2. DNS

En el panel DNS de la universidad, registro A:

```
nomina.unefm.edu.ve  A  150.187.4.193
```

> ⚠️ Debe apuntar a la **misma IP** que `expediente.unefm.edu.ve`
> (`150.187.4.193`), porque ambos dominios los sirve el mismo nginx del host.
> Actualmente `nomina.*` apunta a `150.187.4.230`, lo cual no coincide con este
> servidor y dejaría el sitio inaccesible hasta corregirlo.

La app se configura por dominio (sin puerto):
- `docker-compose.yml` → `APP_URL=http://nomina.unefm.edu.ve`
- `nginx/nginx.conf` → `server_name nomina.unefm.edu.ve`

> Si el dominio final fuera otro, cambiar **ambos** archivos.

## 3. Arquitectura (por qué no hay puerto 8080)

`nomina-unefm` no publica ningún puerto en el host. Hay un solo nginx en la
máquina (`unefm-nginx` del proyecto `unefm-municipalizacion`) que escucha en
`80/443` y enruta por `server_name`:

```
Internet
   └─ expediente.unefm.edu.ve ──► unefm-nginx:80 ──► frontend:5173 / backend:3001
   └─ nomina.unefm.edu.ve    ──► unefm-nginx:80 ──► nomina-unefm-proxy:80 ──► nomina-unefm-app:80
```

Para que `unefm-nginx` alcance a los contenedores de nómina, se conectan a su
red. **Este paso hay que repetirlo cada vez que se cree de cero el contenedor
`unefm-nginx`**:

```bash
docker network connect nomina-unefm_nomina_net unefm-nginx
```

La parte de `nomina.unefm.edu.ve` está en el `nginx.conf` de
`unefm-municipalizacion` (server block propio, con `resolver` + variable para
seguir la IP de `nomina-unefm-proxy` sin reinicios). No tocar el puerto 8080:
ya no existe.

## 4. Base de datos Oracle

Confirmar que `application/config/database.php` apunte a la base correcta
(por defecto `150.187.4.18:1521`, servicio `orcl.cuji2.unefm.edu.ve`). Probar
el acceso desde el servidor antes del despliegue.

## 5. Despliegue

```bash
cd /ruta/al/repositorio/nomina-unefm
git pull

# Levantar/regenerar los contenedores de nómina (internos, sin puertos expuestos)
docker compose up -d

# Conectar el nginx compartido a la red de nómina (si falta)
docker network connect nomina-unefm_nomina_net unefm-nginx \
  || echo "ya conectado"

# Recargar el nginx compartido (desde el repo unefm-municipalizacion)
cd /ruta/unefm-municipalizacion
docker exec unefm-nginx nginx -t && docker exec unefm-nginx nginx -s reload
```

Contenedores de nómina en la red `nomina_net` (sin puertos publicados):
- `nomina-unefm-app`: aplicación (Apache + PHP 7.4 + OCI8).
- `nomina-unefm-proxy`: nginx reverse proxy interno (solo `expose: 80`).

## 6. Verificación

- `http://nomina.unefm.edu.ve` → carga el login.
- `http://nomina.unefm.edu.ve` **no** muestra `:8080` en ninguna URL/QR.
- `http://expediente.unefm.edu.ve` → sigue funcionando (no se rompe).
- Generar una constancia de trabajo y escanear el QR → debe abrir la URL de
  `validar_constancia/index/<token>` con `http://nomina.unefm.edu.ve/...`.

## Notas

- Si algún día se usa HTTPS con certificados, ambos dominios comparten el
  mismo cierre SSL en `unefm-nginx` (Let's Encrypt / certs de la universidad).
- Al hacer `docker compose down` en `unefm-municipalizacion` se regenera el
  nginx y hay que ejecutar de nuevo el `docker network connect` (paso 5).
