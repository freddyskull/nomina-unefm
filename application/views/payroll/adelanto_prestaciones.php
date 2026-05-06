<div class="max-w-4xl mx-auto space-y-8">
    
    <div class="flex items-center gap-4">
        <a href="<?php echo site_url('dashboard') ?>" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Anticipo de Prestaciones</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- OPSU Card -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-8 border-b border-slate-200 bg-slate-50 border-l-4 border-l-primary">
                <h2 class="text-lg font-bold text-slate-800">Planilla OPSU</h2>
                <p class="text-sm text-slate-500 mt-1">Solicitud de Anticipo de Prestaciones Sociales (Caracas).</p>
            </div>
            <div class="p-8 flex-grow flex flex-col justify-between">
                <div class="mb-8 p-4 bg-primary/5 rounded-2xl flex items-start gap-3">
                    <i class="fa-solid fa-file-pdf text-primary mt-1"></i>
                    <p class="text-sm text-slate-600 leading-relaxed">Utilice este formato si su solicitud debe ser procesada a través de la Oficina de Planificación del Sector Universitario (OPSU).</p>
                </div>
                <a href="<?php echo base_url(); ?>descarga/Planilla de solicitud antc caracas.pdf" target="_blank" 
                    class="w-full bg-primary hover:bg-primary-dark text-white font-bold px-6 py-4 rounded-2xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 group">
                    <i class="fa-solid fa-download"></i>
                    Descargar PDF
                </a>
            </div>
        </div>

        <!-- UNEFM Card -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-8 border-b border-slate-200 bg-slate-50 border-l-4 border-l-primary">
                <h2 class="text-lg font-bold text-slate-800">Planilla UNEFM</h2>
                <p class="text-sm text-slate-500 mt-1">Solicitud de Anticipo de Prestaciones Sociales (Interna).</p>
            </div>
            <div class="p-8 flex-grow flex flex-col justify-between">
                <div class="mb-8 p-4 bg-primary/5 rounded-2xl flex items-start gap-3">
                    <i class="fa-solid fa-file-word text-primary mt-1"></i>
                    <p class="text-sm text-slate-600 leading-relaxed">Utilice este formato para trámites internos de adelanto de prestaciones dentro de la Universidad Nacional Experimental Francisco de Miranda.</p>
                </div>
                <a href="<?php echo base_url(); ?>descarga/planilla_adelanto_prestcs.doc" target="_blank" 
                    class="w-full bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white font-bold px-6 py-4 rounded-2xl transition-all flex items-center justify-center gap-2 group">
                    <i class="fa-solid fa-download"></i>
                    Descargar Documento
                </a>
            </div>
        </div>

    </div>

    <div class="bg-amber-50 border border-amber-100 p-6 rounded-3xl flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-amber-600 shadow-sm flex-shrink-0">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="text-sm text-amber-800 leading-relaxed">
            <p class="font-bold mb-1">Nota Importante</p>
            <p>Asegúrese de completar todos los campos requeridos en la planilla antes de consignarla en la Dirección de Recursos Humanos. El tiempo de respuesta dependerá de la disponibilidad de fondos y los lineamientos del Ministerio.</p>
        </div>
    </div>

</div>
