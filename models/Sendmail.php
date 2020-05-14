<?php

use PHPMailer\PHPMailer\PHPMailer;

class Sendmail extends database {

	public function __construct() {
		parent::__construct();
	}
	public function sendMail($data) {

		$mail     = new PHPMailer;
		$toReturn = array();

		//Enable SMTP debugging.
		$mail->SMTPDebug = false;
		//Set PHPMailer to use SMTP.
		$mail->isSMTP();
		//Set SMTP host name
		$mail->Host = "smtp.gmail.com";

		//Set this to true if SMTP host requires authentication to send email
		$mail->SMTPAuth = true;
		//Provide username and password
		$mail->Username = "jiyadave2050@gmail.com";
		$mail->Password = "hetdave@2016";
		//If SMTP requires TLS encryption then set it
		$mail->SMTPSecure = "tls";
		//Set TCP port to connect to
		$mail->Port = 587;

		$mail->From     = "ajaydave2050@gmail.com";
		$mail->FromName = "ajayd";
		$mail->addAddress($data['email_address']);
		//$mail->addAddress("ajayd@aum.bz", "Ajayd");

		$mail->isHTML(true);

		$mail->Subject = $data['subject'];
		$mail->Body    = $data['content'];

		if (!$mail->send()) {
			$toReturn['status']  = 'Error';
			$toReturn['message'] = $mail->ErrorInfo;
		} else {
			$toReturn['status']  = 'Success';
			$toReturn['message'] = 'Message has been sent successfully';
		}

		//return $toReturn;
	}

}
