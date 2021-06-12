<?php

	require '../../private_lista_tarefas/conexao.php';
	require '../../private_lista_tarefas/tarefa.model.php';
	require '../../private_lista_tarefas/tarefa.service.php';

	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

	if($acao == 'inserir') {	
		$task = new Tarefa();
		$task-> __set('task', $_POST['tarefa']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao,$task);
		$tarefaService->insert();

		header('Location: nova_tarefa.php?inclusao=1');
	} else if($acao == 'recuperar') {
		$task = new Tarefa();
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao,$task);
		$tarefas = $tarefaService->read();
	} else if($acao == 'atualizar') {
		$task = new Tarefa();
		$task->__set('id',$_POST['id']);
		$task->__set('task',$_POST['tarefa']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao,$task);
		if($tarefaService->update()) {
			header('Location: todas_tarefas.php');
		}

	} else if($acao == 'remover') {
		$task = new Tarefa();
		$task->__set('id',$_GET['id']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao,$task);
		$tarefaService->delete();
		header('Location: todas_tarefas.php');
	} else if($acao == 'realizada') {
		$task = new Tarefa();
		$task->__set('id', $_GET['id']);
		$task->__set('id_status', 2);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $task);
		$tarefaService->realizada();

		header('Location: todas_tarefas.php');
	}


?>