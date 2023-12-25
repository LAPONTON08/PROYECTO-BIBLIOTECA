<?php require_once('Connections/conexionBD.php'); mysql_query("SET NAMES 'UTF8'"); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_proveedor = 10;
$pageNum_proveedor = 0;
if (isset($_GET['pageNum_proveedor'])) {
  $pageNum_proveedor = $_GET['pageNum_proveedor'];
}
$startRow_proveedor = $pageNum_proveedor * $maxRows_proveedor;

$colname_proveedor = "-1";
if (isset($_POST['textfield'])) {
  $colname_proveedor = $_POST['textfield'];
}
$maxRows_proveedor = 10;
$pageNum_proveedor = 0;
if (isset($_GET['pageNum_proveedor'])) {
  $pageNum_proveedor = $_GET['pageNum_proveedor'];
}
$startRow_proveedor = $pageNum_proveedor * $maxRows_proveedor;

mysql_select_db($database_conexionBD, $conexionBD);
$query_proveedor = "SELECT * FROM proveedor WHERE nombre_proveedor like '%$colname_proveedor%'ORDER BY nombre_proveedor ASC";
$query_limit_proveedor = sprintf("%s LIMIT %d, %d", $query_proveedor, $startRow_proveedor, $maxRows_proveedor);
$proveedor = mysql_query($query_limit_proveedor, $conexionBD) or die(mysql_error());
$row_proveedor = mysql_fetch_assoc($proveedor);

if (isset($_GET['totalRows_proveedor'])) {
  $totalRows_proveedor = $_GET['totalRows_proveedor'];
} else {
  $all_proveedor = mysql_query($query_proveedor);
  $totalRows_proveedor = mysql_num_rows($all_proveedor);
}
$totalPages_proveedor = ceil($totalRows_proveedor/$maxRows_proveedor)-1;

$queryString_proveedor = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_proveedor") == false && 
        stristr($param, "totalRows_proveedor") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_proveedor = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_proveedor = sprintf("&totalRows_proveedor=%d%s", $totalRows_proveedor, $queryString_proveedor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Biblio-UTS</title>
<link href="/biblioteca/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: "myriad Pro";
	font-size: 14px;
	text-align: left;
	padding-top: 2px;
}
</style>
<!-- funcion para abrir ventana-->
<script> 
function abrir(url) { 
open(url,'','top=200,left=700,width=400,height=300') ; 
} 
</script> 
<script>
function confirmacion(){
var answer=confirm("¿Desea eliminar el registro?")
if (answer) {
alert("Registro eliminado")
window.location="editoriales_eliminar.php"
}
else {
alert("Cancelado")}
}
</script>
<script language="javascript">
function cambiacolor_over(celda){ celda.style.backgroundColor="#f3f3f5" } 
function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }//Cambiar color de celda al pasar mouse
</script>




</head>

<body>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FBDD">
    <td bgcolor="#E6FBDD"><H1 class="titulos">PROVEEDORES</H1></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#666666">
    <td width="97%"><form id="form1" name="form1" method="post" action="">
       &nbsp;&nbsp;&nbsp;&nbsp;
           <input name="textfield" type="text"  id="textfield" size="32" placeholder="Digite nombre del Proveedor"/>
      <input class="boton" type="submit" name="button" id="button" value="Buscar" />
    </form></td>
    <td width="3%"><div align="center"><span class="texto_tabla"><span class="Nuevo_registro"><a href="javascript:abrir('/biblioteca/proveedores_nuevo.php')"><img src="images/add2-.png" width="30" height="30" border="0" /></a></span></span></div></td>
  </tr>
</table>
<?php if ($totalRows_proveedor!=0) {?>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <tH>&nbsp;C&Oacute;DIGO</tH>
    <tH>&nbsp;NOMBRE</tH>
    <tH>&nbsp;DIRECCI&Oacute;N</tH>
    <tH>&nbsp;TELEFONO</tH>
    <tH>&nbsp;CIUDAD</tH>
    <tH>&nbsp;</tH>
  </tr>
  <?php do { ?>
    <tr bgcolor="#FFFFFF" class="texto_tabla" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"

>
      <td class="texto_tabla">&nbsp; <?php echo strtoupper  ($row_proveedor['id_proveedor']); ?></td>
      <td>&nbsp; <?php echo strtoupper ($row_proveedor['nombre_proveedor']); ?></td>
      <td>&nbsp;<?php echo strtoupper ($row_proveedor['direccion']); ?></td>
      <td align="right" valign="middle" class="texto_tabla">&nbsp;<?php echo strtoupper ($row_proveedor['telefono']); ?></td>
      <td width="21%" align="right" valign="middle" class="texto_tabla">&nbsp;<?php echo strtoupper ($row_proveedor['ciudad']); ?></td>
      <td width="3%" align="right" valign="middle" class="texto_tabla"><div align="center"><a href="javascript:abrir('/biblioteca/proveedores_actualizar.php?id_proveedor=<?php echo $row_proveedor['id_proveedor']; ?>')"><img src="images/edit.png" width="20" height="20" /></a></div></td>
    </tr>
    <?php } while ($row_proveedor = mysql_fetch_assoc($proveedor)); ?>
  <tr bgcolor="#FFFFFF">
    <td colspan="6"> Registros <?php echo ($startRow_proveedor + 1) ?> a <?php echo min($startRow_proveedor + $maxRows_proveedor, $totalRows_proveedor) ?> de <?php echo $totalRows_proveedor ?></td>
  </tr>
</table>
<?php }?>
<div align="right"><a href="javascript:document.location.reload();"><img src="images/refresh.png" width="30" height="30" border="0" /></a></div>
</body>
</html>
<?php
mysql_free_result($proveedor);
?>
