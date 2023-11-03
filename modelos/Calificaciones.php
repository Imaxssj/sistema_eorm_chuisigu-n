<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";

class Calificaciones
{
	public $alumn_id;
	public $block_id;

	/** @var string */
	public $unidad;
	/** @var double */
	public $val;
	/** @var double */
	public $zona;
	/** @var double */
	public $final;

	//metodo insertar regiustro
	public function insertar()
	{
		$sql = "INSERT INTO calification 
			(alumn_id, block_id, unidad, zona, final, val) 
			VALUES 
			('{$this->alumn_id}', '{$this->block_id}', '{$this->unidad}', '{$this->zona}', '{$this->final}', '{$this->val}')";

		return ejecutarConsulta($sql);
	}

	public function editar($id)
	{
		$sql = "UPDATE calification SET alumn_id='{$this->alumn_id}', block_id='{$this->block_id}', unidad='{$this->unidad}', zona='{$this->zona}', final='{$this->final}', val='{$this->val}' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	public function verificar($alumn_id, $block_id, $unidad = '')
	{
		$sql = "SELECT * FROM calification WHERE alumn_id='$alumn_id' AND block_id='$block_id'";

		if (!empty($unidad))
			$sql .= " AND unidad='$unidad'";

		return ejecutarConsultaSimpleFila($sql);
	}

	public function listar_calificacion($idalumno, $idcurso, $unidad = null)
	{
		if (empty($unidad))
			$sql = "SELECT * FROM calification WHERE alumn_id='$idalumno' AND block_id='$idcurso'";
		else
			$sql = "SELECT * FROM calification WHERE alumn_id='$idalumno' AND block_id='$idcurso' AND unidad='{$unidad}'";

		return ejecutarConsulta($sql);
	}

	public function listar_unidades($idcurso)
	{
		$sql = "SELECT DISTINCT (c.unidad) FROM calification c WHERE c.block_id = '{$idcurso}'";
		return ejecutarConsulta($sql);
	}

	public function listar_promedios_alumnos($idcurso)
	{
		$sql = "SELECT 
			concat(a.name, ' ', a.lastname) AS alumno, a.id AS id_alumno, b.name AS curso, b.id AS id_curso
		FROM calification c 
			INNER JOIN alumn a ON a.id = c.alumn_id 
			INNER JOIN block b ON b.id = c.block_id 
		WHERE b.id = '{$idcurso}'
		GROUP BY a.id";

		return ejecutarConsulta($sql);
	}

	public function listar_promedios_alumnos_unidades($idalumno, $idcurso)
	{
		$sql = "SELECT 
			c.id AS id_calificacion, c.unidad, c.zona, c.final, c.val AS total
		FROM calification c 
			INNER JOIN alumn a ON a.id = c.alumn_id 
			INNER JOIN block b ON b.id = c.block_id 
		WHERE a.id = '{$idalumno}' AND block_id = '{$idcurso}'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($id)
	{
		$sql = "UPDATE calification SET condicion='0' WHERE id='$id'";
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
