var tabla;

//funcion que se ejecuta al inicio
function init() {
	listar();
	listarc();
	listar_utiles();
	listar_alimentos();
	listar_calificacion();

	$("#fecha_inicio").change(listar);
	$("#fecha_fin").change(listar);
	$("#fecha_inicioc").change(listarc);
	$("#fecha_finc").change(listarc);
	$("#unidad").change(listar_calificacion);
	$("#curso_promedio").change(listar_calificacion_promedio);

	let team_id = $("#idgrupo").val();
	$.post("../ajax/cursos.php?op=selectCursos", { idgrupo: team_id }, function (r) {
		$("#curso_promedio").html(r);
		$('#curso_promedio').selectpicker('refresh');
	});
}

//funcion listar asistencia
function listar() {
	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	var team_id = $("#idgrupo").val();
	$.post("../ajax/consultas.php?op=lista_asistencia", { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin, idgrupo: team_id },
		function (data, status) {
			$("#data").html(data);
		})
}

//funcion listar comportamiento
function listarc() {
	var fecha_inicio = $("#fecha_inicioc").val();
	var fecha_fin = $("#fecha_finc").val();
	var team_id = $("#idgrupo").val();
	$.post("../ajax/consultas.php?op=lista_comportamiento", { fecha_inicioc: fecha_inicio, fecha_finc: fecha_fin, idgrupo: team_id },
		function (data, status) {
			$("#datac").html(data);
		})
}

//funcion listar calificacion
function listar_calificacion() {
	var team_id = $("#idgrupo").val();
	let unidad = $("#unidad").val();

	$.post("../ajax/consultas.php?op=listar_calificacion", { idgrupo: team_id , unidad: unidad},
		function (data, status) {
			$("#datacalif").html(data);
		})
}

//funcion listar calificacion
function listar_utiles() {
	var team_id = $("#idgrupo").val();
	$.post("../ajax/consultas.php?op=listar_utiles", { idgrupo: team_id },
		function (data, status) {
			$("#datautiless").html(data);
		})
}

//funcion listar calificacion
function listar_alimentos() {
	var team_id = $("#idgrupo").val();
	$.post("../ajax/consultas.php?op=listar_alimentos", { idgrupo: team_id },
		function (data, status) {
			$("#dataalimentos").html(data);
		})
}

//funcion listar promedios
function listar_calificacion_promedio() {
	let team_id = $("#idgrupo").val();
	let curso = $("#curso_promedio").val();
	$.post("../ajax/consultas.php?op=listar_promedio", { idgrupo: team_id, idcurso: curso },
		function (data, status) {
			$("#datapromedios").html(data);
		})
}

init();



