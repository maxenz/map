<?php

function existeUsuarioEnBD() {


	if (isset($_GET["usrId"])) {

		$usuarioEnc = $_GET["usrId"];
		$usuario = decrypt($usuarioEnc,"maxo");

		$conn=odbc_connect('phpShadow','_system','sys');

		if (!$conn) {

			exit("Connection Failed: " . $conn);

		  }

		$query = "SELECT ID FROM Panel.Usuarios WHERE ID = '" .$usuario. "' AND Situacion = 1";
		$result = odbc_exec($conn,$query);

		if (!odbc_fetch_row($result)) {

			die("ERROR");

		}

		else {

			return $usuario;

		}

	}
	else {

		die("ERROR");

	}

}


function seguridadNodos($opcion,$usuario) {

	$conn=odbc_connect('phpShadow','_system','sys');

	if (!$conn) {
		exit("Connection Failed: " . $conn);
	}

	$query = " SELECT TOP 1 acc.TipoOperacionId FROM Panel.PerfilesOpciones acc INNER JOIN Panel.UsuariosPerfiles usr ON (acc.PerfilId = usr.PerfilId)";
	$query = $query . " INNER JOIN Panel.AplicacionesOpciones apl ON (acc.AplicacionOpcionId = apl.ID) WHERE apl.AplicacionId = 'GPSHAMAN' AND apl.OpcionId = '".$opcion;
	$query = $query . "' AND usr.UsuarioId = '" . $usuario . "' ORDER BY acc.TipoOperacionId DESC";

	$result = odbc_exec($conn,$query);

	if (odbc_fetch_row($result)) {

		$permiso = (odbc_result($result,'TipoOperacionId'));

		return $permiso;

	}
	else {

		$permiso = 0;

		return $permiso;
	}

}



?>