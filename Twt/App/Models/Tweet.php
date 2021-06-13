<?php
namespace App\Models;

use MF\Model\Model;

class Tweet extends Model {
    private $id;
    private $id_user;
    private $tweet;
    private $data;

    public function __set($attr,$val) {
        $this->$attr = $val;
    }

    public function __get($attr) {
        return $this->$attr;
    }

    public function save() {
        $query = "INSERT INTO tweets(id_user,tweet)VALUES(:id_user,:tweet)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_user',$this->__get('id_user'));
        $stmt->bindValue(':tweet',$this->__get('tweet'));
        $stmt->execute();

        return $this;
    }

    public function getAll() {

        $query = "SELECT t.id, t.id_user, u.name, t.tweet, DATE_FORMAT(t.data,'%d/%m/%Y %H:%i') AS data
         FROM tweets  AS t
         LEFT JOIN users AS u ON(t.id_user = u.id)
         WHERE t.id_user = :id_user
         OR
         t.id_user IN (SELECT id_usuario_seguindo FROM usuarios_seguidores WHERE id_usuario = :id_user)
         ORDER BY t.data DESC";
        $stmt= $this->db->prepare($query);
        $stmt->bindValue(':id_user',$this->__get('id_user'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function removeTweet() {
       $query = "DELETE FROM tweets WHERE id = :id";
       $stmt = $this->db->prepare($query);
       $stmt->bindValue(':id',$this->__get('id'));
       $stmt->execute();
       header('Location: /timeline');

    }
}

?>