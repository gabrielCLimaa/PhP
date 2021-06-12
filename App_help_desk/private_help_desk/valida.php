<?php

	session_start();

	$usuario_app = array(
		array ('id' => 1,'email' => 'adm@teste.com', 'senha' => '321', 'usuario_perfil_id' => 1),
		array ('id' => 2,'email' => 'user@teste.com', 'senha' => '123', 'usuario_perfil_id' => 2),
		array ('id' => 3,'email' => 'gb@teste.com', 'senha' => '123', 'usuario_perfil_id' => 2),
	);

	$usuario_autenticado = false;
	$usuario_id = null;
	$usuario_perfil_id = null;

	foreach ($usuario_app as $user) {
		if($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']) {
			$usuario_autenticado = true;
			$usuario_id = $user['id'];
			$usuario_perfil_id = $user['usuario_perfil_id'];
		}
	}

	if($usuario_autenticado) {	echo 'SUCESS';	$_SESSION['autenticado'] = 'SIM';$_SESSION['id'] = $usuario_id;$_SESSION['perfil_id'] = $usuario_perfil_id; header('Location: home.php'); } 
	else { header('Location: index.php?login=erro');$_SESSION['autenticado'] = 'NAO'; }

	


?>