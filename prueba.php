
<!doctype html>
<html>
  <head>
  <meta charset="utf-8">
  <title>Boton</title>
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language='javascript'>
function msj() {
alert ("Bienvenidos a mi web")
}

</script>
<head>
<script type="text/javascript">
 
 function abrirHijo() {
 window.open("consultar_estudiante.php", "Consultar", "location=no,menubar=no,titlebar=no,resizable=no,toolbar=no, menubar=no,width=600,height=300"); 
 abrirHijo.focus();
 }
 </script>
 <style> form input:required {border:2px solid orange}
 </style>
  </head>
  <body>
<table width="70%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <tH colspan="2" ><div align="center">DATOS DE PRÉSTAMO </div></tH>
  </tr>
  <tr>
    <td width="132">ALUMNO:</td>
    <td width="401"><form  name="prueba" method="post" action="">
      <label>
        <input name="cod_alumno" type="text" id="cod_alumno" required />
        </label>
      <label>
      <input type="button" name="Submit" value="Consultar estudiante" onClick="abrirHijo()" disabled="disabled">
      </label>
    </form>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  <td><div align="center"><a href="#" onClick="msj()"   >&nbsp;&nbsp; Click Aquí</a> </div>  </tr>
</table>
      
</body>
  
  
  
  
</html>