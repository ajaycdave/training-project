<?php

require_once __DIR__ ."/includes/common.php";

require_once __DIR__ ."/models/Users.php";
require_once __DIR__ .'/Adminacess.php';

Adminacess::create('Userpage', $twig);

class Userpage {

	private $twig;
	public function __construct($twig) {

		$this->twig = $twig;

		if (isset($_REQUEST['action']) && $_REQUEST['action'] !== "") {
			$action_method = $_REQUEST['action'];
			$this->$action_method();
		} else {
			$this->index();
		}
	}
	public function index() {

		//From email address and name
		/*$mail = new PHPMailer;

		//Enable SMTP debugging.
		$mail->SMTPDebug = 3;
		//Set PHPMailer to use SMTP.
		$mail->isSMTP();
		//Set SMTP host name
		$mail->Host = "smtp.gmail.com";
		//Set this to true if SMTP host requires authentication to send email
		$mail->SMTPAuth = true;
		//Provide username and password
		$mail->Username = "jiydave2050@gmail.com";
		$mail->Password = "hetdave@2016";
		//If SMTP requires TLS encryption then set it
		$mail->SMTPSecure = "tls";
		//Set TCP port to connect to
		$mail->Port = 587;

		$mail->From     = "jiydave2050@gmail.com";
		$mail->FromName = "jiyadave";

		$mail->addAddress("ajayd@aum.bz", "Ajayd");

		$mail->isHTML(true);

		$mail->Subject = "Subject Text";
		$mail->Body    = "<i>Mail body in HTML</i>";
		$mail->AltBody = "This is the plain text version of the email content";

		if (!$mail->send()) {
		echo "Mailer Error: ".$mail->ErrorInfo;
		} else {
		echo "Message has been sent successfully";
		}

		die;*/

		//$objCategory = new Category();
		//	$category->action(array(), $this->twig);
		echo $this->twig->render('user/create.html.twig');

	}
	public function forgot_password() {
		echo $this->twig->render('user/forgotpassword.html.twig');
	}
	public function sendpassword() {
		$objUser = new Users();

		$data['email_address'] = strip_tags(trim($_REQUEST['email_address']));
		$select_user           = "select id from users where email_address='".$data['email_address']."'";

		$sel_user = $objUser->selectOne($select_user);
		if (count($sel_user) > 0) {

			$new_password = 'admin@123';

			$reset_password = "update users set password= '".md5($new_password)."' where id='".$sel_user['id']."'";
			$objUser->execute($reset_password);

			$message['status']  = 'success';
			$message['message'] = 'Password send your email address';

			echo $this->twig->render('user/forgotpassword.html.twig', $message);

		} else {

			$data['message'] = 'Invalid Email Address';
			$data['status']  = 'Error';
			echo $this->twig->render('user/forgotpassword.html.twig', $data);

		}
	}

	public function store() {
		$objUser = new Users();

		$data['first_name']    = strip_tags(trim($_REQUEST['first_name']));
		$data['last_name']     = strip_tags(trim($_REQUEST['last_name']));
		$data['mobile']        = strip_tags(trim($_REQUEST['mobile']));
		$data['email_address'] = strip_tags(trim($_REQUEST['email_address']));
		$data['password']      = strip_tags(trim(md5($_REQUEST['password'])));

		$select_user = "select id from users where email_address='".$data['email_address']."'";

		$sel_user = $objUser->selectOne($select_user);
		if (count($sel_user) > 0) {
			$data['message'] = 'User already available';
			$data['status']  = 'Error';
			echo $this->twig->render('user/create.html.twig', $data);

		} else {
			$insert_sql = "insert into users(first_name,last_name,mobile,email_address,password) values('".$data['first_name']."','".$data['last_name']."','".$data['mobile']."','".$data['email_address']."','".$data['password']."')";

			$insert_query = $objUser->execute($insert_sql);

			$message['status']  = 'success';
			$message['message'] = 'User Registration Succefully';

			echo $this->twig->render('user/create.html.twig', $message);

		}

	}

}
