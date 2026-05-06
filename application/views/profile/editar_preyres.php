<div class="max-w-3xl mx-auto space-y-8">
    
    <div class="flex items-center gap-4">
        <a href="<?php echo site_url('profile') ?>" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Preguntas de Seguridad</h1>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-200 bg-slate-50 border-l-4 border-l-primary">
            <h2 class="font-bold text-slate-800">Recuperación de Cuenta</h2>
            <p class="text-sm text-slate-500 mt-1">Estas preguntas te permitirán recuperar tu acceso si olvidas tu contraseña.</p>
        </div>

        <div class="p-8">
            <?php if ($this->session->flashdata('mensaje_exito')): ?>
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo $this->session->flashdata('mensaje_exito'); ?></span>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('mensaje3')): ?>
                <div class="mb-6 p-4 bg-amber-50 border border-amber-100 text-amber-600 text-sm rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo $this->session->flashdata('mensaje3'); ?></span>
                </div>
            <?php endif; ?>

            <?php echo form_open('profile/procesar_preyres', ['class' => 'space-y-8']); ?>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="pregunta" class="block text-sm font-bold text-slate-700 ml-1">Pregunta 1</label>
                            <input type="text" id="pregunta" name="pregunta" required 
                                value="<?php echo isset($preyres['pregunta']) ? $preyres['pregunta'] : ''; ?>"
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                                placeholder="Ej: Nombre de primera mascota">
                        </div>
                        <div class="space-y-2">
                            <label for="respuesta" class="block text-sm font-bold text-slate-700 ml-1">Respuesta 1</label>
                            <input type="password" id="respuesta" name="respuesta" required 
                                value="<?php echo isset($preyres['respuesta']) ? $preyres['respuesta'] : ''; ?>"
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="pregunta2" class="block text-sm font-bold text-slate-700 ml-1">Pregunta 2</label>
                            <input type="text" id="pregunta2" name="pregunta2" required 
                                value="<?php echo isset($preyres['pregunta2']) ? $preyres['pregunta2'] : ''; ?>"
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                                placeholder="Ej: Ciudad de nacimiento">
                        </div>
                        <div class="space-y-2">
                            <label for="respuesta2" class="block text-sm font-bold text-slate-700 ml-1">Respuesta 2</label>
                            <input type="password" id="respuesta2" name="respuesta2" required 
                                value="<?php echo isset($preyres['respuesta2']) ? $preyres['respuesta2'] : ''; ?>"
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-semibold"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="w-full sm:w-auto bg-primary hover:bg-primary-dark text-white font-bold px-10 py-4 rounded-2xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-shield-check text-xs"></i>
                        Actualizar Preguntas
                    </button>
                </div>

            <?php echo form_close(); ?>
        </div>
    </div>

</div>
