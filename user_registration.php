<?php

require_once __DIR__ ."/includes/common.php";
require_once __DIR__ ."/models/Users.php";
require_once __DIR__ .'/Adminacess.php';
require_once __DIR__ ."/models/Sendmail.php";

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

			$data['subject']       = 'Forgot Pasword';
			$data['email_address'] = $data['email_address'];
			$content               = '<div><label>User:'.$data['email_address'].'</lable></div>';
			$content .= '<div><label>New Password:'.$new_password.'</lable></div>';
			$data['content'] = $content;
			$mailsend        = new Sendmail($data);
			$mailsend->sendMail($data);

			echo $this->twig->render('user/forgotpassword.html.twig', $message);

		} else {

			$data['message'] = 'Invalid Email Address';
			$data['status']  = 'Error';
			echo $this->twig->render('user/forgotpassword.html.twig', $data);

		}
	}
	public function user_activation() {
		$data          = array();
		$id            = $_REQUEST['id'];
		$objUser       = new Users();
		$activate_user = "update users set is_active= 'Yes' where id='".$id."'";
		$objUser->execute($activate_user);
		$select_user = "select * from users where id='".$id."'";
		$sel_user    = $objUser->selectOne($select_user);

		$data['user'] = $sel_user;
		echo $this->twig->render('user/user_activate.html.twig', $data);

	}

	public function store() {
		$objUser = new Users();
		$data    = array();

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
			$insert_id    = $objUser->insert_id();

			$mailsend              = new Sendmail();
			$data['subject']       = 'New Registration';
			$data['email_address'] = $data['email_address'];

			$content = '<h1>User Registration Page</h1>';
			$content .= '<div>User Registration Succefully.</div>';
			$verify_url = HOST_NAME.'/user_registration.php?action=user_activation&id='.$insert_id;
			$content .= '<div>Click here :<a href="'.$verify_url.'">Activation  url</a></div>';

			$data['content'] = $content;
			$mailsend        = new Sendmail();

			$mailsend->sendMail($data);

			$message['status']  = 'success';
			$message['message'] = 'User Registration Succefully';

			echo $this->twig->render('user/create.html.twig', $message);

		}

	}

}
