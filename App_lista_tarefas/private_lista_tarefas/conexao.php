<?php
	
	class Conexao {

		private $host = 'localhost';
		private $dbname = 'php_pdo';
		private $user = 'root';
		private $password = '';



		public function connect() {
			try{
				$conexao = new PDO("mysql:host=$this->host;dbname=$this->dbname","$this->user","$this->password");
				return $conexao;
			} catch(PDOexception $error) {
				echo '<p>'. $error->getMessage() . '</p>';
			}
		}
	}




















?>