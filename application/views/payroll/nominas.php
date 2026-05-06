<div class="max-w-4xl mx-auto space-y-8">
    
    <div class="flex items-center gap-4">
        <a href="<?php echo site_url('dashboard') ?>" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Consulta de Nóminas</h1>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-200 bg-slate-50 border-l-4 border-l-primary">
            <h2 class="text-lg font-bold text-slate-800">Nóminas</h2>
            <p class="text-sm text-slate-500 mt-1">Selecciona un periodo para descargar tu nómina detallada.</p>
        </div>

        <div class="p-8">
            <?php if ($this->session->flashdata('mensaje')): ?>
                <div class="mb-8 p-4 bg-red-50 border border-red-100 text-red-600 text-sm rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo $this->session->flashdata('mensaje'); ?></span>
                </div>
            <?php endif; ?>

            <?php echo form_open('payroll/pdf_nomina', ['class' => 'space-y-6', 'id' => 'form_nomina', 'target' => '_blank']); ?>
                
                <div class="space-y-3">
                    <label for="meses" class="block text-sm font-bold text-slate-700 ml-1">Periodo Disponible</label>
                    <div class="relative">
                        <select name="meses" id="meses" required 
                            class="w-full pl-5 pr-12 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all appearance-none font-semibold text-slate-700">
                            <option value="">Selecciona un mes/año...</option>
                            <?php foreach ($meses as $m): ?>
                                <option value="<?php echo $m[1]; ?>"><?php echo $m[0] . ' ' . $m[2]; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <button type="submit" class="w-full sm:w-auto bg-primary hover:bg-primary-dark text-white font-bold px-10 py-4 rounded-2xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-download"></i>
                        Descargar Nómina
                    </button>
                </div>

            <?php echo form_close(); ?>
        </div>
    </div>

    <!-- Additional Info Table/List -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-200 bg-slate-50 border-l-4 border-l-primary">
            <h3 class="font-bold text-slate-800">Historial Reciente</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-8 py-4">Periodo</th>
                        <th class="px-8 py-4">Tipo</th>
                        <th class="px-8 py-4 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php 
                    // Mostramos solo los 5 meses más recientes como ejemplo
                    $recent = array_slice($meses, 0, 5);
                    foreach ($recent as $m): 
                    ?>
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-4 text-sm font-semibold text-slate-700"><?php echo $m[0] . ' ' . $m[2]; ?></td>
                        <td class="px-8 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">Ordinaria</span>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <button type="button" onclick="document.getElementById('meses').value='<?php echo $m[1]; ?>'; document.getElementById('form_nomina').submit();" 
                                class="text-primary font-bold text-sm hover:text-primary-dark transition-colors">
                                Descargar
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
