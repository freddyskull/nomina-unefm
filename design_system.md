# Sistema de Diseño: Nómina Freddy (Edición Institucional)

Este documento define las pautas estéticas para la plataforma institucional, priorizando un estilo **Corporativo, Profesional y de Alto Rendimiento**. El objetivo es proyectar la identidad de la UNEFM con una interfaz moderna que transmita seriedad, confianza y eficiencia.

## 🏛️ Principios de Diseño Institucional
1. **Sobriedad Profesional**: Uso de colores sólidos y gradientes sutiles que eviten distracciones.
2. **Claridad Jerárquica**: Tipografía legible y espacios generosos para facilitar la lectura de datos administrativos.
3. **Identidad UNEFM**: Presencia clara del logo oficial y colores que armonicen con la imagen de la universidad.
4. **Eficiencia Técnica**: Optimización para todo tipo de hardware, asegurando que la herramienta sea accesible para todo el personal.

## 🎨 Paleta de Colores

| Elemento | Color | Hex | Uso |
| :--- | :--- | :--- | :--- |
| **Primario** | Indigo 600 | `#4f46e5` | Botones principales, enlaces, acentos. |
| **Primario Hover** | Indigo 700 | `#4338ca` | Estados hover de elementos primarios. |
| **Fondo** | Indigo 50 | `#eef2ff` | Color base para fondos y gradientes. |
| **Texto Principal** | Slate 800 | `#1e293b` | Títulos y cuerpo de texto importante. |
| **Texto Secundario** | Slate 500 | `#64748b` | Subtítulos, etiquetas y texto de apoyo. |
| **Error** | Red 600 | `#dc2626` | Mensajes de error y validaciones. |

## Typography 🖋️

- **Fuente Principal**: `Outfit` (Google Fonts).
- **Carga**: Se recomienda usar fuentes del sistema si la conexión es muy lenta, aunque Outfit es ligera.

## 📐 Componentes Base (Optimizado)

### Tarjetas (Cards)
- **Fondo**: `#ffffff` (Blanco sólido, sin transparencia).
- **Bordes**: `16px` (Radio más suave).
- **Contorno**: `1px solid #e0e7ff` (Tono acorde al nuevo fondo).
- **Sombra**: `0 10px 15px -3px rgba(0, 0, 0, 0.1)` (Sombra más profunda para mayor profundidad).

### Inputs
- **Bordes**: `1.5px solid #cbd5e1`.
- **Radio**: `10px`.
- **Foco**: Cambio de color de borde (evitar anillos de sombra si es posible).

### Botones
- **Interacción**: Cambios de color planos en hover (evitar transformaciones 3D o elevaciones).
- **Transición**: `0.15s linear` para una respuesta instantánea.

## ✨ Animaciones de Alto Rendimiento

- **Entrada**: `fadeIn` (Solo opacidad). Es la animación más barata de renderizar.
- **Evitar**: `backdrop-filter` (glassmorphism), desenfoques complejos y transformaciones de movimiento (`translate`, `scale`) en máquinas muy antiguas.

## 🛠️ Implementación Técnica

Referenciar `assets/css/login_modern.css` para las variables actualizadas:

```css
:root {
    --card-bg: #ffffff;
    --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}
```

---
> **Visión**: El diseño minimalista real es aquel que funciona bien en cualquier hardware. La velocidad es la característica estética más importante.
