<div class="max-w-4xl mx-auto space-y-8">
    
    <div class="flex items-center gap-4">
        <a href="<?php echo site_url('dashboard') ?>" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Planilla ARC</h1>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-200 bg-slate-50 border-l-4 border-l-primary">
            <h2 class="text-lg font-bold text-slate-800">Descarga de Planilla</h2>
            <p class="text-sm text-slate-500 mt-1">Selecciona el año fiscal para generar tu comprobante de retenciones (ARC).</p>
        </div>

        <div class="p-8">
            <div class="mb-8 p-6 bg-blue-50 border border-blue-100 rounded-2xl flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-blue-600 shadow-sm flex-shrink-0">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="text-sm text-blue-800 leading-relaxed">
                    <p class="font-bold mb-1">Información importante</p>
                    <p>Se informa al personal activo que está disponible la Planilla ARC para la declaración del Impuesto Sobre la Renta (ISLR). Una vez impreso, debe pasar por la Dirección de Administración para la firma y sello húmedo oficial.</p>
                </div>
            </div>

            <form action="http://saad.unefm.edu.ve/nomi/servlet/ARCRepweb" method="post" target="_blank" class="space-y-8">
                <input type="hidden" name="us" value="<?php echo $cedula ?>">
                <input type="hidden" name="tp" value="<?php echo $tipoper ?>">

                <div class="space-y-4">
                    <label class="block text-sm font-bold text-slate-700 ml-1">Seleccione el Año Fiscal</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <?php 
                        $current_year = date('Y');
                        for ($year = $current_year; $year >= 2014; $year--): 
                        ?>
                            <label class="relative flex items-center justify-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group text-center">
                                <input type="radio" name="ano" value="<?php echo $year; ?>" class="sr-only" required>
                                <span class="font-bold text-slate-600 group-has-[:checked]:text-primary"><?php echo $year; ?></span>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="w-full sm:w-auto bg-primary hover:bg-primary-dark text-white font-bold px-10 py-4 rounded-2xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-download"></i>
                        Descargar Planilla
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
