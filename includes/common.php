<?php
// session start
session_start();

// include config file
require_once __DIR__ .'/config.php';
require_once __DIR__ ."/DatatablTrait.php";
// include DB class
require_once __DIR__ .'/database.php';



// $db = new database();

// include Twig class

require_once __DIR__ .'/../vendor/autoload.php';
require_once __DIR__ .'/training_twig_extension.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ .'/../views');
$twig   = new \Twig\Environment($loader);
$twig->addExtension(new Training_Twig_Extension());

// include any other common classes as needed
