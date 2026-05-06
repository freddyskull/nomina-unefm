<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro de Usuario | Constancia de trabajo y nómina</title>
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

    <div class="w-full max-w-lg bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-slate-200">
        
        <div class="flex items-center gap-4 mb-8">
            <a href="<?php echo site_url('auth') ?>" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-primary transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Registro de Usuario</h1>
                <p class="text-slate-500 text-sm">Paso 1: Verificación de Identidad</p>
            </div>
        </div>

        <?php if ($this->session->flashdata('mensaje')): ?>
            <div class="mb-8 p-4 bg-red-50 border border-red-100 text-red-600 text-sm rounded-2xl flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span><?php echo $this->session->flashdata('mensaje'); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('mensaje2')): ?>
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm rounded-2xl flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i>
                <span><?php echo $this->session->flashdata('mensaje2'); ?></span>
            </div>
        <?php endif; ?>

        <?php echo form_open('auth/verificar_usuario', ['class' => 'space-y-8']);?>
            
            <div class="space-y-4">
                <label class="block text-sm font-bold text-slate-700 ml-1">Tipo de Personal</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <label class="relative flex flex-col items-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                        <input type="radio" name="tipoper" value="01" class="sr-only" required>
                        <i class="fa-solid fa-chalkboard-user text-xl mb-2 text-slate-400 group-has-[:checked]:text-primary"></i>
                        <span class="font-bold text-xs text-slate-600 group-has-[:checked]:text-primary">Docente</span>
                    </label>
                    <label class="relative flex flex-col items-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                        <input type="radio" name="tipoper" value="02" class="sr-only">
                        <i class="fa-solid fa-user-tie text-xl mb-2 text-slate-400 group-has-[:checked]:text-primary"></i>
                        <span class="font-bold text-xs text-slate-600 group-has-[:checked]:text-primary">Administrativo</span>
                    </label>
                    <label class="relative flex flex-col items-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                        <input type="radio" name="tipoper" value="03" class="sr-only">
                        <i class="fa-solid fa-toolbox text-xl mb-2 text-slate-400 group-has-[:checked]:text-primary"></i>
                        <span class="font-bold text-xs text-slate-600 group-has-[:checked]:text-primary">Obrero</span>
                    </label>
                </div>
            </div>

            <div class="space-y-2">
                <label for="cedula" class="block text-sm font-bold text-slate-700 ml-1">Cédula de Identidad</label>
                <input type="number" id="cedula" name="cedula" required 
                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                    placeholder="Ej: 12345678">
                <p class="text-[10px] text-slate-400 font-medium ml-1">Ingresa solo números, sin puntos ni letras.</p>
            </div>

            <button type="submit" 
                class="w-full bg-institutional hover:bg-slate-800 text-white font-bold py-4 rounded-2xl transition-all shadow-lg flex items-center justify-center gap-2 group">
                <span>Verificar Identidad</span>
                <i class="fa-solid fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </button>
        <?php echo form_close(); ?>

    </div>

    <footer class="mt-10 text-center">
        <p class="text-xs text-slate-400 uppercase tracking-widest">&copy; <?php echo date("Y"); ?> UNEFM | Control de Personal</p>
    </footer>

    <!-- FontAwesome icon support -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
