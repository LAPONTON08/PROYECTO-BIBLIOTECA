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

$maxRows_editoriales = 10;
$pageNum_editoriales = 0;
if (isset($_GET['pageNum_editoriales'])) {
  $pageNum_editoriales = $_GET['pageNum_editoriales'];
}
$startRow_editoriales = $pageNum_editoriales * $maxRows_editoriales;

$colname_editoriales = "-1";
if (isset($_POST['textfield'])) {
  $colname_editoriales = $_POST['textfield'];
}
$maxRows_editoriales = 10;
$pageNum_editoriales = 0;
if (isset($_GET['pageNum_editoriales'])) {
  $pageNum_editoriales = $_GET['pageNum_editoriales'];
}
$startRow_editoriales = $pageNum_editoriales * $maxRows_editoriales;

mysql_select_db($database_conexionBD, $conexionBD);
$query_editoriales = "SELECT * FROM editorial WHERE nombre_editorial like '%$colname_editoriales%' ORDER BY nombre_editorial ASC";
$query_limit_editoriales = sprintf("%s LIMIT %d, %d", $query_editoriales, $startRow_editoriales, $maxRows_editoriales);
$editoriales = mysql_query($query_limit_editoriales, $conexionBD) or die(mysql_error());
$row_editoriales = mysql_fetch_assoc($editoriales);

if (isset($_GET['totalRows_editoriales'])) {
  $totalRows_editoriales = $_GET['totalRows_editoriales'];
} else {
  $all_editoriales = mysql_query($query_editoriales);
  $totalRows_editoriales = mysql_num_rows($all_editoriales);
}
$totalPages_editoriales = ceil($totalRows_editoriales/$maxRows_editoriales)-1;

$queryString_editoriales = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_editoriales") == false && 
        stristr($param, "totalRows_editoriales") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_editoriales = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_editoriales = sprintf("&totalRows_editoriales=%d%s", $totalRows_editoriales, $queryString_editoriales);
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
	padding-top: 2px;
}
</style>
<!-- funcion para abrir ventana-->
<script> 
function abrir(url) { 
open(url,'','top=200,left=900,width=400,height=200') ; 
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
<table width="90%" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FBDD">
    <td><H1 class="titulos">EDITORIALES</H1></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#666666">
    <td width="97%"><form id="form1" name="form1" method="post" action="">
       &nbsp;&nbsp;&nbsp;&nbsp;
           <input name="textfield" type="text" id="textfield" size="32" placeholder="Digite nombre de la Editorial"/>
      <input class="boton" type="submit" name="button" id="button" value="Buscar" />
    </form></td>
    <td width="3%"><div align="center"><span class="texto_tabla"><span class="Nuevo_registro"><a href="javascript:abrir('/biblioteca/editoriales_nuevo.php')"><img src="images/add2-.png" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'" width="30" height="30" /></a></span></span></div></td>
  </tr>
</table>
<?php if ($totalRows_editoriales!=0) {?>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <tH width="8%">&nbsp;C&Oacute;DIGO</tH>
    <tH>&nbsp;NOMBRE</tH>
    <tH>&nbsp;</tH>
  </tr>
  <?php do { ?>
    <tr bgcolor="#FFFFFF" class="texto_tabla" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"
>
      <td class="codigo"> <?php echo $row_editoriales['id_editorial']; ?></td>
      <td width="86%">&nbsp; <?php echo strtoupper($row_editoriales['nombre_editorial']); ?></td>
      <td width="3%" align="right" valign="middle" class="texto_tabla"><div align="center"><a href="javascript:abrir('/biblioteca/editoriales_actualizar.php?id_editorial=<?php echo $row_editoriales['id_editorial']; ?>')"><img src="images/edit.png" width="20" height="20" /></a></div></td>
    </tr>
    <?php } while ($row_editoriales = mysql_fetch_assoc($editoriales)); ?>
  <tr bgcolor="#FFFFFF">
    <td colspan="3"> Registros <?php echo ($startRow_editoriales + 1) ?> a <?php echo min($startRow_editoriales + $maxRows_editoriales, $totalRows_editoriales) ?> de <?php echo $totalRows_editoriales ?></td>
  </tr>
</table>
<?php }?>
<div align="right"><a href="javascript:document.location.reload();"><img src="images/refresh.png" width="40" height="40" border="0" /></a></div>
</body>
</html>
<?php
mysql_free_result($editoriales);
?>
