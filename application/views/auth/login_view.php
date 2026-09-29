<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Iniciar Sesión | Constancia de trabajo y nómina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url('assets/ico/logo1.png')?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        'primary-dark': '#1d4ed8',
                        'primary-light': '#60a5fa',
                        'primary-pale': '#dbeafe'
                    },
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    keyframes: {
                        floatSlow: {
                            '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
                            '50%': { transform: 'translate(14px, 18px) scale(1.08)' }
                        }
                    },
                    animation: {
                        'float-slow': 'floatSlow 14s ease-in-out infinite'
                    }
                }
            }
        }
    </script>
    <?php $auth_width = 'max-w-md'; include 'application/views/auth/_estilo.php'; ?>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-6 antialiased text-slate-800 relative overflow-hidden">

    <!-- Formas decorativas de fondo -->
    <div class="blob w-72 h-72 bg-primary/25 -top-16 -left-16 animate-float-slow"></div>
    <div class="blob w-80 h-80 bg-indigo-300/25 bottom-0 -right-20 animate-float-slow"></div>
    <div class="blob w-48 h-48 bg-primary-light/25 top-1/3 right-1/4 animate-float-slow"></div>

    <div class="w-full max-w-md relative z-10">

        <!-- Encabezado flotante -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-white shadow-lg shadow-primary/20 ring-1 ring-primary/10 mb-4 relative">
                <img src="<?php echo base_url('assets/ico/logo1.png')?>" alt="Logo" class="h-12 w-auto">
                <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-primary ring-4 ring-white"></span>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-primary via-primary-light to-primary-dark bg-clip-text text-transparent">
                ¡Hola de nuevo!
            </h1>
            <p class="text-slate-500 text-sm mt-1.5 font-medium">Constancias y nóminas UNEFM, en un solo lugar</p>
        </div>

        <!-- Tarjeta del formulario -->
        <div class="bg-white/90 backdrop-blur-xl p-7 md:p-9 rounded-3xl card-glow ring-1 ring-white/60">

            <?php if ($this->session->flashdata('mensaje')): ?>
                <div class="mb-5 p-4 bg-red-50 border border-red-100 text-red-600 text-sm rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-400"></i>
                    <span><?php echo $this->session->flashdata('mensaje'); ?></span>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('mensaje_exito')): ?>
                <div class="mb-5 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-400"></i>
                    <span><?php echo $this->session->flashdata('mensaje_exito'); ?></span>
                </div>
            <?php endif; ?>

            <?php echo form_open('auth/ingresar', ['class' => 'space-y-5']);?>

                <div class="field">
                    <label for="usuario" class="block text-sm font-semibold mb-2 text-slate-700">Nombre de Usuario</label>
                    <div class="relative">
                        <span class="absolute left-4 inset-y-0 flex items-center pointer-events-none"><i class="fa-solid fa-user field-icon"></i></span>
                        <input type="text" id="usuario" name="usuario" required autocomplete="username"
                            class="w-full pl-11 pr-4 py-3.5 bg-primary-pale/40 border-2 border-transparent rounded-2xl focus:outline-none focus:bg-white transition-all placeholder:text-slate-400 font-medium"
                            placeholder="Tu usuario institucional">
                        <span class="field-ring absolute inset-0 rounded-2xl ring-2 ring-primary/40 pointer-events-none"></span>
                    </div>
                </div>

                <div class="field">
                    <div class="flex justify-between items-center mb-2">
                        <label for="contra" class="text-sm font-semibold text-slate-700">Contraseña</label>
                        <a href="<?php echo site_url('auth/recuperarus') ?>" class="text-xs font-bold text-primary hover:text-primary-dark transition-colors">¿La olvidaste?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute left-4 inset-y-0 flex items-center pointer-events-none"><i class="fa-solid fa-lock field-icon"></i></span>
                        <input type="password" id="contra" name="contra" required autocomplete="current-password"
                            class="w-full pl-11 pr-4 py-3.5 bg-primary-pale/40 border-2 border-transparent rounded-2xl focus:outline-none focus:bg-white transition-all placeholder:text-slate-400 font-medium"
                            placeholder="••••••••">
                        <span class="field-ring absolute inset-0 rounded-2xl ring-2 ring-primary/40 pointer-events-none"></span>
                    </div>
                </div>

                <button type="submit"
                    class="btn-press w-full bg-gradient-to-r from-primary to-primary-dark hover:from-primary-dark hover:to-primary text-white font-bold py-4 rounded-2xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 flex items-center justify-center gap-2 group">
                    <span>Ingresar al Sistema</span>
                    <i class="fa-solid fa-arrow-right-long group-hover:translate-x-1 transition-transform"></i>
                </button>
            <?php echo form_close(); ?>

            <div class="mt-7 pt-6 border-t border-slate-100 text-center text-sm">
                <p class="text-slate-500">¿Aún no tienes una cuenta?</p>
                <a href="<?php echo site_url('auth/registrar') ?>" class="inline-flex items-center gap-1.5 mt-2 font-bold text-primary hover:text-primary-dark transition-colors">
                    <span>Crea tu cuenta aquí</span>
                    <i class="fa-solid fa-sparkles text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Franja de confianza -->
        <div class="mt-6 flex items-center justify-center gap-2 text-xs text-slate-400 font-medium">
            <i class="fa-solid fa-shield-halved text-emerald-400"></i>
            <span>Acceso seguro y encriptado</span>
        </div>

        <footer class="mt-8 text-center">
            <img src="<?php echo base_url('source/img/pie_dire.png')?>" alt="Footer Logo" class="h-10 opacity-50 mx-auto mb-2">
            <p class="text-xs text-slate-400 uppercase tracking-widest">&copy; <?php echo date("Y"); ?> UNEFM | Rectorado</p>
        </footer>
    </div>

    <!-- FontAwesome icon support -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
