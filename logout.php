<?php
require_once __DIR__ . "/includes/common.php";
require_once __DIR__ . "/models/Posts.php";
require_once __DIR__ . '/Adminacess.php';
logout::do_logout();
class Logout{
	public  static $twig;

	 public function do_logout(){
	 	unset($_SESSION['user_email']);
	 //	header("location:login.php");
	 }


}


