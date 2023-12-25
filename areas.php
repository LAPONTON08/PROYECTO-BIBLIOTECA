<?php require_once('Connections/conexionBD.php');  mysql_query("SET NAMES 'UTF8'");?>
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

$maxRows_area = 10;
$pageNum_area = 0;
if (isset($_GET['pageNum_area'])) {
  $pageNum_area = $_GET['pageNum_area'];
}
$startRow_area = $pageNum_area * $maxRows_area;

$colname_area = "-1";
if (isset($_POST['textfield'])) {
  $colname_area = $_POST['textfield'];
}
$maxRows_area = 10;
$pageNum_area = 0;
if (isset($_GET['pageNum_area'])) {
  $pageNum_area = $_GET['pageNum_area'];
}
$startRow_area = $pageNum_area * $maxRows_area;

mysql_select_db($database_conexionBD, $conexionBD);
$query_area = "SELECT * FROM area WHERE nombre_area like '%$colname_area%' ORDER BY nombre_area ASC";
$query_limit_area = sprintf("%s LIMIT %d, %d", $query_area, $startRow_area, $maxRows_area);
$area = mysql_query($query_limit_area, $conexionBD) or die(mysql_error());
$row_area = mysql_fetch_assoc($area);

if (isset($_GET['totalRows_area'])) {
  $totalRows_area = $_GET['totalRows_area'];
} else {
  $all_area = mysql_query($query_area);
  $totalRows_area = mysql_num_rows($all_area);
}
$totalPages_area = ceil($totalRows_area/$maxRows_area)-1;

$queryString_area = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_area") == false && 
        stristr($param, "totalRows_area") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_area = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_area = sprintf("&totalRows_area=%d%s", $totalRows_area, $queryString_area);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Biblio-UTS</title>
<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />

<style type="text/css">
body,td,th {
	font-family: "myriad Pro";
	font-size: 14px;
	text-align: left;
	padding-top: 0px;
}
.img {
	text-align: center;
}
.bus {
	text-align: left;
}
</style>
<!-- funcion para abrir ventana-->
<script> 
function abrir(url) { 
open(url,'','top=200,left=900,width=400,height=150') ; 
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
<form id="form1" name="form1" method="post" action="">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FBDD">
    <td><H1 class="titulos">AREAS</H1></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#666666">
    <td>
      &nbsp;&nbsp;&nbsp;&nbsp;<span class="texto_tabla">
<input style="margin:5px" name="textfield" type="text"  id="textfield" size="32"  placeholder="Digite nombre del Area"/>
      <input class= "boton" type="submit" name="button" id="button" value="Buscar" />
      
    </td>
    <td width="3%"><div align="center"><span class="img"><span class="Nuevo_registro"><a href="javascript:abrir('/biblioteca/areas_nuevo.php')"><img  src="images/add2-.png" width="30" height="30" /></a></span></span></div></td>
  </tr>
</table>
<?php if ($totalRows_area!=0) {?>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <tH width="12%">&nbsp;C&Oacute;DIGO</tH>
    <tH>&nbsp;NOMBRE</tH>
    <tH>&nbsp;</tH>
  </tr>
  <?php do { ?>
    <tr bgcolor="#FFFFFF" class="texto_tabla" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
      <td class="codigo" > <?php echo $row_area['id_area']; ?></td>
      <td width="82%">&nbsp; <?php echo strtoupper ($row_area['nombre_area']); ?></td>
      <td width="3%" align="right" valign="middle" class="texto_tabla"><div align="center"><span class="img"><a href="javascript:abrir('/biblioteca/areas_actualizar.php?id_area=<?php echo $row_area['id_area']; ?>')"><img src="images/edit.png" width="20" height="20" /></a></span></div></td>
      </tr>
    <?php } while ($row_area = mysql_fetch_assoc($area)); ?>
  <tr bgcolor="#FFFFFF">
    <td colspan="3"> Registros <?php echo ($startRow_area + 1) ?> a <?php echo min($startRow_area + $maxRows_area, $totalRows_area) ?> de <?php echo $totalRows_area ?></td>
  </tr>
</table>
<?php }?>
</form>
<div align="right"><a href="javascript:document.location.reload();"><img src="images/refresh.png" width="40" height="40" border="0" /></a></div>
</body>
</html>
<?php
mysql_free_result($area);
?>
