<div class="max-w-4xl mx-auto space-y-8">
    
    <div class="flex items-center gap-4">
        <a href="<?php echo site_url('dashboard') ?>" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Constancias de Trabajo</h1>
    </div>

    <?php if (isset($inactivo) && $inactivo): ?>

    <!-- Alerta: Usuario inactivo -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-200 bg-slate-50 border-l-4 border-l-red-500">
            <h2 class="text-lg font-bold text-slate-800">Generar Documento</h2>
            <p class="text-sm text-slate-500 mt-1">No disponible en estos momentos.</p>
        </div>
        <div class="p-8">
            <div class="p-6 bg-red-50 border border-red-100 rounded-2xl flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-red-600 shadow-sm flex-shrink-0">
                    <i class="fa-solid fa-user-slash"></i>
                </div>
                <div class="text-sm text-red-700 leading-relaxed">
                    <p class="font-bold mb-1">No es posible generar constancias de trabajo</p>
                    <p>El personal se encuentra <strong>inactivo en nómina</strong>. Por favor, contactar con el departamento de Recursos Humanos para regularizar su situación.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Usuario inactivo -->
    <div id="modal-inactivo" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" role="dialog" aria-modal="true">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 sm:p-8 text-center">
            <div class="w-16 h-16 mx-auto rounded-full bg-red-50 flex items-center justify-center">
                <i class="fa-solid fa-user-slash text-2xl text-red-600"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-900 mt-4">Usuario inactivo en nómina</h2>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">Por favor, contactar con <strong>Recursos Humanos</strong> para regularizar su situación.</p>
            <button onclick="cerrarModalInactivo()" class="mt-6 w-full sm:w-auto bg-primary hover:bg-primary-dark text-white font-bold px-6 py-2.5 rounded-xl transition-all">
                Entendido
            </button>
        </div>
    </div>

    <?php else: ?>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-200 bg-slate-50 border-l-4 border-l-primary">
            <h2 class="text-lg font-bold text-slate-800">Generar Documento</h2>
            <p class="text-sm text-slate-500 mt-1">Selecciona los parámetros para tu constancia de trabajo oficial.</p>
        </div>

        <div class="p-8">
            <?php if ($this->session->flashdata('mensaje')): ?>
                <div class="mb-8 p-4 bg-red-50 border border-red-100 text-red-600 text-sm rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo $this->session->flashdata('mensaje'); ?></span>
                </div>
            <?php endif; ?>

            <?php echo form_open('payroll/pdf_constancia', ['class' => 'space-y-8', 'target' => '_blank']); ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="block text-sm font-bold text-slate-700">Tipo de Sueldo</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="relative flex items-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                                <input type="radio" name="sueldo" value="01" class="w-4 h-4 text-primary focus:ring-primary border-slate-300" required>
                                <span class="ml-3 font-semibold text-slate-700 group-has-[:checked]:text-primary text-sm">Sueldo Integral</span>
                            </label>
                            <label class="relative flex items-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                                <input type="radio" name="sueldo" value="02" class="w-4 h-4 text-primary focus:ring-primary border-slate-300">
                                <span class="ml-3 font-semibold text-slate-700 group-has-[:checked]:text-primary text-sm">Sueldo Anual</span>
                            </label>
                            <label class="relative flex items-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                                <input type="radio" name="sueldo" value="03" class="w-4 h-4 text-primary focus:ring-primary border-slate-300">
                                <span class="ml-3 font-semibold text-slate-700 group-has-[:checked]:text-primary text-sm">Sueldo Básico</span>
                            </label>
                            <label class="relative flex items-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                                <input type="radio" name="sueldo" value="04" class="w-4 h-4 text-primary focus:ring-primary border-slate-300">
                                <span class="ml-3 font-semibold text-slate-700 group-has-[:checked]:text-primary text-sm">Sin Sueldo</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-sm font-bold text-slate-700">Beneficio Cesta Ticket</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="relative flex items-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                                <input type="radio" name="ces" value="02" class="w-4 h-4 text-primary focus:ring-primary border-slate-300" required>
                                <span class="ml-3 font-semibold text-slate-700 group-has-[:checked]:text-primary text-sm">Con Cesta Ticket</span>
                            </label>
                            <label class="relative flex items-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                                <input type="radio" name="ces" value="01" class="w-4 h-4 text-primary focus:ring-primary border-slate-300" checked>
                                <span class="ml-3 font-semibold text-slate-700 group-has-[:checked]:text-primary text-sm">Sin Cesta Ticket</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-slate-400 italic">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        El documento generado tendrá validez institucional.
                    </p>
                    <button type="submit" class="w-full sm:w-auto bg-primary hover:bg-primary-dark text-white font-bold px-8 py-3.5 rounded-2xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-file-pdf"></i>
                        Generar PDF
                    </button>
                </div>

            <?php echo form_close(); ?>
        </div>
    </div>

    <?php endif; ?>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-100 p-6 rounded-3xl flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-blue-600 shadow-sm flex-shrink-0">
            <i class="fa-solid fa-circle-info"></i>
        </div>
        <div class="text-sm text-blue-800 leading-relaxed">
            <p class="font-bold mb-1">Sobre la validación</p>
            <p>Las constancias emitidas por este sistema están firmadas digitalmente y pueden ser verificadas por el departamento de recursos humanos.</p>
        </div>
    </div>

    <script>
        function cerrarModalInactivo() {
            var modal = document.getElementById('modal-inactivo');
            if (modal) { modal.style.display = 'none'; }
        }
    </script>

</div>
