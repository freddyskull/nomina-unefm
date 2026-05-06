<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($title) ? $title . ' | ' : ''; ?>Constancia de trabajo y nómina</title>
    <link rel="shortcut icon" href="<?php echo base_url('assets/ico/logo1.png')?>">
    
    <!-- Tailwind CSS Play CDN (Para desarrollo y previsualización rápida) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Outfit (Minimalista y legible) -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#163aa5',
                        'primary-dark': '#0e2a7a',
                        institutional: '#1e293b',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style type="text/css">
        body { font-family: 'Outfit', sans-serif; }
        .micro-anim { transition: all 0.2s ease-in-out; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
    
    <!-- Sidebar Navigation -->
    <div class="min-h-screen flex">
        
        <!-- Sidebar (Desktop) -->
        <aside class="w-64 bg-white border-r border-slate-300 hidden lg:flex flex-col sticky top-0 h-screen shadow-lg">
            <div class="p-6 border-b border-slate-200 flex items-center justify-center">
                <img src="<?php echo base_url('source/img/LOGO UNEFM.png')?>" class="h-12 w-auto" alt="Logo UNEFM">
            </div>
            
            <?php 
                $s1 = $this->uri->segment(1);
                $s2 = $this->uri->segment(2);
                $active_class = "bg-primary/10 text-primary border-primary/20";
                $inactive_class = "text-slate-600 hover:bg-slate-50 hover:text-primary border-transparent";
            ?>
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="<?php echo site_url('dashboard') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all border <?php echo ($s1 == 'dashboard') ? $active_class : $inactive_class; ?>">
                    <i class="fa-solid fa-house w-5"></i>
                    <span class="font-medium">Inicio</span>
                </a>
                
                <div class="pt-4 pb-2 px-4">
                    <span class="text-xs font-bold text-slate-600 uppercase tracking-widest">Servicios</span>
                </div>
                
                <a href="<?php echo site_url('payroll/constancias') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all border <?php echo ($s1 == 'payroll' && $s2 == 'constancias') ? $active_class : $inactive_class; ?>">
                    <i class="fa-solid fa-file-contract w-5"></i>
                    <span class="font-medium">Constancias</span>
                </a>
                
                <a href="<?php echo site_url('payroll/nominas') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all border <?php echo ($s1 == 'payroll' && $s2 == 'nominas') ? $active_class : $inactive_class; ?>">
                    <i class="fa-solid fa-receipt w-5"></i>
                    <span class="font-medium">Nóminas</span>
                </a>

                <a href="<?php echo site_url('payroll/arc') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all border <?php echo ($s1 == 'payroll' && $s2 == 'arc') ? $active_class : $inactive_class; ?>">
                    <i class="fa-solid fa-file-invoice-dollar w-5"></i>
                    <span class="font-medium">Planilla ARC</span>
                </a>

                <a href="<?php echo site_url('payroll/adelanto_prestaciones') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all border <?php echo ($s1 == 'payroll' && $s2 == 'adelanto_prestaciones') ? $active_class : $inactive_class; ?>">
                    <i class="fa-solid fa-hand-holding-dollar w-5"></i>
                    <span class="font-medium">Adelanto Prest.</span>
                </a>

                <a href="<?php echo site_url('payroll/iiiccu') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all border <?php echo ($s1 == 'payroll' && $s2 == 'iiiccu') ? $active_class : $inactive_class; ?>">
                    <i class="fa-solid fa-file-contract w-5"></i>
                    <span class="font-medium">Detalle III CCU</span>
                </a>

                <div class="pt-4 pb-2 px-4">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Usuario</span>
                </div>

                <a href="<?php echo site_url('profile') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all border <?php echo ($s1 == 'profile') ? $active_class : $inactive_class; ?>">
                    <i class="fa-solid fa-user-gear w-5"></i>
                    <span class="font-medium">Mi Perfil</span>
                </a>

                <a href="<?php echo site_url('auth/logout') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 text-red-600 transition-colors">
                    <i class="fa-solid fa-right-from-bracket w-5"></i>
                    <span class="font-medium">Cerrar Sesión</span>
                </a>
            </nav>
            
            <div class="p-6 border-t border-slate-200 bg-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                        <?php echo substr($sesion, 0, 1); ?>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-semibold truncate"><?php echo $sesion; ?></p>
                        <p class="text-[10px] text-slate-500 uppercase font-bold tracking-tight truncate">
                            <?php echo $this->session->userdata('tipo_personal') . ' / ' . $this->session->userdata('condicion'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-slate-50">
            
            <!-- Mobile Header -->
            <header class="lg:hidden bg-white border-b border-slate-300 p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img src="<?php echo base_url('source/img/LOGO UNEFM.png')?>" class="h-8 w-auto" alt="Logo UNEFM">
                </div>
                <button class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </header>

            <!-- Page Content -->
            <div class="p-6 lg:p-10 max-w-7xl w-full mx-auto">
