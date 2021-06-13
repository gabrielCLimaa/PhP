<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {
		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->render('index');
	}

	public function inscreverse() {
		$this->view->errCad = false;
		$this->render('inscreverse');
	}

	public function registrar() {
		$usuario = Container::getModel('Users');
		$usuario->__set('name',$_POST['nome']);
		$usuario->__set('email',$_POST['email']);
		$usuario->__set('password',md5($_POST['senha']));
		if($usuario->validateUser() && count($usuario->getUserEmail()) == 0 ) {
			$usuario->saveUser();
			$this->render('cadastro');
		} else {
			$this->view->errCad = true;	
			$this->render('inscreverse');

		}
	}
}

?>