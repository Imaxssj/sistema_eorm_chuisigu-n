<?php
require_once "../modelos/Utiles.php";
if (strlen(session_id()) < 1)
	session_start();

$utilEscolar = new Utiles();

$fecha = date('Y-m-d');
$user_id = $_SESSION["idusuario"];
$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$id_alumno = isset($_POST["alumn_id"]) ? limpiarCadena($_POST["alumn_id"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		break;

	case 'cancelar':
		$rspta = $utilEscolar->desactivar($id);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;

	case 'activar':
		$rspta = $utilEscolar->activar($id);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;

	case 'mostrar':
		$rspta = $utilEscolar->mostrar($id);
		echo json_encode($rspta);
		break;

	case 'verificar':
		$rspta = $utilEscolar->verificar($id_alumno, $block_id, $unidad);
		echo json_encode($rspta);
		break;

	case 'entregar':
		$rspta = $utilEscolar->entregar($id_alumno, $fecha);
		echo json_encode($rspta);
		break;

	case 'listar':
		require_once "../modelos/Alumnos.php";
		$alumnos = new Alumnos();
		$team_id = $_REQUEST["idgrupo"];
		$rspta = $alumnos->listarUtiles($user_id, $team_id);
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$line = array(
				"0" => ($reg->is_active) ? '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->id . ')"><i class="fa fa-pencil"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" onclick="cancelar(' . $reg->id_delivery . ')"><i class="fa fa-close"></i></button>' : '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->id . ')"><i class="fa fa-pencil"></i></button>' . '<button class="btn btn-warning btn-xs" onclick="mostrar_precios(' . $reg->id . ')">P</i></button>' . ' ' . '<button class="btn btn-primary btn-xs" onclick="activar(' . $reg->id . ')"><i class="fa fa-check"></i></button>',
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
