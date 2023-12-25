<?php require_once('Connections/conexionBD.php'); mysql_query("SET NAMES 'UTF8'");?><?php
$currentPage = $_SERVER["PHP_SELF"];

$colname_prestamos = "-1";
if (isset($_POST['cod_uts'])) {
  $colname_prestamos = (get_magic_quotes_gpc()) ? $_POST['cod_uts'] : addslashes($_POST['cod_uts']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_prestamos = sprintf("SELECT * FROM prestamos1 WHERE cod_uts = %s", $colname_prestamos);
$prestamos = mysql_query($query_prestamos, $conexionBD) or die(mysql_error());
$row_prestamos = mysql_fetch_assoc($prestamos);
$totalRows_prestamos = mysql_num_rows($prestamos);

mysql_select_db($database_conexionBD, $conexionBD);
$query_Recordset1 = "SELECT * FROM variables_globales";
$Recordset1 = mysql_query($query_Recordset1, $conexionBD) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$maxRows_prestamos = 10;
$pageNum_prestamos = 0;
if (isset($_GET['pageNum_prestamos'])) {
  $pageNum_prestamos = $_GET['pageNum_prestamos'];
}
$startRow_prestamos = $pageNum_prestamos * $maxRows_prestamos;

$colname_prestamos = "-1";
if (isset($_POST['cod_uts'])) {
  $colname_prestamos = (get_magic_quotes_gpc()) ? $_POST['cod_uts'] : addslashes($_POST['cod_uts']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_prestamos = sprintf("SELECT * FROM prestamos1 WHERE cod_uts = %s", $colname_prestamos);
$query_limit_prestamos = sprintf("%s LIMIT %d, %d", $query_prestamos, $startRow_prestamos, $maxRows_prestamos);
$prestamos = mysql_query($query_limit_prestamos, $conexionBD) or die(mysql_error());
$row_prestamos = mysql_fetch_assoc($prestamos);
//echo $query_prestamos;
if (isset($_GET['totalRows_prestamos'])) {
  $totalRows_prestamos = $_GET['totalRows_prestamos'];
} else {
  $all_prestamos = mysql_query($query_prestamos);
  $totalRows_prestamos = mysql_num_rows($all_prestamos);
}
$totalPages_prestamos = ceil($totalRows_prestamos/$maxRows_prestamos)-1;

$queryString_prestamos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_prestamos") == false && 
        stristr($param, "totalRows_prestamos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_prestamos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_prestamos = sprintf("&totalRows_prestamos=%d%s", $totalRows_prestamos, $queryString_prestamos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="/biblioteca/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: "myriad Pro";
	font-size: 14px;
	text-align: left;
	padding-top: 2px;

}
.Estilo1 {font-size:10px}
</style>
<script> 
function abrir(url) { 
open(url,'','top=200,left=900,width=500,height=150') ; 
} 
</script>
<script language="javascript">
function cambiacolor_over(celda){ celda.style.backgroundColor="#f3f3f5" } 
function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }//Cambiar color de celda al pasar mouse
</script>
  <script language='javascript'>
function msj() {
alert ("El ejemplar ha sido devuelto")
}

</script>
  


</head>

<body>

      <form id="form1" name="form1" method="post" action="">
        <label></label>
		<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr bgcolor="#E6FBDD">
            <td><H1 class="titulos">&nbsp;  DEVOLUCIONES</H1></td>
          </tr>
        </table>
		<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr bgcolor="#666666">
    <td>&nbsp;&nbsp;&nbsp;&nbsp;
      <label>
      
        <input name="cod_uts" type="text" id="cod_uts" size="32" placeholder="Digite c&oacute;digo UTS"/>
        
        <input class="boton" type="submit" name="Submit" value="Buscar" />&nbsp;&nbsp;&nbsp;
     </label></td>
    </tr>
	<?php if ($totalRows_prestamos!=0) { ?>
</table>
 
        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <th>&nbsp; ID PR&Eacute;STAMO </th
    >
            <th>&nbsp;NOMBRE LIBRO</th>
            <th>&nbsp; N&deg; EJEMPLAR</th>
            <th>&nbsp; ESTUDIANTE</th>
            <th>&nbsp; FECHA PR&Eacute;STAMO</th>
            <th>&nbsp;FECHA DEVOLUCI&Oacute;N</th>
            <th colspan="5">&nbsp; FECHA ENTREGA </th>
          </tr>
       
		  <?php do { ?>
              <tr bgcolor="#FFFFFF" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"
 >
                <td>&nbsp;<?php echo $row_prestamos['id_prestamo']; ?></td>
                <td>&nbsp;<?php echo $row_prestamos['nombre_libro']; ?></td>
                <td>&nbsp;<?php echo $row_prestamos['n_ejemplar']; ?></td>
                <td>&nbsp;<?php echo strtoupper ($row_prestamos['nombre_comp']); ?></td>
                <td>&nbsp;<?php echo $row_prestamos['fecha_prestamo']; ?></td>
                <td>&nbsp;<?php echo $row_prestamos['fecha_devolucion']; $fecha_devolucion = $row_prestamos['fecha_devolucion']; ?></td>
                <td><?php echo date("Y-m-d H:i:s"); $fecha_entrega = date("Y-m-d H:i:s"); ?></td>
                <td><?php 
			$fecha_devolucion=strtotime('now') - strtotime($fecha_devolucion);
			$diferencia_dias = intval($fecha_devolucion/60/60/24);
			if ($diferencia_dias>0) { echo "Tiene " . $diferencia_dias . " dias de multa por $ " . ($row_Recordset1['valor_multa']*$diferencia_dias);    } ;?></td>
              <?php if($diferencia_dias>1) { ?> 
			    <td>&nbsp;<a href="formato_multa.php?id_prestamo=<?php echo $row_prestamos['id_prestamo'];?>"> Multar</a></td>
                <?php } else { ?>
			  <td><a href="modificar_estado2.php?id_ejemplar=<?php echo $row_prestamos['id_ejemplar']; ?>" onClick="msj()">&nbsp;Devolver</a></td>
			  <?php } ?>
			    <td>&nbsp;<a href="prestamos.php?id_ejemplar=<?php echo $row_prestamos['id_ejemplar']; ?>&amp;id_libro=<?php echo $row_prestamos['id_libro']; ?>">Renovar</a></td>
              </tr>
			  <?php } while ($row_prestamos = mysql_fetch_assoc($prestamos)); ?>
          <tr bgcolor="#FFFFFF">
            <td colspan="11">&nbsp;
              
Registros <?php echo ($startRow_prestamos + 1) ?> a <?php echo min($startRow_prestamos + $maxRows_prestamos, $totalRows_prestamos) ?> de <?php echo $totalRows_prestamos ?>
<table border="0" width="50%" align="right">
                <tr>
                  <td width="23%" align="center"><?php if ($pageNum_prestamos > 0) { // Show if not first page ?>
                      <a href="<?php printf("%s?pageNum_prestamos=%d%s", $currentPage, 0, $queryString_prestamos); ?>">Primero</a>
                      <?php } // Show if not first page ?>                  </td>
                  <td width="31%" align="center"><?php if ($pageNum_prestamos > 0) { // Show if not first page ?>
                      <a href="<?php printf("%s?pageNum_prestamos=%d%s", $currentPage, max(0, $pageNum_prestamos - 1), $queryString_prestamos); ?>">Anterior</a>
                      <?php } // Show if not first page ?>                  </td>
                  <td width="23%" align="center"><?php if ($pageNum_prestamos < $totalPages_prestamos) { // Show if not last page ?>
                      <a href="<?php printf("%s?pageNum_prestamos=%d%s", $currentPage, min($totalPages_prestamos, $pageNum_prestamos + 1), $queryString_prestamos); ?>">Siguiente</a>
                      <?php } // Show if not last page ?>                  </td>
                  <td width="23%" align="center"><?php if ($pageNum_prestamos < $totalPages_prestamos) { // Show if not last page ?>
                      <a href="<?php printf("%s?pageNum_prestamos=%d%s", $currentPage, $totalPages_prestamos, $queryString_prestamos); ?>">&Uacute;ltimo</a>
                      <?php } // Show if not last page ?>                  </td>
                </tr>
              </table></td>
          </tr>
            <?php } while ($row_prestamos = mysql_fetch_assoc($prestamos)); ?>
        </table>
        <p>&nbsp;</p>
      </form>    
	  </body>
</html>
<?php
mysql_free_result($prestamos);

mysql_free_result($Recordset1);
?>
