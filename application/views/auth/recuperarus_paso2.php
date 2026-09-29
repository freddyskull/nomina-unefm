<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seguridad | Constancia de trabajo y nómina</title>
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
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-white shadow-lg shadow-primary/20 ring-1 ring-primary/10 mb-4">
                <i class="fa-solid fa-user-shield text-3xl text-primary"></i>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-primary via-primary-light to-primary-dark bg-clip-text text-transparent">
            Casi lo tienes
            </h1>
            <p class="text-slate-500 text-sm mt-1.5 font-medium">Responde para recuperar tus credenciales</p>
        </div>

        <div class="bg-white/90 backdrop-blur-xl p-7 md:p-9 rounded-3xl card-glow ring-1 ring-white/60">

            <?php echo form_open('auth/procesar_recuperacion', ['class' => 'space-y-5']);?>

                <?php foreach ($preguntas as $row): ?>
                    <input type="hidden" name="cedula" value="<?php echo $row[2]; ?>">
                    <input type="hidden" name="tipoper" value="<?php echo $row[3]; ?>">

                    <div class="space-y-4">
                        <div class="field p-5 bg-primary-pale/30 border border-primary/10 rounded-2xl">
                            <label class="block text-[10px] font-bold text-primary uppercase tracking-widest mb-2">Pregunta 1</label>
                            <p class="font-bold text-slate-700 mb-3"><?php echo $row[0]; ?></p>
                            <div class="relative">
                                <span class="absolute left-4 inset-y-0 flex items-center pointer-events-none"><i class="fa-solid fa-pen field-icon"></i></span>
                                <input type="text" name="respuesta" required
                                    class="w-full pl-11 pr-4 py-3 bg-white border-2 border-transparent rounded-xl focus:outline-none transition-all placeholder:text-slate-400 font-medium"
                                    placeholder="Tu respuesta">
                                <span class="field-ring absolute inset-0 rounded-xl ring-2 ring-primary/40 pointer-events-none"></span>
                            </div>
                        </div>

                        <div class="field p-5 bg-primary-pale/30 border border-primary/10 rounded-2xl">
                            <label class="block text-[10px] font-bold text-primary uppercase tracking-widest mb-2">Pregunta 2</label>
                            <p class="font-bold text-slate-700 mb-3"><?php echo $row[1]; ?></p>
                            <div class="relative">
                                <span class="absolute left-4 inset-y-0 flex items-center pointer-events-none"><i class="fa-solid fa-pen field-icon"></i></span>
                                <input type="text" name="respuesta2" required
                                    class="w-full pl-11 pr-4 py-3 bg-white border-2 border-transparent rounded-xl focus:outline-none transition-all placeholder:text-slate-400 font-medium"
                                    placeholder="Tu respuesta">
                                <span class="field-ring absolute inset-0 rounded-xl ring-2 ring-primary/40 pointer-events-none"></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="pt-4 flex items-center justify-between gap-4">
                    <a href="<?php echo site_url('auth/recuperarus') ?>" class="text-slate-400 font-bold text-sm hover:text-primary transition-colors">Volver</a>
                    <button type="submit"
                        class="btn-press bg-gradient-to-r from-primary to-primary-dark hover:from-primary-dark hover:to-primary text-white font-bold px-9 py-3.5 rounded-2xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 flex items-center justify-center gap-2 group">
                        <span>Recuperar Datos</span>
                        <i class="fa-solid fa-unlock-keyhole text-xs group-hover:scale-125 transition-transform"></i>
                    </button>
                </div>
            <?php echo form_close(); ?>
        </div>

        <div class="mt-6 flex items-center justify-center gap-2 text-xs text-slate-400 font-medium">
            <i class="fa-solid fa-shield-halved text-emerald-400"></i>
            <span>Verificación segura</span>
        </div>

        <footer class="mt-8 text-center">
            <p class="text-xs text-slate-400 uppercase tracking-widest">&copy; <?php echo date("Y"); ?> UNEFM | Rectorado</p>
        </footer>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
