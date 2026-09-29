<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro de Usuario | Constancia de trabajo y nómina</title>
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
    <?php $auth_width = 'max-w-lg'; include 'application/views/auth/_estilo.php'; ?>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-6 antialiased text-slate-800 relative overflow-hidden">

    <div class="blob w-72 h-72 bg-primary/25 -top-16 -left-16 animate-float-slow"></div>
    <div class="blob w-80 h-80 bg-indigo-300/25 bottom-0 -right-20 animate-float-slow"></div>
    <div class="blob w-48 h-48 bg-primary-light/25 top-1/3 left-1/4 animate-float-slow"></div>

    <div class="w-full <?php echo $auth_width; ?> relative z-10 auth-shell">

        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-white shadow-lg shadow-primary/20 ring-1 ring-primary/10 mb-4 relative">
                <img src="<?php echo base_url('assets/ico/logo1.png')?>" alt="Logo" class="h-12 w-auto">
                <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-primary ring-4 ring-white"></span>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-primary via-primary-light to-primary-dark bg-clip-text text-transparent">
                ¡Únete al equipo!
            </h1>
            <p class="text-slate-500 text-sm mt-1.5 font-medium">Crear tu cuenta de_constancias UNEFM</p>
        </div>

        <div class="bg-white/90 backdrop-blur-xl p-7 md:p-9 rounded-3xl card-glow ring-1 ring-white/60">

            <div class="flex items-center gap-3 mb-7">
                <a href="<?php echo site_url('auth') ?>" class="w-10 h-10 rounded-2xl bg-primary-pale/50 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all shrink-0">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="text-lg font-bold tracking-tight">Registro de Usuario</h2>
                    <p class="text-slate-500 text-xs font-medium">Paso 1: Verificación de Identidad</p>
                </div>
            </div>

            <?php if ($this->session->flashdata('mensaje')): ?>
                <div class="mb-5 p-4 bg-red-50 border border-red-100 text-red-600 text-sm rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-400"></i>
                    <span><?php echo $this->session->flashdata('mensaje'); ?></span>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('mensaje2')): ?>
                <div class="mb-5 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-400"></i>
                    <span><?php echo $this->session->flashdata('mensaje2'); ?></span>
                </div>
            <?php endif; ?>

            <?php echo form_open('auth/verificar_usuario', ['class' => 'space-y-6']);?>

                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Tipo de Personal</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="relative flex flex-col items-center p-4 opt-card rounded-2xl bg-primary-pale/30 border-2 border-transparent cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-white has-[:checked]:shadow-lg has-[:checked]:shadow-primary/20 group">
                            <input type="radio" name="tipoper" value="01" class="sr-only" required>
                            <i class="fa-solid fa-chalkboard-user text-xl mb-2 text-slate-400 group-has-[:checked]:text-primary"></i>
                            <span class="font-bold text-xs text-slate-600 group-has-[:checked]:text-primary">Docente</span>
                        </label>
                        <label class="relative flex flex-col items-center p-4 opt-card rounded-2xl bg-primary-pale/30 border-2 border-transparent cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-white has-[:checked]:shadow-lg has-[:checked]:shadow-primary/20 group">
                            <input type="radio" name="tipoper" value="02" class="sr-only">
                            <i class="fa-solid fa-user-tie text-xl mb-2 text-slate-400 group-has-[:checked]:text-primary"></i>
                            <span class="font-bold text-xs text-slate-600 group-has-[:checked]:text-primary">Administrativo</span>
                        </label>
                        <label class="relative flex flex-col items-center p-4 opt-card rounded-2xl bg-primary-pale/30 border-2 border-transparent cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-white has-[:checked]:shadow-lg has-[:checked]:shadow-primary/20 group">
                            <input type="radio" name="tipoper" value="03" class="sr-only">
                            <i class="fa-solid fa-toolbox text-xl mb-2 text-slate-400 group-has-[:checked]:text-primary"></i>
                            <span class="font-bold text-xs text-slate-600 group-has-[:checked]:text-primary">Obrero</span>
                        </label>
                    </div>
                </div>

                <div class="field">
                    <label for="cedula" class="block text-sm font-semibold mb-2 text-slate-700">Cédula de Identidad</label>
                    <div class="relative">
                        <span class="absolute left-4 inset-y-0 flex items-center pointer-events-none"><i class="fa-solid fa-id-card field-icon"></i></span>
                        <input type="number" id="cedula" name="cedula" required
                            class="w-full pl-11 pr-4 py-3.5 bg-primary-pale/40 border-2 border-transparent rounded-2xl focus:outline-none focus:bg-white transition-all placeholder:text-slate-400 font-medium"
                            placeholder="Ej: 12345678">
                        <span class="field-ring absolute inset-0 rounded-2xl ring-2 ring-primary/40 pointer-events-none"></span>
                    </div>
                    <p class="text-[11px] text-slate-400 font-medium mt-1.5 ml-1">Ingresa solo números, sin puntos ni letras.</p>
                </div>

                <button type="submit"
                    class="btn-press w-full bg-gradient-to-r from-primary to-primary-dark hover:from-primary-dark hover:to-primary text-white font-bold py-4 rounded-2xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 flex items-center justify-center gap-2 group">
                    <span>Verificar Identidad</span>
                    <i class="fa-solid fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </button>
            <?php echo form_close(); ?>
        </div>

        <div class="mt-6 flex items-center justify-center gap-2 text-xs text-slate-400 font-medium">
            <i class="fa-solid fa-lock text-emerald-400"></i>
            <span>Tus datos se tratan con confidencialidad</span>
        </div>

        <footer class="mt-8 text-center">
            <p class="text-xs text-slate-400 uppercase tracking-widest">&copy; <?php echo date("Y"); ?> UNEFM | Control de Personal</p>
        </footer>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
