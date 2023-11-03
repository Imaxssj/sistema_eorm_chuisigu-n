	<?php
	//incluir la conexion de base de datos
	require "../config/Conexion.php";

	class Alimentacion
	{
		/** @var int */
		public $id;

		/** @var int */
		public $id_alumno;

		/** @var int */
		public $id_encargado;

		/** @var string */
		public $fecha;

		/** @var string */
		public $observaciones;

		//implementamos nuestro constructor
		public function __construct()
		{
		}

		//metodo insertar regiustro
		public function insertar()
		{
			if (empty($this->fecha) || empty($this->id_alumno) || empty($this->id_encargado))
				return false;

			$fecha = $this->fecha ?? '';
			$idAlumno = $this->id_alumno ?? 0;
			$idEncargado = $this->id_encargado ?? 0;
			$observaciones = $this->observaciones ?? '';

			$sql = "INSERT INTO alimentacion (id_alumno, fecha, observaciones) VALUES ('{$idAlumno}', '{$fecha}', '{$observaciones}')";
			return ejecutarConsulta($sql);
		}

		public function editar($id, $val, $alumn_id, $block_id)
		{
			if (empty($this->id))
				return false;

			$id = $this->id ?? 0;
			$fecha = $this->fecha ?? '';
			$idAlumno = $this->id_alumno ?? 0;
			$idEncargado = $this->id_encargado ?? 0;
			$observaciones = $this->observaciones ?? '';

			$sql = "UPDATE alimentacion SET fecha='{$fecha}', id_alumno='{$idAlumno}', observaciones='{$observaciones}' WHERE id='{$id}'";
			return ejecutarConsulta($sql);
		}

		//metodo para mostrar registros
		public function mostrar($id)
		{
			$sql = "SELECT * FROM alimentacion WHERE id='{$id}'";
			return ejecutarConsultaSimpleFila($sql);
		}

		//listar registros
		public function listar($fecha = '')
		{
			$sql = "SELECT * FROM alimentacion WHERE fecha = '{$fecha}'";

			return ejecutarConsulta($sql);
		}

		public function eliminar($id)
		{
			$sql = "DELETE FROM alimentacion WHERE id='{$id}'";
			return ejecutarConsulta($sql);
		}
	}
