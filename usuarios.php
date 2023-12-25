<?php require_once('Connections/conexionBD.php'); ?><?php require_once('Connections/conexionBD.php'); mysql_query("SET NAMES 'UTF8'"); ?>
<?php
$maxRows_usuarios = 10;
$pageNum_usuarios = 0;
if (isset($_GET['pageNum_usuarios'])) {
  $pageNum_usuarios = $_GET['pageNum_usuarios'];
}
$startRow_usuarios = $pageNum_usuarios * $maxRows_usuarios;

$colname_usuarios = "-1";
if (isset($_POST['cod_usuario'])) {
  $colname_usuarios = (get_magic_quotes_gpc()) ? $_POST['cod_usuario'] : addslashes($_POST['cod_usuario']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_usuarios = sprintf("SELECT * FROM usuarios1 WHERE cod_usuario = %s", $colname_usuarios);
$query_limit_usuarios = sprintf("%s LIMIT %d, %d", $query_usuarios, $startRow_usuarios, $maxRows_usuarios);
$usuarios = mysql_query($query_limit_usuarios, $conexionBD) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);

if (isset($_GET['totalRows_usuarios'])) {
  $totalRows_usuarios = $_GET['totalRows_usuarios'];
} else {
  $all_usuarios = mysql_query($query_usuarios);
  $totalRows_usuarios = mysql_num_rows($all_usuarios);
}
$totalPages_usuarios = ceil($totalRows_usuarios/$maxRows_usuarios)-1;
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
</style>
<script language="javascript">
function cambiacolor_over(celda){ celda.style.backgroundColor="#f3f3f5" } 
function cambiacolor_out(celda){ celda.style.backgroundColor="#ffffff" }//Cambiar color de celda al pasar mouse
</script>
<script> 
function abrir(url) { 
open(url,'','top=200,left=900,width=500,height=400') ; 
} 
</script>
</head>

<body>
<table width="90%" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FBDD">
    <td><H1 class="titulos">USUARIOS</H1></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#666666">
    <td><form id="form1" name="form1" method="post" action="">
	&nbsp;&nbsp;&nbsp;&nbsp;
      
        <label>
          <input name="cod_usuario" type="text" id="cod_usuario" size="32" placeholder="Digite N&deg; documento o Nombre del usuario"/>
        </label>
        <label>
        <input type="submit" name="Submit" value="Buscar" class="boton"/>
        </label>
   &nbsp;&nbsp;&nbsp;
    </form>    </td>
    <td><div align="center"><a href="javascript:abrir('/biblioteca/tipousuario_crear.php')"><img src="images/Tipo_usuario.png" width="30" height="30" /></a></div></td>
    <td width="3%"><div align="center"><a href="javascript:abrir('/biblioteca/usuario_interno_nuevo.php')"><img src="images/add2-.png" width="30" height="30" border="0" /></a></div></td>
  </tr>
</table>
<?php if ($totalRows_usuarios!=0){?>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th>&nbsp;DOCUMENTO</th>
    <th>&nbsp;NOMBRE</th>
    <th>&nbsp;DIRECCI&Oacute;N</th>
    <th>&nbsp;TEL&Eacute;FONO</th>
    <th>&nbsp;CORREO</th>
    <th>&nbsp;USUARIO</th>
    <th colspan="2">&nbsp;ESTADO</th>
  </tr>
  <?php do { ?>
      <tr bgcolor="#FFFFFF"onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
        <td>&nbsp;<?php echo strtoupper ($row_usuarios['cod_usuario']); ?></td>
        <td>&nbsp;<?php echo strtoupper ($row_usuarios['nombre' ]); ?></td>
        <td>&nbsp;<?php echo $row_usuarios['direccion']; ?></td>
        <td>&nbsp;<?php echo $row_usuarios['telefono']; ?></td>
        <td>&nbsp;<?php echo $row_usuarios['correo']; ?></td>
        <td>&nbsp;<?php echo $row_usuarios['nombre_tipo_usuario']; ?></td>
        <td>&nbsp;<?php echo $row_usuarios['estado_usuario']; ?></td>
        <td width="3%"><div align="center"><a href="javascript:abrir('/biblioteca/usuario_interno_actualizar.php?id_usuario=<?php echo $row_usuarios['id_usuario']; ?> ')"><img src="images/edit.png" width="20" height="20" border="0" /></a></div></td>
      </tr>
    <tr bgcolor="#FFFFFF"onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
      <td colspan="8">&nbsp;</td>
    </tr>
    <?php } while ($row_usuarios = mysql_fetch_assoc($usuarios)); ?>
</table>
<?php }?>
</body>
</html>
<?php
mysql_free_result($usuarios);
?>
