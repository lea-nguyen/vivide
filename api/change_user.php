<?php
	require('../../private/connect.php');

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	use ReallySimpleJWT\Token;

	require('../../private/secret.php');
	require('../../vendor/autoload.php');
	require '../../vendor/phpmailer/phpmailer/src/Exception.php';
	require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
	require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

	header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');
    header("Access-Control-Allow-Origin: https://vivide.app");
    header('Content-Type: application/json , text/plain,charset=UTF-8');

	$data = json_decode(file_get_contents("php://input"), true);

	$token = $data["token"];
	$payload = Token::getPayload($token, $secret);
	$userid = (int) $payload["userid"];
    $email = $data["email"];
    $name = $data["name"];

    $request = "SELECT * FROM `users` WHERE `users`.id_user=:userid";
    $stmt=$db -> prepare($request);
    $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
    $stmt->execute();

    if($stmt->rowcount()==1){

        if($name!=""){
            $change = "UPDATE `users` SET pseudo = $name WHERE id_user=:userid";
            $stmt=$db -> prepare($change);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
            $stmt->execute();
        }
	
        if($email!=""){            
            //PREP var
			$payload = [
			  'iat' => time(),
			  'userid' => $userid,
			  'usermail' => $email,
			  'exp' => time() + (10*0*0*0),
			  'iss' => 'localhost'
			];
		  
			$token = Token::customPayload($payload, $secret);
            $user_email=$data["email"];
            $user_token = openssl_random_pseudo_bytes(16);
            $user_token = bin2hex($user_token);
            
            //REQUEST insert
            $request = "INSERT INTO `change_request` (`ext_user`, `token_reset`) VALUES (:userid, :token);";
            $stmt=$db -> prepare($request);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
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
                $mail->addAddress($email, ''); 
                $mail->addReplyTo('no-reply@vivide.app', 'no-reply-vivide.app');
            
            
                //Content
                $email_template = 'email_template.html';
                $mail->isHTML(true);                                  //Set email format to HTML
                $message = file_get_contents($email_template);
                $message = str_replace('%url%', $user_token, $message);
                $message = str_replace('%userid%', $token, $message);
                $mail->Subject = 'Changez votre mot de passe';
                $mail->Body    = $message;
                $mail->AltBody = '';
                    
                    $mail->send();
			  echo json_encode($token);
            }catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
	
    }