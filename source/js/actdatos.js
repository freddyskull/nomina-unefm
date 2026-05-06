function actDatos(id){
	console.log ("#imagen");
	$("#nomb").val("");
	$("#nomb").val($("#nombre"+id).val());
	$("#identificador").val("");
	$("#identificador").val($("#ident"+id).val());
	$("#orig").val("");
	$("#pad").val($("#padre"+id).val());
	$("#mad").val("");
	$("#mad").val($("#madre"+id).val());
	$("#orig").val("");
	$("#orig").val($("#origen"+id).val());
	$("#fecha").val("");
	$("#fecha").val($("#fecha_n"+id).val());
	$("#sex").val("");
	$("#sex").val($("#sexo"+id).val());
	$("#not").val("");
	$("#not").val($("#nota"+id).val());
	$("#fechaa").val("");
	$("#fechaa").val($("#fecha_a"+id).val());
	$("#fecham").val("");
	$("#fecham").val($("#fecha_m"+id).val());
	$("#ima").val("");
	$("#ima").val($("#imagen"+id).val());
	$("#njd").val("");
	$("#njd").val($("#imagen"+id).val());
}

  