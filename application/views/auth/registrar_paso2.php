<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro de Datos | Constancia de trabajo y nómina</title>
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

    <div class="w-full max-w-2xl bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-slate-200 my-10">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Completa tu Registro</h1>
                <p class="text-slate-500 text-sm">Paso 2: Datos de acceso y seguridad</p>
            </div>
            <div class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100">
                <i class="fa-solid fa-check mr-1"></i> Identidad Verificada
            </div>
        </div>

        <div class="bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-100">
            <?php foreach ($datosemp as $row): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-slate-400 font-bold text-[10px] uppercase block mb-1">Nombre Completo</span>
                        <span class="font-bold text-slate-700"><?php echo $row[2] . ' ' . $row[3]; ?></span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold text-[10px] uppercase block mb-1">Cédula</span>
                        <span class="font-bold text-slate-700"><?php echo number_format($row[1], 0, ',', '.'); ?></span>
                    </div>
                </div>
                <?php 
                $cedula = $row[1];
                $tipoper = $row[0];
                ?>
            <?php endforeach; ?>
        </div>

        <?php echo form_open('auth/procesar_registro', ['class' => 'space-y-8']);?>
            
            <input type="hidden" name="cedula" value="<?php echo $cedula; ?>">
            <input type="hidden" name="tipoper" value="<?php echo $tipoper; ?>">

            <!-- Acceso Section -->
            <div class="space-y-6">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-key text-[10px]"></i> Datos de Acceso
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="us" class="block text-sm font-bold text-slate-700 ml-1">Usuario</label>
                        <input type="text" id="us" name="us" required 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                            placeholder="Ej: jperez">
                    </div>
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-bold text-slate-700 ml-1">Correo Electrónico</label>
                        <input type="email" id="email" name="email" required 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                            placeholder="ejemplo@unefm.edu.ve">
                    </div>
                    <div class="space-y-2">
                        <label for="clave" class="block text-sm font-bold text-slate-700 ml-1">Contraseña</label>
                        <input type="password" id="clave" name="clave" required 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                            placeholder="••••••••">
                    </div>
                    <div class="space-y-2">
                        <label for="clave2" class="block text-sm font-bold text-slate-700 ml-1">Confirmar Contraseña</label>
                        <input type="password" id="clave2" name="clave2" required 
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                            placeholder="••••••••">
                    </div>
                </div>
            </div>

            <!-- Seguridad Section -->
            <div class="space-y-6 pt-4">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-[10px]"></i> Seguridad de la Cuenta
                </h3>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Pregunta de Seguridad 1</label>
                            <input type="text" name="preg" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold" placeholder="Ej: Nombre de mascota">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Respuesta 1</label>
                            <input type="text" name="resp" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold" placeholder="Respuesta">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Pregunta de Seguridad 2</label>
                            <input type="text" name="preg2" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold" placeholder="Ej: Ciudad de nacimiento">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 ml-1">Respuesta 2</label>
                            <input type="text" name="resp2" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold" placeholder="Respuesta">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-4">
                <a href="<?php echo site_url('auth/registrar') ?>" class="text-slate-400 font-bold text-sm hover:text-slate-600 px-6 py-4">Volver</a>
                <button type="submit" 
                    class="w-full sm:w-auto bg-primary hover:bg-primary-dark text-white font-bold px-12 py-4 rounded-2xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 group">
                    <span>Finalizar Registro</span>
                    <i class="fa-solid fa-check text-xs group-hover:scale-125 transition-transform"></i>
                </button>
            </div>
        <?php echo form_close(); ?>

    </div>

    <footer class="mt-10 text-center pb-10">
        <p class="text-xs text-slate-400 uppercase tracking-widest">&copy; <?php echo date("Y"); ?> UNEFM | Rectorado</p>
    </footer>

    <!-- FontAwesome icon support -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
