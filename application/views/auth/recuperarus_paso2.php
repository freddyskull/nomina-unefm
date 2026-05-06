<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seguridad | Constancia de trabajo y nómina</title>
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
            <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary text-xl">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Preguntas de Seguridad</h1>
                <p class="text-slate-500 text-sm">Responde para recuperar tus credenciales</p>
            </div>
        </div>

        <?php echo form_open('auth/procesar_recuperacion', ['class' => 'space-y-6']);?>
            
            <?php foreach ($preguntas as $row): ?>
                <input type="hidden" name="cedula" value="<?php echo $row[2]; ?>">
                <input type="hidden" name="tipoper" value="<?php echo $row[3]; ?>">
                
                <div class="space-y-4">
                    <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pregunta 1</label>
                        <p class="font-bold text-slate-700 mb-4"><?php echo $row[0]; ?></p>
                        <input type="text" name="respuesta" required 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                            placeholder="Tu respuesta">
                    </div>

                    <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pregunta 2</label>
                        <p class="font-bold text-slate-700 mb-4"><?php echo $row[1]; ?></p>
                        <input type="text" name="respuesta2" required 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                            placeholder="Tu respuesta">
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="pt-4 flex items-center justify-between gap-4">
                <a href="<?php echo site_url('auth/recuperarus') ?>" class="text-slate-400 font-bold text-sm hover:text-slate-600">Volver</a>
                <button type="submit" 
                    class="bg-primary hover:bg-primary-dark text-white font-bold px-10 py-4 rounded-2xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 group">
                    <span>Recuperar Datos</span>
                    <i class="fa-solid fa-unlock-keyhole text-xs group-hover:scale-125 transition-transform"></i>
                </button>
            </div>
        <?php echo form_close(); ?>

    </div>

    <footer class="mt-10 text-center">
        <p class="text-xs text-slate-400 uppercase tracking-widest">&copy; <?php echo date("Y"); ?> UNEFM | Rectorado</p>
    </footer>

    <!-- FontAwesome icon support -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
