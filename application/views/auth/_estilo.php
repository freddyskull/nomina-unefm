<?php
/**
 * Estilo compartido de las pantallas de autenticacion de nomina-unefm.
 * Variables opcionales:
 *   $auth_width    Clase de ancho de la tarjeta (max-w-md / max-w-lg / max-w-2xl)
 */
$auth_width = isset($auth_width) ? $auth_width : 'max-w-lg';
?>
<style>
    body {
        background:
            radial-gradient(1200px 600px at 8% -8%, #dbeafe 0%, transparent 55%),
            radial-gradient(1000px 520px at 100% 8%, #e0e7ff 0%, transparent 50%),
            radial-gradient(900px 600px at 50% 115%, #bfdbfe 0%, transparent 55%),
            linear-gradient(160deg, #f8fbff 0%, #eff6ff 100%);
        min-height: 100vh;
    }

    /* ---------- Transicion entre pantallas ----------
       View Transitions API: el navegador interpola la pagina vieja y la
       nueva al navegar. Fallback: el fade-in de abajo cubre el resto. */
    @view-transition { navigation: auto; }

    ::view-transition-old(root) {
        animation: vt-out .26s cubic-bezier(.4, 0, 1, 1) both;
    }
    ::view-transition-new(root) {
        animation: vt-in .42s cubic-bezier(.16, 1, .3, 1) both;
    }

    @keyframes vt-out {
        to { opacity: 0; transform: translateY(-10px) scale(.99); }
    }
    @keyframes vt-in {
        from { opacity: 0; transform: translateY(14px) scale(.99); }
    }

    /* Fallback / primer render */
    @keyframes pageIn {
        from { opacity: 0; transform: translateY(10px); }
    }
    .auth-shell { animation: pageIn .5s cubic-bezier(.16, 1, .3, 1) both; }

    /* ---------- Fondo animado ---------- */
    .blob {
        position: absolute;
        border-radius: 9999px;
        filter: blur(42px);
        pointer-events: none;
    }
    .card-glow {
        box-shadow: 0 24px 60px -18px rgba(37,99,235,.35), 0 8px 24px -12px rgba(15,23,42,.12);
    }

    /* ---------- Campos ----------
       El icono se centra con flex (no con transform), de modo que su
       desplazamiento horizontal no puede alterar el alto del input.
       Por eso el input mantiene siempre el mismo padding y borde de 2px:
       el foco se dibuja con un anillo superpuesto, sin salto de layout. */
    .field-icon {
        display: inline-block;
        color: #94a3b8;
        will-change: transform;
        transition:
            transform .38s cubic-bezier(.34, 1.4, .5, 1),
            color .3s ease;
    }
    .field:hover .field-icon { color: #64748b; }
    .field:focus-within .field-icon {
        color: #2563eb;
        transform: translateX(4px);
    }

    .field-ring {
        opacity: 0;
        transform: scale(.97);
        pointer-events: none;
        transition:
            opacity .3s ease,
            transform .38s cubic-bezier(.34, 1.4, .5, 1);
    }
    .field:focus-within .field-ring {
        opacity: 1;
        transform: scale(1);
    }

    .field input {
        transition:
            background-color .3s ease,
            border-color .3s ease,
            box-shadow .3s ease;
    }

    /* ---------- Botones ---------- */
    .btn-press {
        transition:
            transform .22s cubic-bezier(.34, 1.4, .5, 1),
            box-shadow .3s ease,
            background-position .4s ease;
    }
    .btn-press:hover { transform: translateY(-2px); }
    .btn-press:active { transform: translateY(1px) scale(.99); }

    /* Transicion suave de los iconos dentro de botones */
    .btn-press i { transition: transform .32s cubic-bezier(.34, 1.4, .5, 1); }

    /* ---------- Tarjetas de opcion (radio) ---------- */
    .opt-card {
        transition:
            background-color .3s ease,
            border-color .3s ease,
            box-shadow .3s ease,
            transform .22s cubic-bezier(.34, 1.4, .5, 1);
    }
    .opt-card:hover { transform: translateY(-2px); }
    .opt-card i { transition: transform .3s cubic-bezier(.34, 1.4, .5, 1), color .3s ease; }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>
