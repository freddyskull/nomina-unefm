<div class="max-w-4xl mx-auto space-y-8">
    
    <div class="flex items-center gap-4">
        <a href="<?php echo site_url('dashboard') ?>" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Detalle III CCU</h1>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-200 bg-slate-50 border-l-4 border-l-primary">
            <h2 class="text-lg font-bold text-slate-800">Consulta Retroactivo</h2>
            <p class="text-sm text-slate-500 mt-1">Accede al detalle del pago de la Tercera Convención Colectiva Única (III CCU).</p>
        </div>

        <div class="p-8">
            <div class="mb-8 p-6 bg-blue-50 border border-blue-100 rounded-2xl flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-blue-600 shadow-sm flex-shrink-0">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="text-sm text-blue-800 leading-relaxed">
                    <p class="font-bold mb-1">Información sobre III CCU</p>
                    <p>Esta consulta te permite visualizar el desglose detallado de los pagos correspondientes al retroactivo de la Convención Colectiva Única. Los datos son procesados por el sistema central de servicios de la Universidad.</p>
                </div>
            </div>

            <div class="bg-slate-50 border border-slate-200 rounded-3xl p-10 text-center">
                <form action="http://saad.unefm.edu.ve/nomi/servlet/IIICCUdata" method="post" target="_blank">
                    <input type="hidden" name="ced" value="<?php echo $cedula ?>">
                    <input type="hidden" name="tp" value="<?php echo $tipoper ?>">
                    
                    <div class="mb-6">
                        <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center text-primary text-3xl mx-auto mb-4">
                            <i class="fa-solid fa-file-contract"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Visualizar Detalle</h3>
                        <p class="text-slate-500 text-sm mt-2 max-w-md mx-auto">Haz clic en el botón inferior para abrir el detalle oficial del III CCU en una nueva ventana segura.</p>
                    </div>

                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-bold px-12 py-4 rounded-2xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 mx-auto group">
                        <i class="fa-solid fa-magnifying-glass-dollar"></i>
                        Consultar III CCU
                    </button>
                </form>
            </div>

            <div class="mt-12 space-y-6">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-book-open text-primary"></i>
                    Guía de Cálculo
                </h3>
                <div class="bg-white border border-slate-200 rounded-2xl p-2 overflow-hidden shadow-sm">
                    <img src="<?php echo base_url('assets/img/pag19.jpg') ?>" alt="Instructivo III CCU" class="w-full h-auto rounded-xl">
                </div>
                <p class="text-center text-slate-500 text-sm italic">Instructivo para el cálculo del III CCU para el personal jubilado, pensionados por incapacidad y sobrevivientes.</p>
            </div>
        </div>
    </div>

</div>
