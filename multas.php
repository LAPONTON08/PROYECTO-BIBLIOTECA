<?php require_once('Connections/conexionBD.php'); ?>
<?php
$maxRows_multas = 10;
$pageNum_multas = 0;
if (isset($_GET['pageNum_multas'])) {
  $pageNum_multas = $_GET['pageNum_multas'];
}
$startRow_multas = $pageNum_multas * $maxRows_multas;

$colname_multas = "-1";
if (isset($_POST['doc'])) {
  $colname_multas = (get_magic_quotes_gpc()) ? $_POST['doc'] : addslashes($_POST['doc']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_multas = sprintf("SELECT * FROM detalle_multas WHERE doc = %s", $colname_multas);
$query_limit_multas = sprintf("%s LIMIT %d, %d", $query_multas, $startRow_multas, $maxRows_multas);
$multas = mysql_query($query_limit_multas, $conexionBD) or die(mysql_error());
$row_multas = mysql_fetch_assoc($multas);

if (isset($_GET['totalRows_multas'])) {
  $totalRows_multas = $_GET['totalRows_multas'];
} else {
  $all_multas = mysql_query($query_multas);
  $totalRows_multas = mysql_num_rows($all_multas);
}
$totalPages_multas = ceil($totalRows_multas/$maxRows_multas)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: "myriad Pro";
	font-size: 14px;
	text-align: left;
	padding:2px;
	

}
.Estilo1 {font-size:10px}
</style>
<script> 
function abrir(url) { 
open(url,'','top=200,left=900,width=400,height=200') ; 
} 
</script>

</head>

<body>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr bgcolor="#E6FBDD">
            <td><H1 class="titulos">&nbsp; MULTAS </H1></td>
          </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#666666">
    <td><form id="form1" name="form1" method="post" action="">
     &nbsp;&nbsp;&nbsp;&nbsp;
      <label>
        <input name="doc" type="text" id="doc" size="32" placeholder="Digite documento del estudiante"/>
        </label>
   &nbsp; 
   <label>
   <input type="submit" name="Submit" value="Buscar" class="boton" />
   </label>
    &nbsp;&nbsp;
    </form>    </td>
    <td ><a href="javascript:abrir('/biblioteca/valor_multa_actualizar.php')"><img src="images/Valor_multa.png" width="30" height="30" /></a></td>
  </tr>
</table>
<?php if ($totalRows_multas!=0) {?>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th>&nbsp;PR&Eacute;STAMO</th>
    <th>&nbsp;ESTUDIANTE</th>
    <th>&nbsp;D&Iacute;AS DE MULTA</th>
    <th>&nbsp;VALOR DE LA MULTA</th>
    <th>&nbsp;&nbsp;N&deg; CONSIGNACI&Oacute;N</th>
    <th>&nbsp;ESTADO</th>
  </tr>
  <?php do { ?>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;<?php echo $row_multas['id_prestamo']; ?></td>
      <td>&nbsp;<?php echo $row_multas['nombre_comp']; ?></td>
      <td>&nbsp;<?php echo $row_multas['dias_multa']; ?></td>
      <td>&nbsp;$&nbsp;<?php echo $row_multas['valor_multa']; ?></td>
      <td>&nbsp;<?php echo $row_multas['n_consig']; ?></td>
      <td>&nbsp;
      <?php if ( $row_multas['estado']==0) {echo "<a href=\"javascript:abrir('/biblioteca/modificar_multa.php?id_multa=" . $row_multas['id_multa'] ."')\"><img src=\"images/refresh.png\" width=\"20\" height=\"20\" border=\"0\" /></a>";}else{echo "Cancelada";}; ?>
      </td>
	  
    </tr>
    <tr>
      <td colspan="6" bgcolor="#FFFFFF">&nbsp;
Registros <?php echo ($startRow_multas + 1) ?> a <?php echo min($startRow_multas + $maxRows_multas, $totalRows_multas) ?> de <?php echo $totalRows_multas ?> </td>
    </tr>
    <?php } while ($row_multas = mysql_fetch_assoc($multas)); ?>
</table>
<?php }?>
</body>
</html>
<?php
mysql_free_result($multas);
?>
