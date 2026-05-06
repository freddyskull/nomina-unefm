<div class="max-w-6xl mx-auto space-y-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="<?php echo site_url('dashboard') ?>" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Censo de Salud</h1>
        </div>
        <p class="text-xs bg-amber-50 text-amber-700 px-4 py-2 rounded-full border border-amber-100 font-bold">
            <i class="fa-solid fa-triangle-exclamation mr-1"></i>
            Información confidencial para fines médicos
        </p>
    </div>

    <?php if ($this->session->flashdata('mensaje_exito')): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm rounded-2xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check"></i>
            <span><?php echo $this->session->flashdata('mensaje_exito'); ?></span>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('mensaje')): ?>
        <div class="p-4 bg-amber-50 border border-amber-100 text-amber-600 text-sm rounded-2xl flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span><?php echo $this->session->flashdata('mensaje'); ?></span>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Register Form Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden sticky top-8">
                <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="font-bold text-slate-800">Registrar Medicina</h2>
                    <p class="text-xs text-slate-500 mt-1">Indica qué medicina requiere cada familiar.</p>
                </div>
                <div class="p-8">
                    <?php echo form_open('medical/procesar_censo', ['class' => 'space-y-6']); ?>
                        
                        <div class="space-y-2">
                            <label for="familiar" class="block text-sm font-bold text-slate-700 ml-1">Familiar</label>
                            <select name="familiar" id="familiar" required 
                                class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-semibold">
                                <option value="">Selecciona familiar...</option>
                                <?php foreach ($familiares as $f): ?>
                                    <option value="<?php echo $f[2]; ?>"><?php echo $f[3]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="medicina" class="block text-sm font-bold text-slate-700 ml-1">Medicina</label>
                            <select name="medicina" id="medicina" required 
                                class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm font-semibold">
                                <option value="">Selecciona medicina...</option>
                                <?php foreach ($medicinas as $m): ?>
                                    <option value="<?php echo $m[0]; ?>"><?php echo $m[1]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3.5 rounded-2xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 group">
                            <i class="fa-solid fa-plus text-xs"></i>
                            Agregar al Censo
                        </button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>

        <!-- Censo Table Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800">Registros Actuales</h3>
                    <span class="text-xs font-bold text-slate-400"><?php echo count($censo); ?> Registros</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-8 py-4">Familiar (Cédula)</th>
                                <th class="px-8 py-4">Medicina</th>
                                <th class="px-8 py-4 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (empty($censo)): ?>
                                <tr>
                                    <td colspan="3" class="px-8 py-12 text-center text-slate-400 italic">No hay registros en el censo médico.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($censo as $c): ?>
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-8 py-4">
                                        <p class="text-sm font-bold text-slate-800"><?php echo $c[1]; ?></p>
                                    </td>
                                    <td class="px-8 py-4 text-sm font-medium text-slate-600"><?php echo $c[3]; ?></td>
                                    <td class="px-8 py-4 text-right">
                                        <a href="<?php echo site_url('medical/eliminar_censo/'.$c[1].'/'.$c[2]) ?>" 
                                           onclick="return confirm('¿Estás seguro de eliminar este registro?')"
                                           class="text-red-400 hover:text-red-600 font-bold text-xs p-2 hover:bg-red-50 rounded-lg transition-all">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
