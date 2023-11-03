<?php
require_once "../modelos/Alimentacion.php";
if (strlen(session_id()) < 1)
	session_start();

$alimentacion = new Alimentacion();

$idEncargado = $_SESSION["idusuario"];
$idAlumno = isset($_POST["id_alumno"]) ? limpiarCadena($_POST["id_alumno"]) : "";
$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : date('Y-m-d');

switch ($_GET["op"]) {
	case 'cancelar':
		$idEntrega = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
		$rspta = $alimentacion->eliminar($idEntrega);

		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;

	case 'mostrar':
		$rspta = $alimentacion->mostrar($id);
		echo json_encode($rspta);
		break;

	case 'entregar':
		$alimentacion->fecha = $fecha;
		$alimentacion->id_alumno = $idAlumno;
		$alimentacion->id_encargado = $idEncargado;

		$rspta = $alimentacion->insertar();
		echo json_encode($rspta);
		break;

	case 'listar':
		require_once "../modelos/Alumnos.php";
		$alumnos = new Alumnos();
		$fecha = $_REQUEST["fecha"];
		$team_id = $_REQUEST["idgrupo"];
		$rspta = $alumnos->listarAlimentos($idEncargado, $team_id, $fecha);
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$line = array(
				"0" => ($reg->is_active) ? '<button class="btn btn-danger btn-xs" onclick="cancelar(' . $reg->id_delivery . ')"><i class="fa fa-close"></i></button>' : '',
				"1" => "<img src='../files/articulos/" . $reg->image . "' height='50px' width='50px'>",
				"2" => $reg->name,
				"3" => $reg->lastname,
				"4" => $reg->phone
			);

			if (empty($reg->id_delivery)) {
				$line["5"] = 'NA';
				$line["6"] = '<button class="btn btn-info btn-xs" onclick="entregar(' . $reg->id . ')"><i class="fa fa-check"></i> Entregar</button>';
			} else {
				$line["5"] = $reg->date;
				$line["6"] = 'Entregado';
			}

			// Cargamos la línea a la data
			$data[] = $line;
		}
		$results = array(
			"sEcho" => 1, //info para datatables
			"iTotalRecords" => count($data), //enviamos el total de registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
}
