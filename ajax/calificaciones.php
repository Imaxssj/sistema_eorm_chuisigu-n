<?php
require_once "../modelos/Calificaciones.php";
if (strlen(session_id()) < 1)
	session_start();
$calificacion = new Calificaciones();

$id = isset($_POST["idcalificacion"]) ? limpiarCadena($_POST["idcalificacion"]) : "";
$val = isset($_POST["valor"]) ? limpiarCadena($_POST["valor"]) : 0;
$alumn_id = isset($_POST["alumn_id"]) ? limpiarCadena($_POST["alumn_id"]) : "";
$block_id = isset($_POST["idcurso"]) ? limpiarCadena($_POST["idcurso"]) : "";
$unidad = isset($_POST["unidad"]) ? limpiarCadena($_POST["unidad"]) : "";
$zona = isset($_POST["zona"]) ? limpiarCadena($_POST["zona"]) : 0;
$final = isset($_POST["final"]) ? limpiarCadena($_POST["final"]) : 0;
$user_id = $_SESSION["idusuario"];

switch ($_GET["op"]) {
	case 'guardaryeditar':
		$calificacion->val = $val;
		$calificacion->zona = $zona;
		$calificacion->final = $final;
		$calificacion->unidad = $unidad;
		$calificacion->block_id = $block_id;
		$calificacion->alumn_id = $alumn_id;

		if (empty($id)) {
			$rspta = $calificacion->insertar();
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		} else {
			$rspta = $calificacion->editar($id);
			echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		}
		break;

	case 'desactivar':
		$rspta = $calificacion->desactivar($id);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta = $calificacion->activar($id);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;

	case 'mostrar':
		$rspta = $calificacion->mostrar($id);
		echo json_encode($rspta);
		break;
	case 'verificar':
		$rspta = $calificacion->verificar($alumn_id, $block_id, $unidad);
		echo json_encode($rspta);
		break;

	case 'listar':
		require_once "../modelos/Alumnos.php";
		$alumnos = new Alumnos();
		$team_id = $_REQUEST["idgrupo"];
		$rspta = $alumnos->listar($user_id, $team_id);
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => ($reg->is_active) ? '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->id . ')"><i class="fa fa-pencil"></i></button>' . ' ' . '<button class="btn btn-warning btn-xs" onclick="mostrar_precios(' . $reg->id . ')">P</i></button>' . ' ' . '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->id . ')"><i class="fa fa-close"></i></button>' : '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->id . ')"><i class="fa fa-pencil"></i></button>' . '<button class="btn btn-warning btn-xs" onclick="mostrar_precios(' . $reg->id . ')">P</i></button>' . ' ' . '<button class="btn btn-primary btn-xs" onclick="activar(' . $reg->id . ')"><i class="fa fa-check"></i></button>',
				"1" => "<img src='../files/articulos/" . $reg->image . "' height='50px' width='50px'>",
				"2" => $reg->name,
				"3" => $reg->lastname,
				"4" => $reg->phone,
				"5" => '<button class="btn btn-info btn-xs" onclick="verificar(' . $reg->id . ')"><i class="fa fa-check"></i> Calificar</button>'
			);
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
