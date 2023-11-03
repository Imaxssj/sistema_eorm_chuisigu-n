var tabla;

//funcion que se ejecuta al inicio
function init() {
	var team_id = $("#idgrupo").val();
	listar();

	//cargamos los items al select cliente
	$.post("../ajax/cursos.php?op=selectCursos", { idgrupo: team_id }, function (r) {
		$("#curso").html(r);
		$('#curso').selectpicker('refresh');
	});

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	})

}

//campturamos el id del curso la hacer cambio en el select curso
$("#curso").change(function () {
	var idcurso = $("#curso").val();
	$("#idcurso").val(idcurso);
	listar();

});

//funcion limpiar
function limpiar() {
	$("#idcalificacion").val("");
	$("#alumn_id").val("");
	$("#valor").val("");
	$("#curso").selectpicker('refresh');
	$('#getCodeModal').modal('hide')
}

//funcion listar
function listar() {
	var team_id = $("#idgrupo").val();
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
			url: '../ajax/utiles.php?op=listar',
			data: { idgrupo: team_id },
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

//FUNCION GUARDAR O EDITAR
function guardaryeditar(e) {
}

function cancelar(e) {
	data = { id: e };

	$.ajax({
		url: "../ajax/utiles.php?op=cancelar",
		type: "POST",
		data: data,

		success: function (datos) {
			bootbox.alert(datos);
			tabla.ajax.reload();
		}
	});

	limpiar();
}

function entregar(e) {
	data = { alumn_id: e };

	$.ajax({
		url: "../ajax/utiles.php?op=entregar",
		type: "POST",
		data: data,

		success: function (datos) {
			bootbox.alert(datos);
			tabla.ajax.reload();
		}
	});

	limpiar();
}


init();  