<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<title>Guardar Pol&iacute;gono</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<meta name="robots" content="noindex,nofollow">

<link href="popup.css" rel="stylesheet" type="text/css">

<script language="JavaScript">

    
function fcnAjax(){
var nombre = document.F1.nombre.value;
var obs = document.F1.observ.value;
var id = document.F1.pId.value;
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			
		refreshParent();
		
		}
	}
	ajaxRequest.open("GET", 'procesoPol.php?nombre='+nombre+'&obs='+obs+'&id='+id, true);
	ajaxRequest.send(null); 
}
  




function refreshParent() {
  window.opener.location.href = window.opener.location.href;

  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
  window.close();
}





</script>
</head>

<body>



<table width="360" border="0" align="center" cellpadding="0" cellspacing="0">

<tr>



<form name="F1">



<table border="0" align="center"  cellpadding="2" cellspacing="0" bgcolor="#F5F4F7" style="font-family: Arial; font-size: 10pt; border-collapse: collapse">
<tr><td></td><td><input type="text" name="pId" value="<?php echo $_GET["id"];?>" </td> </tr>

<tr><td>Nombre: </td><td><input type="text"  name="nombre" size="25" value="" maxlength="40"></td></tr>

<tr><td>Observacion: </td><td><input type="text" name="observ" size="25" value="" maxlength="40"></td></tr>



<tr>

  <td height="30" align="center" colspan="2">

    <div align="center">

      <input name="popup" type="button" value="Guardar" onclick="fcnAjax()">

  </div></td></tr></table>

</p>

      </form>

      

  </tr>

</table>



</body>

</html>
