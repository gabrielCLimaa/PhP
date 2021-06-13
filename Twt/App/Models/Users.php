<?php
namespace App\Models;

use MF\Model\Model;

class Users extends Model {
    private $id;
    private $name;
    private $email;
    private $password;

    public function __set($attr,$val) {
        $this->$attr = $val;
    }

    public function __get($attr) {
        return $this->$attr;
    }

    public function saveUser() {
        $insert = "INSERT INTO users(name, email, pssw) VALUES(:nome,:email,:senha)";
        $stmt = $this->db->prepare($insert);
        $stmt->bindValue(':nome',$this->__get('name'));
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->bindValue(':senha',$this->__get('password'));
        $stmt->execute();
        return $this;
    }

    public function validateUser() {
        $valid = true;
        if(strlen($this->__get('name')) < 3) {
            $valid = false;
        }
        if(strlen($this->__get('email')) < 3) {
            $valid = false;
        }
        if(strlen($this->__get('password')) < 3) {
            $valid = false;
        }
        return $valid;
    }

    public function getUserEmail() {
        $query = "SELECT email FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function autentiUser() {
        $query = "SELECT id , name, email FROM users WHERE email = :email AND  pssw = :senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->bindValue(':senha',$this->__get('password'));
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($user != '') {
            if($user['id'] != '' && $user['name'] != '') {
                $this->__set('id',$user['id']);
                $this->__set('name',$user['name']);
            }
        }
        return $this;
    }

    public function getAll() {
        $query = "SELECT u.id, u.name, u.email,
        (  
            SELECT COUNT(*) FROM usuarios_seguidores AS us
            WHERE 
            us.id_usuario = :id_user AND us.id_usuario_seguindo = u.id

        ) AS seguindo_sn FROM users AS u WHERE u.name LIKE :name AND u.id != :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name','%' . $this->__get('name') . '%');
        $stmt->bindValue(':id_user',$this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function seguirUsuario($id) {
       $query = "INSERT INTO usuarios_seguidores(id_usuario, id_usuario_seguindo)VALUES(:id_usuario,:id_usuario_seguindo)";
       $stmt = $this->db->prepare($query);
       $stmt->bindValue(':id_usuario',$this->__get('id'));
       $stmt->bindValue(':id_usuario_seguindo',$id);
       $stmt->execute();
       return true;
    }

    public function deixarSeguir($id) {
        $query = "DELETE FROM  usuarios_seguidores WHERE id_usuario = :id_usuario AND id_usuario_seguindo = :id_usuario_seguindo";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario',$this->__get('id'));
        $stmt->bindValue(':id_usuario_seguindo',$id);
        $stmt->execute();
        return true;
    }

    public function getInfoUser() {
        $query = "SELECT name FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserTweets() {
        $query = "SELECT COUNT(*) AS total_tweets FROM tweets WHERE id_user = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserFollowing() {
        $query = "SELECT COUNT(*) AS total_seguindo FROM usuarios_seguidores WHERE id_usuario = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserFollow() {
        $query = "SELECT COUNT(*) AS total_seguidores FROM usuarios_seguidores WHERE id_usuario_seguindo     = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


}

?>