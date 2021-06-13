<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {

    public function autenticar() { 
        $user = Container::getModel('Users');
        $user->__set('email',$_POST['email']);
        $user->__set('password',md5($_POST['senha']));
         
        $callBack = $user->autentiUser();
        
        if($user->__get('id') != '' && $user->__get('name')) {
            session_start();
            $_SESSION['id'] = $user->__get('id');
            $_SESSION['nome'] = $user->__get('name');
            header('Location: /timeline');

        } else {
            header('Location: /?login=err');
        }
    }

    public function sair() {
        session_start();
        session_destroy();
        header('Location: /');
    }


}

?>