<?php 
require_once "../modelos/Productos.php";

$producto=new Producto();

$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$precio=isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
	if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productos/" . $imagen);
			}
		}
		if (empty($idproducto)){
			$rspta=$producto->insertar($nombre,$cantidad,$precio, $descripcion,$imagen);
			echo $rspta ? "Producto registrado" : "Producto no se pudo registrar";
		}
		else {
			$rspta=$producto->editar($idproducto,$nombre,$cantidad, $precio, $descripcion, $imagen);
			echo $rspta ? "Producto actualizado" : "Producto no se pudo actualizar";
		}
	break;

	case 'eliminar':
		$rspta=$producto->eliminar($idproducto);
 		echo $rspta ? "Producto eliminado" : "Producto no se puede eliminar";
 		break;
	break;

	

	case 'mostrar':
		$rspta=$producto->mostrar($idproducto);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$producto->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				
 				"0"=>$reg->nombre,
 				"1"=>$reg->cantidad,
 				"2"=>$reg->precio,
 				"3"=>$reg->descripcion,
 				"4"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px' >",
 				
 				"5"=>($reg->disponibilidad)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	case 'listarArticulos':
		require_once "../modelos/Productos.php";
		$producto=new Producto();

		$rspta=$producto->listarActivos();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->disponibilidad)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>',
 				
 				"1"=>$reg->nombre,
 				"2"=>$reg->cantidad,
 				"3"=>$reg->precio,
 				"4"=>$reg->descripcion,
 				"5"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px' >",
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;
}
?>