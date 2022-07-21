<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;


 class Mail{

 /* Validaciones */

	
	/* Email */
	
	function enviarEmail($email, $nombre, $asunto, $cuerpo){

		require_once './vendor/autoload.php';
		
		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'STARTTLS';
		$mail->Host = 'smtp.office365.com';
		$mail->Port = '587';

		$mail->Username = 'ferhaylock1555@outlook.com';
		$mail->Password = 'fernando12345';

		$mail->setFrom('ferhaylock1555@outlook.com', 'Gestion de cuentas');
		$mail->addAddress($email, $nombre);

		$mail->Subject = $asunto;
		$mail->Body    = $cuerpo;
		$mail->IsHTML(true);

		if($mail->send())
		return true;
		else
		return false;
	}




	

 }
	

	



