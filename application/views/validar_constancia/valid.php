<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Validación de Constancia - UNEFM</title>
    <link rel="shortcut icon" href="<?php echo base_url('assets/ico/logo1.png')?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#163aa5',
                        'primary-dark': '#0e2a7a',
                    },
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                }
            }
        }
    </script>
    <style type="text/css">
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-lg">
        <div class="text-center mb-6">
            <img src="<?php echo base_url('source/img/LOGO UNEFM.png')?>" class="h-12 mx-auto w-auto" alt="Logo UNEFM">
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            <div class="p-8 border-b border-slate-200 bg-emerald-50 border-l-4 border-l-emerald-500">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-white flex items-center justify-center text-emerald-600 shadow-sm flex-shrink-0">
                        <i class="fa-solid fa-circle-check text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-emerald-800">Documento Válido</h1>
                        <p class="text-sm text-emerald-600">Esta constancia es auténtica y está vigente.</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                        <i class="fa-solid fa-user text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trabajador(a)</p>
                        <p class="font-bold text-slate-800 truncate">
                            <?php echo isset($empleado) ? $empleado['nombre'] . ' ' . $empleado['apellido'] : 'No identificado'; ?>
                        </p>
                        <p class="text-sm text-slate-500">Cédula: <?php echo $cedula; ?></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Emitida el</p>
                        <p class="font-bold text-slate-700"><?php echo $emision; ?></p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Válida hasta</p>
                        <p class="font-bold text-slate-700"><?php echo $expiracion; ?></p>
                    </div>
                </div>

                <div class="mt-4 p-4 bg-emerald-100/70 border border-emerald-200 rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-hourglass-half text-emerald-700"></i>
                    <p class="text-sm text-emerald-900 font-semibold">
                        Vigencia restante: <span><?php echo max($dias_restantes, 0); ?> día<?php echo $dias_restantes == 1 ? '' : 's'; ?></span>
                    </p>
                </div>

                <div class="mt-5 p-4 bg-blue-50 border border-blue-100 rounded-2xl flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-blue-600 mt-0.5"></i>
                    <p class="text-sm text-blue-800 leading-relaxed">
                        Documento emitido por la Dirección de Recursos Humanos de la UNEFM, válido por 3 meses a partir de su fecha de emisión.
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>