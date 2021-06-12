<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

  	// -----------------------------------
	class Mensagem {

		private $destinatario = null;
		private $assunto = null;
		private $mensagem = null;

		public $status = array('codigo_status' => null, 'descricao_status' => '' );

		public function __get($atributo) {
			return $this-> $atributo;
		}

		public function __set($atributo, $valor) {
			$this-> $atributo = $valor;
		}

		public function mensagemValida() {
			if(empty($this->destinatario) || empty($this->assunto) || empty($this->mensagem)){
				return false;
			}
			return true;
		}

	}

	//----------------------------------------------------------------------------------------

	$msg = new Mensagem();

	$msg-> __set('destinatario',$_POST['destinatario']);
	$msg-> __set('assunto',$_POST['assunto']);
	$msg-> __set('mensagem',$_POST['mensagem']);

	if(!$msg-> mensagemValida()) {
		 echo 'Opa, deu algo errado!!';
		 header('Location: index.php?login=erro');
	} 

	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = false;                      					//Enable verbose debug output
	    $mail->isSMTP();                                            //Send using SMTP
	    $mail->Host       = 'smtp.gmail.com';              	       //Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	    $mail->Username   = 'EMAIL';                  			   //SMTP username
	    $mail->Password   = 'SENHA';                               //SMTP password
	    $mail->SMTPSecure = 'TLS';        							 //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	    //Recipients
	    $mail->setFrom('EMAIL', 'Remetente');
	    $mail->addAddress($msg-> __get('destinatario'));     //Add a recipient      
	    //$mail->addReplyTo('info@example.com', 'Information');
	    //$mail->addCC('cc@example.com');
	    //$mail->addBCC('bcc@example.com');

	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

	    //Content
	    $mail->isHTML(true);                                  //Set email format to HTML
	    $mail->Subject = $msg-> __get('assunto');
	    $mail->Body    = $msg-> __get('mensagem');
	    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $mail->send();
	   	
	   	$msg->status['codigo_status'] = 1;
	    $msg->status['descricao_status'] = 'Email enviado com sucesso!!';

	} catch (Exception $e) {
		$msg->status['codigo_status'] = 2;
	    $msg->status['descricao_status'] = 'Desculpe, mas não foi possivel enviar o email. Error:  ' . $mail->ErrorInfo;;

	}

?>

<html>
	<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	</head>
	<body>
		<div class="container">

			<?php include 'Lib/PHPMail/header.php';?>

			<div class="row">
				<div class="col-md-12">
					
					<?php if($msg->status['codigo_status'] == 1) { ?>

						<div class="container">
							<h1 class="display-4 text-success">Sucesso</h1>
							<p><?php $msg->status['descricao_status']?></p>
							<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
						</div>

					<?php } ?>
						
					<?php if($msg->status['codigo_status'] == 2) { ?>

						<div class="container">
							<h1 class="display-4 text-danger">Opa, houve um erro!!</h1>
							<p><?php $msg->status['descricao_status']?></p>
							<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar e tentar novamente!</a>
						</div>

					<?php } ?>

				</div>
			</div>
		</div>
	</body>
</html>