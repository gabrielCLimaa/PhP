<?php
	
	class TarefaService {

		private $conexao;
		private $task;

		public function __construct(Conexao $conexao,Tarefa $task) {
			$this->conexao = $conexao->connect();
			$this->task = $task;
		}

		public function insert() {
			$query = 'INSERT INTO 
						tb_tarefas(tarefa) 
							VALUES(:task)';

			$stmt = $this->conexao->prepare($query);
			$stmt-> bindValue(':task', $this->task->__get('task'));
			$stmt-> execute();
		}

		public function read() {
			$query = 'SELECT 
						t.id, s.status, t.tarefa
							FROM 
								tb_tarefas AS t
									LEFT JOIN tb_status AS s ON (t.id_status = s.id)';

			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);

		}

		public function update() {
			$query = 'UPDATE 
						tb_tarefas 
							SET  
								tarefa = :tarefa 
									WHERE 
										id = :id';
										
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':tarefa',$this->task->__get('task'));
			$stmt->bindValue(':id',$this->task->__get('id'));
			return $stmt->execute();



		}

		public function delete() {
			$query = 'DELETE 
						FROM
							tb_tarefas
								WHERE 
									id = :id';

			$stmt = $this->conexao->prepare($query);
			$stmt-> bindValue(':id', $this->task->__get('id'));
			$stmt-> execute();

		}

		public function realizada() {
			$query = 'UPDATE 
						tb_tarefas 
							SET  
								id_status = ? 
									WHERE 
										id = ?';
										
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1,$this->task->__get('id_status'));
			$stmt->bindValue(2,$this->task->__get('id'));
			return $stmt->execute();



		}

	}

























?>