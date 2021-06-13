<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {
    public function timeline() {  
        session_start();  
        $this->validateSession();
            $tweet = Container::getModel('Tweet');
            $tweet->__set('id_user',$_SESSION['id']);
            $tweets = $tweet->getAll(); 
            $this->view->tweets = $tweets;

            $user = Container::getModel('Users');
            $user->__set('id',$_SESSION['id']);

            $this->view->info_user = $user->getInfoUser();
            $this->view->total_tweets = $user->getUserTweets();
            $this->view->total_seguindo = $user->getUserFollowing();
            $this->view->total_seguidores = $user->getUserFollow();

            $this->render('timeline');
    }

    public function tweet() {
        session_start();
        $this->validateSession();
            $tweet = Container::getModel('Tweet');
            $tweet->__set('tweet',$_POST['tweet']);
            $tweet->__set('id_user',$_SESSION['id']);

            $tweet->save();

            header('Location: /timeline');
    }

    public function validateSession() {
        session_start();
        if($_SESSION['id'] == '' || $_SESSION['nome'] == '') {
            header('Location: /?login=err');
        }
    }

    public function quemSeguir() {
        session_start();
        $this->validateSession();

        $popSearch = isset($_GET['popSearch']) ? $_GET['popSearch'] : '';

        $users = array();

        if($popSearch != '') {
            $user = Container::getModel('Users');
            $user->__set('name',$popSearch);
            $user->__set('id',$_SESSION['id']);
            $users = $user->getAll();
        }
        
        $this->view->users = $users;
        $this->render('quemSeguir');
    }

    public function acao() {
        $this->validateSession();
        

        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
        $id_usuario_seguindo = isset($_GET['id_user']) ? $_GET['id_user'] : '';

        $user = Container::getModel('Users');
        $user->__set('id', $_SESSION['id']);

        if($acao == 'seguir') {
            $user->seguirUsuario($id_usuario_seguindo);
            header('Location: /quem_seguir');
        } elseif($acao == 'deixar_de_seguir') {
            $user->deixarSeguir($id_usuario_seguindo);
            header('Location: /quem_seguir');
        } elseif($acao == 'remover') {
            $tweet = Container::getModel('Tweet');
            $tweet->__set('id',$_GET['id_tweet']);
            $tweet->removeTweet();
            
        }
    }

    public function menu() {
        session_start();
        $this->validateSession();
        $tweet = Container::getModel('Tweet');
        $tweet->__set('id_user',$_SESSION['id']);
        $tweets = $tweet->getAll(); 
        $this->view->tweets = $tweets;

        $user = Container::getModel('Users');
        $user->__set('id',$_SESSION['id']);

        $this->view->info_user = $user->getInfoUser();
        $this->view->total_tweets = $user->getUserTweets();
        $this->view->total_seguindo = $user->getUserFollowing();
        $this->view->total_seguidores = $user->getUserFollow();

        $this->render('menu');
    }
}

?>