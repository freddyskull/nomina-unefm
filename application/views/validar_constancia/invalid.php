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
            <div class="p-8 border-b border-slate-200 bg-red-50 border-l-4 border-l-red-500">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-white flex items-center justify-center text-red-600 shadow-sm flex-shrink-0">
                        <i class="fa-solid fa-circle-xmark text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-red-800">Documento No Válido</h1>
                        <p class="text-sm text-red-600">El código de validación no corresponde a una constancia emitida por este sistema.</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 flex items-start gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 mt-0.5"></i>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Si recibió este documento por una vía que no sea el sistema oficial de constancias de la UNEFM,
                        <strong>no lo acepte</strong> y repórtelo al departamento de Recursos Humanos.
                    </p>
                </div>

                <div class="mt-5 p-4 bg-blue-50 border border-blue-100 rounded-2xl flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-blue-600 mt-0.5"></i>
                    <p class="text-sm text-blue-800 leading-relaxed">
                        Para solicitar una constancia oficial, el trabajador debe emitirla desde su portal de nómina.
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>