<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Producto
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$cantidad,$precio, $descripcion,$imagen)
	{
		$sql="INSERT INTO productos ( nombre,cantidad, precio, descripcion,imagen,disponibilidad)
		VALUES ('$nombre', '$cantidad', '$precio', '$descripcion', '$imagen', '1')";
		return ejecutarConsulta($sql);
	}
	//Implementamos un método para editar registros
	public function editar($idproducto,$nombre,$cantidad, $precio, $descripcion, $imagen)
	{
		$sql="UPDATE productos SET nombre='$nombre',cantidad='$cantidad', precio='$precio', descripcion='$descripcion', imagen='$imagen' WHERE idproducto='$idproducto'";
		return ejecutarConsulta($sql);
	}
	//Implementamos un método para eliminar un producto
	public function eliminar($idproducto)
	{
		$sql="DELETE from productos  WHERE idproducto='$idproducto'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idproducto)
	{
		$sql="SELECT * FROM productos WHERE idproducto='$idproducto'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM productos";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM productos where disponibilidad=1";
		return ejecutarConsulta($sql);	
	}
}

?>