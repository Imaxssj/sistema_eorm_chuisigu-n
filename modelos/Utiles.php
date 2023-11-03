<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Utiles
{
	public int $id;
	public int $id_alumno;
	public int $id_encargado;
	public string $fecha;
	public string $observaciones;

	//implementamos nuestro constructor
	public function __construct()
	{
	}

	//metodo insertar regiustro
	public function insertar($val, $alumn_id, $block_id)
	{
		$sql = "INSERT INTO calification (val,alumn_id,block_id) VALUES ('$val','$alumn_id','$block_id')";
		return ejecutarConsulta($sql);
	}

	public function editar($id, $val, $alumn_id, $block_id)
	{
		$sql = "UPDATE calification SET val='$val',alumn_id='$alumn_id',block_id='$block_id' 
	WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	public function verificar($alumn_id, $block_id)
	{
		$sql = "SELECT * FROM calification WHERE alumn_id='$alumn_id' AND block_id='$block_id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function entregar($alumn_id, $fecha)
	{
		$sql = "SELECT * FROM utiles_escolares WHERE id_alumno='$alumn_id'";
		$entrega = ejecutarConsultaSimpleFila($sql);

		if (isset($entrega))
			return [];

		$sql = "INSERT INTO utiles_escolares (id_alumno, fecha) VALUES ('$alumn_id', '$fecha')";

		if (ejecutarConsulta($sql) === true || ejecutarConsulta($sql) === 'true')
			return 'Utiles entregados.';

		return 'No se pudo actualizar';
	}

	public function desactivar($id)
	{
		$sql = "DELETE FROM utiles_escolares WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	public function activar($id)
	{
		$sql = "UPDATE calification SET condicion='1' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//metodo para mostrar registros
	public function mostrar($id)
	{
		$sql = "SELECT * FROM calification WHERE id='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//listar registros
	public function listar()
	{
		$sql = "SELECT * FROM calification";
		return ejecutarConsulta($sql);
	}

	//listar y mostrar en selct
	public function select()
	{
		$sql = "SELECT * FROM calification WHERE condicion=1";
		return ejecutarConsulta($sql);
	}
}
