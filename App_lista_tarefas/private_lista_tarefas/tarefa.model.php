<?php

	class Tarefa {

		private $id;
		private $id_status;
		private $task;
		private $date_register;

		public function __get($atribute) {
			return $this-> $atribute;
		}

		public function __set($atribute,$value) {
			$this-> $atribute = $value;
		}

	}





















?>