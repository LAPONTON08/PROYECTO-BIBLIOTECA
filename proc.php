<?php

include 'conexion.php';

$q=$_POST['q'];
$con=conexion();

$sql="select * from estudiantes where doc = ".$q;

$res=mysql_query($sql,$con);

if(mysql_num_rows($res)==0){

echo '<b>Estudiante no encontrado</b>';

}else{


while($fila=mysql_fetch_array($res)){

echo $fila['nombre_comp'].'&nbsp;&nbsp;';
echo "<input class=\"boton\" type=\"submit\" value=\"Realizar Prestamo\" onClick=\"msj()\">";
}

}

?>