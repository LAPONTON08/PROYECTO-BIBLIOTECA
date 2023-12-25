<?php require_once('Connections/conexionBD.php'); ?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['textfield'])) {
  $loginUsername=$_POST['textfield'];
  $password=$_POST['textfield2'];
  $MM_fldUserAuthorization = "id_tipo_usuario";
  $MM_redirectLoginSuccess = "/biblioteca/index.php?menu=9";
  $MM_redirectLoginFailed = "login.php?mensaje=Usuario No valido";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexionBD, $conexionBD);
  	
  $LoginRS__query=sprintf("SELECT cod_usuario, contrasena, id_tipo_usuario FROM usuarios WHERE cod_usuario=%s AND contrasena=%s",
  GetSQLValueString($loginUsername, "int"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conexionBD) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'id_tipo_usuario');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
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
.Estilo6 {
	color: #FFFFFF;
	font-size: x-large;
}
-->
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
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
}
.Estilo7 {font-size: large}
</style>
</head>

<body bgcolor="#F4FFE4">
<table height= "100%" width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="46" align="left" valign="middle" bgcolor="#FFFFFF"><img src="images/mm_health_photo.jpg" width="382" height="101" /></td>
      </tr>
      </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#99CC66">
          <td colspan="2">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr align="center" valign="middle" class="GESTION">
          <td height="57"><span class="pageName">
            <div align="center">
              <div align="center">
                <p class="GESTION">SISTEMA DE GESTI&Oacute;N DE RECURSOS BIBLIOGRÁFICOS </p>
              </div>
            </div>
          </span></td>
          <td class="pageName">
            <div align="center" class="GESTION">
              <div align="center">
                <p>SISTEMA DE GESTI&Oacute;N DE RECURSOS BIBLIOGRÁFICOS </p>
              </div>
            </div>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><p>&nbsp;</p>
            <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
              <table  width="300" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="login">
                <tr bgcolor="#8EC11" >
                  <td width="250" height="33" colspan="2" align="center" valign="top" bgcolor="#8EC11" class="codigo" ><div align="center" class="Estilo6">Inicio de Sesión <img src="images/candado.png" width="20" height="20" /></div></td>
                </tr>
               <tr bgcolor="#F7F7F7">
                <td colspan="2" align="left" class="Estilo7" >&nbsp;&nbsp;&nbsp;&nbsp;Usuario:</td>
                </tr>
                <tr bgcolor="#F7F7F7">
                  <td colspan="2">&nbsp;
                    
                    <div align="left">
                      &nbsp;&nbsp;&nbsp;<input name="textfield" type="text"  id="" size="34" />
                  </div></td>
                </tr>
                <tr bgcolor="#F7F7F7">
                  <td colspan="2"><div align="left" class="Estilo7">&nbsp;&nbsp;&nbsp;&nbsp;Contraseña:</div></td>
                </tr>
                <tr bgcolor="#F7F7F7">
                  <td colspan="2">&nbsp;
                    
                    <div align="left">
                      &nbsp;&nbsp;&nbsp;<input name="textfield2" type="password"  size="34" />
                  </div></td>
                </tr>
                
                <tr bgcolor="#F7F7F7">
                  <td height="33" colspan="2" align="right">
                    
                    <div align="center">
                      <input class="boton" type="submit" name="button" id="button" value="                   Ingresar                   " />
                  </div></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" valign="middle" bgcolor="#EFEFEF"><div style="color:#F00"><?php if (isset($_GET['mensaje'])) { echo  $_GET['mensaje'];}
  ?></div></td>
                </tr>
              </table>
         
            </form>
          <p>&nbsp;</p></td>
        </tr>
      </table>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td bgcolor="#D0D0D0"><p align="center" class="piedepagina">&nbsp;<img src="images/copyright.png" width="10" height="10" />&nbsp;Todos los derechos reservados. Unidades Tecnológicas de Santander</p>
          <p align="center" class="piedepagina"><span class="piedepagina"><strong><?php echo date('Y') ?></strong></span> </p></td>
      </tr>
</table></td>
  </tr>
</table>
</body>
</html>