<?php
    include('connect.php');
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	
	require '../../../vendor/phpmailer/phpmailer/src/Exception.php';
	require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
	require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';

    $email = $_GET["email"];

    $request = "SELECT * FROM `users` WHERE `users`.email=:email";
    $stmt=$db -> prepare($request);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowcount()===0){
      header('Location : request.php?c=error');
	  //}else if($stmt2->rowcount()===1){
	}else{
	  //GET array
	  $data=$stmt->fetch(PDO::FETCH_ASSOC);
	  
	  //PREP var
	  $user_email=$data["email"];
	  $user_id=$data["id_user"];
	  $token = openssl_random_pseudo_bytes(16);
	  $user_token = bin2hex($token);
	  
	  //REQUEST insert
	  $request = "INSERT INTO `reset_pswd` (`id_reset`, `ext_user`, `token_reset`) VALUES (NULL, :userid, :token);";
	  $stmt=$db -> prepare($request);
	  $stmt->bindParam(':userid', $user_id, PDO::PARAM_INT);
	  $stmt->bindParam(':token', $user_token, PDO::PARAM_STR);
	  $stmt->execute();
	  
	  //Create an instance; passing `true` enables exceptions
	  $mail = new PHPMailer(true);
	  $mail->CharSet = 'UTF-8';
	  
	  try {
		  $mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
		  );
		  //Server settings
		  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		  $mail->isSMTP();                                            //Send using SMTP
		  $mail->Host       = 'mail.infomaniak.com';                     //Set the SMTP server to send through
		  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		  $mail->Username   = 'support@vivide.app';                     //SMTP username
		  $mail->Password   = 'c6E/D!-CZ$q80ia';                               //SMTP password
		  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		  $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	  
		  //Recipients
		  $mail->setFrom('support@vivide.app', 'VIVIDE.app');
		  $mail->addAddress($data["email"], ''); 
		  $mail->addReplyTo('no-reply@vivide.app', 'no-reply-vivide.app');
	  
	  
		  //Content
		  $email_template = 'mail_template.html';
		  $mail->isHTML(true);                                  //Set email format to HTML
		  $message = file_get_contents($email_template);
		  $message = str_replace('%url%', $user_token, $message);
		  $message = str_replace('%userid%', $user_id, $message);
		  $mail->Subject = 'Changez votre mot de passe';
		  $mail->Body    = $message;
		  $mail->AltBody = '';
	  
		  $mail->send();
		  
		  header('Location : request.php?c=success');
	  }catch (Exception $e) {
		  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	  }
  }