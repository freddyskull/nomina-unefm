<div class="space-y-8">
    
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-8 rounded-3xl border border-slate-300 shadow-md">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Hola, <?php echo explode(' ', $sesion)[0]; ?></h1>
            <p class="text-slate-500 mt-1">Bienvenido a tu panel de gestión de nómina.</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo site_url('payroll/constancias') ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-primary text-white font-semibold text-sm transition-all hover:bg-primary-dark shadow-md shadow-primary/20">
                <i class="fa-solid fa-file-pdf mr-2"></i>
                Constancias
            </a>
            <a href="<?php echo site_url('payroll/nominas') ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 font-semibold text-sm transition-all hover:bg-slate-50 shadow-sm">
                <i class="fa-solid fa-file-invoice-dollar mr-2"></i>
                Nóminas
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <!-- Payroll Summary Card -->
            <?php if (isset($payroll_summary)): ?>
            <div class="bg-white rounded-3xl border border-slate-200 shadow-md overflow-hidden mb-8">
                <div class="px-8 py-5 border-b border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center justify-between border-l-4 border-l-primary gap-2">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-file-invoice-dollar text-primary"></i>
                        <h2 class="font-bold text-slate-800 tracking-tight">Estado de Pago Mensual</h2>
                    </div>
                    <div class="px-3 py-1 bg-primary/10 rounded-full">
                        <p class="text-[10px] font-black text-primary uppercase tracking-wider text-center">
                            <?php echo $payroll_summary['desnom']; ?>
                        </p>
                    </div>
                </div>
                
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Quincena 1 -->
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 flex flex-col items-center justify-center text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">1ra Quincena</p>
                            <div class="flex items-baseline gap-1">
                                <span class="text-xs font-bold text-slate-400">Bs.</span>
                                <span class="text-2xl font-bold text-slate-800 tracking-tight"><?php echo number_format($payroll_summary['quincena1'], 2, ',', '.'); ?></span>
                            </div>
                        </div>

                        <!-- Neto (Center & Most Important) -->
                        <div class="bg-primary/5 rounded-2xl p-6 border-2 border-primary/10 flex flex-col items-center justify-center text-center relative overflow-hidden group">
                            <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:opacity-20 transition-opacity">
                                <i class="fa-solid fa-money-bill-transfer text-4xl text-primary"></i>
                            </div>
                            <p class="text-[10px] font-black text-primary uppercase tracking-widest mb-2">Neto Total a Cobrar</p>
                            <div class="flex items-baseline gap-1">
                                <span class="text-sm font-bold text-primary/60">Bs.</span>
                                <span class="text-4xl font-black text-slate-900 tracking-tighter"><?php echo number_format($payroll_summary['neto'], 2, ',', '.'); ?></span>
                            </div>
                            <p class="text-[9px] text-slate-400 font-bold mt-3 uppercase">Monto estimado mensual</p>
                        </div>

                        <!-- Quincena 2 -->
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 flex flex-col items-center justify-center text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">2da Quincena</p>
                            <div class="flex items-baseline gap-1">
                                <span class="text-xs font-bold text-slate-400">Bs.</span>
                                <span class="text-2xl font-bold text-slate-800 tracking-tight"><?php echo number_format($payroll_summary['quincena2'], 2, ',', '.'); ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Personal Data Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-200 bg-slate-50 flex items-center justify-between border-l-4 border-l-primary">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-user text-primary"></i>
                        Datos Personales
                    </h2>
                    <a href="<?php echo site_url('profile') ?>" class="text-xs font-bold text-primary hover:underline">Ver detalles</a>
                </div>
                <div class="p-8">
                    <?php if (isset($datosper) && !empty($datosper)): ?>
                        <?php foreach ($datosper as $row): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Cédula de Identidad</p>
                                    <p class="text-lg font-semibold text-slate-700"><?php echo number_format($row[0], 0, ',', '.'); ?></p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nombre Completo</p>
                                    <p class="text-lg font-semibold text-slate-700"><?php echo $row[1] . ' ' . $row[2]; ?></p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tipo de Personal</p>
                                    <p class="text-lg font-bold text-slate-900"><?php echo $row[6]; ?></p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Condición</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">
                                        <?php echo $row[5]; ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-slate-400 italic">No se encontraron datos personales.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Stats/Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-emerald-50 border border-emerald-100 p-6 rounded-3xl flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center text-emerald-600 shadow-sm">
                        <i class="fa-solid fa-money-check-dollar text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-emerald-800 font-bold">Última Nómina</p>
                        <a href="<?php echo site_url('payroll/nominas') ?>" class="text-sm text-emerald-600 font-medium hover:underline">Descargar nómina &rarr;</a>
                    </div>
                </div>
                <div class="bg-amber-50 border border-amber-100 p-6 rounded-3xl flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center text-amber-600 shadow-sm">
                        <i class="fa-solid fa-shield-halved text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-amber-800 font-bold">Seguridad</p>
                        <a href="<?php echo site_url('profile/editar_clave') ?>" class="text-sm text-amber-600 font-medium hover:underline">Actualizar clave &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column: Carga Familiar -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-200 bg-slate-50 flex items-center border-l-4 border-l-primary">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-people-group text-primary"></i>
                        Carga Familiar
                    </h2>
                </div>
                <div class="p-6">
                    <?php if (isset($cargaf) && !empty($cargaf)): ?>
                        <ul class="space-y-4">
                            <?php foreach ($cargaf as $f): ?>
                                <li class="flex items-center gap-4 p-3 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm">
                                        <?php echo substr($f[2], 0, 1); ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-800 truncate"><?php echo $f[2] . ' ' . $f[3]; ?></p>
                                        <p class="text-xs text-slate-500">Parentesco: <?php echo $f[6]; ?></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i class="fa-solid fa-users-slash text-3xl text-slate-200 mb-3 block"></i>
                            <p class="text-slate-400 text-sm">Sin carga familiar registrada.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>
