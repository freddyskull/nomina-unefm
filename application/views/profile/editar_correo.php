<div class="max-w-2xl mx-auto space-y-8">
    
    <div class="flex items-center gap-4">
        <a href="<?php echo site_url('profile') ?>" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Actualizar Correo</h1>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-200 bg-slate-50 border-l-4 border-l-primary">
            <h2 class="font-bold text-slate-800">Dirección de Contacto</h2>
            <p class="text-sm text-slate-500 mt-1">Este correo se usará para notificaciones y recuperación de cuenta.</p>
        </div>

        <div class="p-8">
            <?php if ($this->session->flashdata('mensaje')): ?>
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo $this->session->flashdata('mensaje'); ?></span>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('mensaje_exito')): ?>
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo $this->session->flashdata('mensaje_exito'); ?></span>
                </div>
            <?php endif; ?>

            <?php echo form_open('profile/procesar_correo', ['class' => 'space-y-6']); ?>
                
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-bold text-slate-700 ml-1">Nuevo Correo Electrónico</label>
                    <input type="email" id="email" name="email" required 
                        value="<?php echo isset($empleado[0][5]) ? $empleado[0][5] : ''; ?>"
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                        placeholder="ejemplo@unefm.edu.ve">
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="w-full sm:w-auto bg-primary hover:bg-primary-dark text-white font-bold px-10 py-4 rounded-2xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-envelope text-xs"></i>
                        Guardar Cambios
                    </button>
                </div>

            <?php echo form_close(); ?>
        </div>
    </div>

</div>
