<?php require_once('Connections/conexionBD.php'); ?><?php
//initialize the session

if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "/biblioteca/login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "/biblioteca/login.php?mensaje=Debe Iniciar Sesion";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$colname_usuario_activo = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario_activo = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_usuario_activo = sprintf("SELECT * FROM usuarios WHERE cod_usuario = %s", $colname_usuario_activo);
$usuario_activo = mysql_query($query_usuario_activo, $conexionBD) or die(mysql_error());
$row_usuario_activo = mysql_fetch_assoc($usuario_activo);
$totalRows_usuario_activo = mysql_num_rows($usuario_activo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script language="JavaScript" type="text/javascript">
//--------------- LOCALIZEABLE GLOBALS ---------------
var d=new Date();
var monthname=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
//Ensure correct for language. English is "January 1, 2004"
var TODAY = monthname[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear();
//---------------   END LOCALIZEABLE   ---------------
</script>
<style type="text/css">
<!--
.style1 {font-size: 16px}
-->
</style>
<link href="/biblioteca/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {font-size: 10px}
body,td,th {
	font-family: myriad Pro;
}
-->
</style>
<link href="CSS/estilo_index.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
.menu {
	font-family: "myriad Pro";
	font-size: 12px;
	color: #CECECE;
}
.menu {
	color: #D0D0D0;
}
.menu {
	color: #99cc66;
}
.menu {
	color: #BFD730;
}
a:link {
	color: #993300;
	text-decoration: none;
}
a:hover {
	color: #5c743d;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
.menu {
	color: #9C6;
	text-align: center;
}
.menu td {
	color: #676767;
}
.GESTION {
	color: #9C6;
	font-family: "myriad Pro";
}
.GESTION td {
	font-size: 12px;
}
.GESTION td {
	font-size: 14px;
}
.GESTION td {
	font-family: "myriad Pro";
}
.GESTION td {
	font-size: 16px;
}
.piedepagina {
	font-size: 12px;
	font-family: "Myriad Pro", "Myriad Pro Light", sans-serif;
	color: #000000;
	font-weight: normal;
	text-align: center;
}
.menu {
}
.menu {
	text-align: center;
}
.Estilo1 {font-size: 12px; font-family: "myriad Pro"; color: #444444; font-weight: bold; text-align: center; }
.Estilo4 {font-family: "myriad Pro"}
</style>
</head>

<body bgcolor="#F4FFE4">
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="37%" height="101" align="left" valign="middle" bgcolor="#FFFFFF"><img src="images/mm_health_photo.jpg" /></td>
        <td width="63%" align="left" valign="middle" bgcolor="#FFFFFF"><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr align="center" valign="middle">
            <td width="14%" align="center"><div align="center"><a href="?menu=5"><img src="images/mm_usuario.png" width="61" height="61" /></a></div></td>
            <td width="13%" align="center"><div align="center"><a href="?menu=9"><img src="images/libros.png" width="61" height="61" /></a></div></td>
            <td width="10%" align="center"><div align="center"><a href="?menu=6"></a><a href="?menu=6"><img src="images/mm_devolver_libro.png" width="61" height="61" /></a></div></td>
            <td width="13%" align="center"><div align="center"><a href="?menu=8"><img src="images/mm_multas.png" width="61" height="61" border="0" /></a></div></td>
            <td width="13%" align="center"><div align="center"><a href="?menu=12"><img src="images/mm_informes.png" width="61" height="61" border="0" /></a></div></td>
            <td width="12%" align="center"><div align="center"><img src="images/mm_utilidades.png" width="61" height="61" border="0" /></div></td>
            <td width="12%" align="center"><div align="center"><a href="<?php echo $logoutAction ?>"><img src="images/mm_salir.png" width="61" height="61" /></a></div></td>
          </tr>
          <tr align="center" valign="middle" class="menu">
            <td><div align="center" class="menu Estilo2">
              <div align="center" class="menu">
                <div align="center">ESTUDIANTES</div>
              </div>
            </div></td>
            <td><div align="center" class="menu">
              <div align="center" class="menu">
                <div align="center">LIBROS</div>
              </div>
            </div></td>
            <td><div align="center" class="menu">
              <div align="center" class="menu">
                <div align="center">DEVOLUCIONES </div>
              </div>
            </div></td>
            <td><div align="center"class="menu">
              <div align="center">MULTAS</div>
            </div></td>
            <td><div align="center" class="menu">
              <div align="center" class="menu">
                <div align="center">INFORMES</div>
              </div>
            </div></td>
            <td><div align="center" class="menu">
              <div align="center" class="menu">
                <div align="center">UTILIDADES</div>
              </div>
            </div></td>
            <td><div align="center" class="menu">
              <div align="center" class="menu">
                <div align="center">SALIR</div>
              </div>
            </div></td>
          </tr>
        </table></td>
      </tr>
      </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#99CC66">
          <td>&nbsp;</td>
          <td height="20" bgcolor="#99CC66" id="dateformat5"><a href="javascript:;">PRINCIPAL</a>&nbsp;&nbsp;::&nbsp;&nbsp;
          <script language="javascript" type="text/javascript">
      document.write(TODAY);	</script>
          &nbsp;&nbsp;&nbsp;<?php echo strtoupper ($row_usuario_activo['nombre']); ?> &nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr align="center" valign="middle" class="GESTION">
          <td height="57"><span class="pageName">
            <div align="center">
              <div align="center">
                <p>SISTEMA DE GESTI&Oacute;N DE RECURSOS BIBLIOGRÁFICOS </p>
              </div>
            </div>
          </span></td>
          <td class="pageName">
            <div align="center">
              <div align="center">
                <p>SISTEMA DE GESTI&Oacute;N DE RECURSOS BIBLIOGRÁFICOS </p>
              </div>
            </div>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td>
            <?php 
		    
		if (isset($_GET['menu'])) { $menu = $_GET['menu'];
			
		if ($menu==1){require('autores.php');}
		if ($menu==2){require('editoriales.php');}
		if ($menu==3){require('proveedores.php');}
		if ($menu==4){require('areas.php');}
		if ($menu==5){require('alumnos.php');}
		if ($menu==6){require('multas_devoluciones.php');}
		if ($menu==7){require('usuarios.php');}
		if ($menu==8){require('multas.php');}
		if ($menu==9){require('libros.php');}
		if ($menu==10){require('libro_detalle1.php');}
		if ($menu==11){require('prestamos.php');}
		if ($menu==12){ 
		//llamamamos los reportes en un iframe 
	echo "<iframe src=\"reportes/index.php\" width=\"100%\" height=\"500\" frameborder=\"0\" marginwidth=\"0\">Cargando Reportes</iframe>";}
		  
		  }
		  
		  ?>          </td>
        </tr>
        <tr>
          <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" valign="middle"><div align="center"><span class="menu"><a href="?menu=2"><img src="images/mm_editorial.png" width="50" height="50" /></a></span></div></td>
              <td align="center" valign="middle"><div align="center"><span class="menu"><a href="?menu=1"><img src="images/mm_autor.png" width="50" height="50" /></a></span></div></td>
              <td align="center" valign="middle"><div align="center"><span class="menu"><a href="?menu=3"><img src="images/mm_proveedor.png" width="50" height="50" /></a></span></div></td>
              <td align="center" valign="middle"><div align="center"><a href="?menu=7"><img src="images/usuarios.png" width="50" height="50" border="0" /></a></div></td>
              <td align="center" valign="middle"><div align="center"><span class="menu"><a href="?menu=4"><img src="images/mm_area.png" width="50" height="50" border="0" /></a></span></div></td>
              </tr>
            <tr>
              <td align="center" valign="middle" class="menu"><div align="center" class="menu">
                <div align="center">EDITORIALES</div>
              </div></td>
              <td align="center" valign="middle" class="menu"><div align="center" class="menu">
                <div align="center">AUTORES</div>
              </div></td>
              <td align="center" valign="middle" class="menu"><div align="center" class="menu">
                <div align="center">PROVEEDORES</div>
              </div></td>
              <td align="center" valign="middle" class="menu"><div align="center">USUARIOS</div></td>
              <td align="center" valign="middle" class="menu"><div align="center" class="menu">
                <div align="center">&Aacute;REAS</div>
              </div></td>
              </tr>
          </table>
          <div align="center"></div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td bgcolor="#D0D0D0"><blockquote>
          <p class="piedepagina">&copy;&nbsp;Todos los derechos reservados . Unidades Tecnol&oacute;gicas de Santander</p>
          <pre class="piedepagina"><?php echo date('Y') ?></pre>
        </blockquote></td>
      </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
//mysql_free_result($usuario_activo);
?>