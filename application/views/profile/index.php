<div class="max-w-5xl mx-auto space-y-8">
    
    <div class="flex items-center gap-4">
        <a href="<?php echo site_url('dashboard') ?>" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Configuración de Perfil</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Navigation/General Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 text-center border-t-4 border-t-primary">
                <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center text-primary text-3xl font-bold mx-auto mb-4 border-4 border-white shadow-sm">
                    <?php echo substr($sesion, 0, 1); ?>
                </div>
                <h2 class="text-xl font-bold text-slate-900"><?php echo $sesion; ?></h2>
                <p class="text-slate-500 text-sm mb-6 uppercase tracking-wider font-semibold"><?php echo $this->session->userdata('tipoper') == '01' ? 'Personal Docente' : 'Personal Administrativo/Obrero'; ?></p>
                
                <div class="space-y-2">
                    <a href="<?php echo site_url('profile/editar_clave') ?>" class="block w-full px-4 py-2.5 bg-slate-50 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-100 transition-colors">
                        Cambiar Contraseña
                    </a>
                    <a href="<?php echo site_url('profile/editar_correo') ?>" class="block w-full px-4 py-2.5 bg-slate-50 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-100 transition-colors">
                        Cambiar Correo
                    </a>
                    <a href="<?php echo site_url('profile/editar_preyres') ?>" class="block w-full px-4 py-2.5 bg-slate-50 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-100 transition-colors">
                        Preguntas de Seguridad
                    </a>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-100 p-6 rounded-3xl">
                <p class="text-blue-800 text-xs font-bold uppercase tracking-widest mb-2">Ayuda del Sistema</p>
                <p class="text-blue-700 text-sm leading-relaxed">Si detectas errores en tus datos personales, por favor contacta al Departamento de Registro y Control para su actualización.</p>
            </div>
        </div>

        <!-- Right: Detailed Info -->
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-200 bg-slate-50 flex items-center justify-between border-l-4 border-l-primary">
                    <h3 class="font-bold text-slate-800">Información de la Cuenta</h3>
                    <span class="text-xs px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full font-bold">Estado: Activo</span>
                </div>
                <div class="p-8">
                    <?php if (isset($empleado) && !empty($empleado)): ?>
                        <?php foreach ($empleado as $e): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Cédula</p>
                                    <p class="font-semibold text-slate-700"><?php echo number_format($e[0], 0, ',', '.'); ?></p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rif</p>
                                    <p class="font-semibold text-slate-700"><?php echo $e[9] ?: 'No registrado'; ?></p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Correo Electrónico</p>
                                    <p class="font-semibold text-slate-700"><?php echo $e[5]; ?></p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Teléfono</p>
                                    <p class="font-semibold text-slate-700"><?php echo $e[4] ?: 'No registrado'; ?></p>
                                </div>
                                <div class="md:col-span-2 space-y-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dirección de Habitación</p>
                                    <p class="font-semibold text-slate-700"><?php echo $e[3] ?: 'No registrada'; ?></p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Fecha de Nacimiento</p>
                                    <p class="font-semibold text-slate-700"><?php echo $e[6]; ?></p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lugar de Nacimiento</p>
                                    <p class="font-semibold text-slate-700"><?php echo $e[7] . ', ' . $e[8]; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>
</div>
