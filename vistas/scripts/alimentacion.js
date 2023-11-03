var tabla;

//funcion que se ejecuta al inicio
function init() {
	var team_id = $("#idgrupo").val();

	listar();

	$('#fecha_alimentacion').change(function () {
		listar();
	});
}

//funcion listar
function listar() {
	var team_id = $("#idgrupo").val();
	let fecha = $("#fecha_alimentacion").val();

	tabla = $('#tbllistado').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdf'
		],
		"ajax":
		{
			url: '../ajax/alimentacion.php?op=listar',
			data: { idgrupo: team_id, fecha: fecha },
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//paginacion
		"order": [[0, "desc"]]//ordenar (columna, orden)
	}).DataTable();
}

function cancelar(e) {
	data = { id: e };

	$.ajax({
		url: "../ajax/alimentacion.php?op=cancelar",
		type: "POST",
		data: data,

		success: function (datos) {
			bootbox.alert(datos);
			tabla.ajax.reload();
		}
	});
}

function entregar(e) {
	let fecha = $("#fecha_alimentacion").val();
	let team_id = $("#idgrupo").val();

	data = { id_alumno: e, id_grupo: team_id, fecha: fecha };

	$.ajax({
		url: "../ajax/alimentacion.php?op=entregar",
		type: "POST",
		data: data,

		success: function (datos) {
			bootbox.alert(datos);
			tabla.ajax.reload();
		}
	});
}


init();  