<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Iniciar Sesión | Constancia de trabajo y nómina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url('assets/ico/logo1.png')?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#2563eb', 'primary-dark': '#1d4ed8' },
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col items-center justify-center p-6 antialiased text-slate-800">

    <div class="w-full max-w-md bg-white p-8 md:p-10 rounded-2xl shadow-sm border border-slate-200">
        
        <div class="flex flex-col items-center mb-8">
            <img src="<?php echo base_url('assets/ico/logo1.png')?>" alt="Logo" class="h-16 w-auto mb-4">
            <h1 class="text-2xl font-bold tracking-tight">Bienvenido</h1>
            <p class="text-slate-500 text-sm mt-1">Gestión de Constancias y Nóminas</p>
        </div>

        <?php if ($this->session->flashdata('mensaje')): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-600 text-sm rounded-xl flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span><?php echo $this->session->flashdata('mensaje'); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('mensaje_exito')): ?>
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm rounded-xl flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i>
                <span><?php echo $this->session->flashdata('mensaje_exito'); ?></span>
            </div>
        <?php endif; ?>

        <?php echo form_open('auth/ingresar', ['class' => 'space-y-6']);?>
            <div>
                <label for="usuario" class="block text-sm font-medium mb-2 text-slate-700">Nombre de Usuario</label>
                <input type="text" id="usuario" name="usuario" required 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-slate-400"
                    placeholder="Tu usuario institucional">
            </div>
            
            <div>
                <div class="flex justify-between mb-2">
                    <label for="contra" class="text-sm font-medium text-slate-700">Contraseña</label>
                    <a href="<?php echo site_url('auth/recuperarus') ?>" class="text-xs text-primary font-semibold hover:underline">¿La olvidaste?</a>
                </div>
                <input type="password" id="contra" name="contra" required 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-slate-400"
                    placeholder="••••••••">
            </div>

            <button type="submit" 
                class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3.5 rounded-xl transition-all shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30 flex items-center justify-center gap-2 group">
                <span>Ingresar al Sistema</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        <?php echo form_close(); ?>

        <div class="mt-8 pt-8 border-t border-slate-100 text-center text-sm">
            <p class="text-slate-500">¿Aún no tienes una cuenta?</p>
            <a href="<?php echo site_url('auth/registrar') ?>" class="inline-block mt-2 font-bold text-primary hover:text-primary-dark transition-colors">Crea tu cuenta aquí</a>
        </div>
    </div>

    <footer class="mt-10 text-center">
        <img src="<?php echo base_url('source/img/pie_dire.png')?>" alt="Footer Logo" class="h-10 opacity-40 mx-auto mb-2">
        <p class="text-xs text-slate-400 uppercase tracking-widest">&copy; <?php echo date("Y"); ?> UNEFM | Rectorado</p>
    </footer>

    <!-- FontAwesome icon support -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
