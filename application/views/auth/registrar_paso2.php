<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro de Datos | Constancia de trabajo y nómina</title>
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
    <?php $auth_width = 'max-w-2xl'; include 'application/views/auth/_estilo.php'; ?>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-6 antialiased text-slate-800 relative overflow-hidden">

    <div class="blob w-72 h-72 bg-primary/25 -top-16 -left-16 animate-float-slow"></div>
    <div class="blob w-80 h-80 bg-indigo-300/25 bottom-0 -right-20 animate-float-slow"></div>
    <div class="blob w-48 h-48 bg-primary-light/25 top-1/3 left-1/4 animate-float-slow"></div>

    <div class="w-full <?php echo $auth_width; ?> relative z-10 auth-shell my-6">

        <div class="bg-white/90 backdrop-blur-xl p-7 md:p-9 rounded-3xl card-glow ring-1 ring-white/60">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-7">
                <div class="text-center md:text-left">
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight bg-gradient-to-r from-primary via-primary-light to-primary-dark bg-clip-text text-transparent">
                        ¡Casi listo!
                    </h1>
                    <p class="text-slate-500 text-sm mt-1 font-medium">Paso 2: Datos de acceso y seguridad</p>
                </div>
                <div class="inline-flex items-center justify-center px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100 self-center md:self-auto">
                    <i class="fa-solid fa-circle-check mr-1.5"></i> Identidad Verificada
                </div>
            </div>

            <div class="bg-primary-pale/40 rounded-2xl p-5 mb-7 border border-primary/10">
                <?php foreach ($datosemp as $row): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-primary font-bold text-[10px] uppercase block mb-1">Nombre Completo</span>
                            <span class="font-bold text-slate-700"><?php echo $row[2] . ' ' . $row[3]; ?></span>
                        </div>
                        <div>
                            <span class="text-primary font-bold text-[10px] uppercase block mb-1">Cédula</span>
                            <span class="font-bold text-slate-700"><?php echo number_format($row[1], 0, ',', '.'); ?></span>
                        </div>
                    </div>
                    <?php
                    $cedula = $row[1];
                    $tipoper = $row[0];
                    ?>
                <?php endforeach; ?>
            </div>

            <?php echo form_open('auth/procesar_registro', ['class' => 'space-y-7']);?>

                <input type="hidden" name="cedula" value="<?php echo $cedula; ?>">
                <input type="hidden" name="tipoper" value="<?php echo $tipoper; ?>">

                <div class="space-y-5">
                    <h3 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-key text-[10px]"></i> Datos de Acceso
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="field">
                            <label for="us" class="block text-sm font-semibold mb-2 text-slate-700">Usuario</label>
                            <div class="relative">
                                <span class="absolute left-4 inset-y-0 flex items-center pointer-events-none"><i class="fa-solid fa-user field-icon"></i></span>
                                <input type="text" id="us" name="us" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-primary-pale/40 border-2 border-transparent rounded-2xl focus:outline-none focus:bg-white transition-all placeholder:text-slate-400 font-medium"
                                    placeholder="Ej: jperez">
                                <span class="field-ring absolute inset-0 rounded-2xl ring-2 ring-primary/40 pointer-events-none"></span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="email" class="block text-sm font-semibold mb-2 text-slate-700">Correo Electrónico</label>
                            <div class="relative">
                                <span class="absolute left-4 inset-y-0 flex items-center pointer-events-none"><i class="fa-solid fa-envelope field-icon"></i></span>
                                <input type="email" id="email" name="email" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-primary-pale/40 border-2 border-transparent rounded-2xl focus:outline-none focus:bg-white transition-all placeholder:text-slate-400 font-medium"
                                    placeholder="ejemplo@unefm.edu.ve">
                                <span class="field-ring absolute inset-0 rounded-2xl ring-2 ring-primary/40 pointer-events-none"></span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="clave" class="block text-sm font-semibold mb-2 text-slate-700">Contraseña</label>
                            <div class="relative">
                                <span class="absolute left-4 inset-y-0 flex items-center pointer-events-none"><i class="fa-solid fa-lock field-icon"></i></span>
                                <input type="password" id="clave" name="clave" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-primary-pale/40 border-2 border-transparent rounded-2xl focus:outline-none focus:bg-white transition-all placeholder:text-slate-400 font-medium"
                                    placeholder="••••••••">
                                <span class="field-ring absolute inset-0 rounded-2xl ring-2 ring-primary/40 pointer-events-none"></span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="clave2" class="block text-sm font-semibold mb-2 text-slate-700">Confirmar Contraseña</label>
                            <div class="relative">
                                <span class="absolute left-4 inset-y-0 flex items-center pointer-events-none"><i class="fa-solid fa-lock field-icon"></i></span>
                                <input type="password" id="clave2" name="clave2" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-primary-pale/40 border-2 border-transparent rounded-2xl focus:outline-none focus:bg-white transition-all placeholder:text-slate-400 font-medium"
                                    placeholder="••••••••">
                                <span class="field-ring absolute inset-0 rounded-2xl ring-2 ring-primary/40 pointer-events-none"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-5 pt-2">
                    <h3 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-[10px]"></i> Seguridad de la Cuenta
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="field">
                            <label class="block text-sm font-semibold mb-2 text-slate-700">Pregunta de Seguridad 1</label>
                            <input type="text" name="preg" required class="w-full px-4 py-3.5 bg-primary-pale/40 border-2 border-transparent rounded-2xl focus:outline-none focus:bg-white transition-all placeholder:text-slate-400 font-medium" placeholder="Ej: Nombre de mascota">
                        </div>
                        <div class="field">
                            <label class="block text-sm font-semibold mb-2 text-slate-700">Respuesta 1</label>
                            <input type="text" name="resp" required class="w-full px-4 py-3.5 bg-primary-pale/40 border-2 border-transparent rounded-2xl focus:outline-none focus:bg-white transition-all placeholder:text-slate-400 font-medium" placeholder="Respuesta">
                        </div>
                        <div class="field">
                            <label class="block text-sm font-semibold mb-2 text-slate-700">Pregunta de Seguridad 2</label>
                            <input type="text" name="preg2" required class="w-full px-4 py-3.5 bg-primary-pale/40 border-2 border-transparent rounded-2xl focus:outline-none focus:bg-white transition-all placeholder:text-slate-400 font-medium" placeholder="Ej: Ciudad de nacimiento">
                        </div>
                        <div class="field">
                            <label class="block text-sm font-semibold mb-2 text-slate-700">Respuesta 2</label>
                            <input type="text" name="resp2" required class="w-full px-4 py-3.5 bg-primary-pale/40 border-2 border-transparent rounded-2xl focus:outline-none focus:bg-white transition-all placeholder:text-slate-400 font-medium" placeholder="Respuesta">
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <a href="<?php echo site_url('auth/registrar') ?>" class="text-slate-400 font-bold text-sm hover:text-primary transition-colors px-6 py-3">Volver</a>
                    <button type="submit"
                        class="btn-press w-full sm:w-auto bg-gradient-to-r from-primary to-primary-dark hover:from-primary-dark hover:to-primary text-white font-bold px-12 py-4 rounded-2xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 flex items-center justify-center gap-2 group">
                        <span>Finalizar Registro</span>
                        <i class="fa-solid fa-check text-xs group-hover:scale-125 transition-transform"></i>
                    </button>
                </div>
            <?php echo form_close(); ?>
        </div>

        <div class="mt-6 flex items-center justify-center gap-2 text-xs text-slate-400 font-medium">
            <i class="fa-solid fa-shield-halved text-emerald-400"></i>
            <span>Tus datos se protegen con cifrado</span>
        </div>

        <footer class="mt-8 text-center">
            <p class="text-xs text-slate-400 uppercase tracking-widest">&copy; <?php echo date("Y"); ?> UNEFM | Rectorado</p>
        </footer>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
