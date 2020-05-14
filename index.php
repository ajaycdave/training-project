<?php
require_once __DIR__ ."/includes/common.php";
require_once __DIR__ ."/models/Posts.php";
require_once __DIR__ .'/auth_admin.php';
require_once __DIR__ .'/Adminacess.php';
Adminacess::create('Home', $twig);
class Home {
	public static $twig;
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
		echo $this->twig->render('posts/index.html.twig');

	}
	public function datalisting() {
		$columns = array(
			0=> 'id',
			1=> 'name',
			2=> 'product_type ',
			3=> 'product_code',
			4=> 'hs_code',
			5=> 'is_active',
			6=> 'action',
		);

		$limit        = $_REQUEST['length'];
		$start        = $_REQUEST['start'];
		$order        = $columns[$_REQUEST['order'][0]['column']];
		$dir          = $_REQUEST['order'][0]['dir'];
		$search       = $_REQUEST['search.value'];
		$objPosts     = new Posts();
		$select_query = "SELECT id,name,product_type,product_code,hs_code, 	is_active  FROM products";
		$orderby      = "order by $order $dir";

		$postscollection = $objPosts->selectAll($select_query);

		$totalData = count($postscollection);

		//LIMIT 20 OFFSET 20
		$postscollection = $objPosts->selectAll($select_query);
		$totalFiltered   = count($postscollection);
		$filter_query    = $select_query." $orderby limit $limit OFFSET $start ";
		$postscollection = $objPosts->selectAll($filter_query);
		$data            = array();
		foreach ($postscollection as $key => $item) {
			$row['id']           = $item['id'];
			$row['name']         = $item['name'];
			$row['product_type'] = $item['product_type'];
			$row['product_code'] = $item['product_code'];
			$row['hs_code']      = $item['hs_code'];
			$row['status']       = $item['is_active'];
			$row['action']       = '';
			$data[]              = $row;
		}
		$json_data = array(
			"draw"            => intval($_REQUEST['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data,
		);
		echo json_encode($json_data);
	}
	public function add() {

		$objPosts = new Posts();
		$posts    = $objPosts->selectAll("SELECT * FROM products ORDER BY  id DESC LIMIT 10");
		echo $this->twig->render('posts/create.html.twig', array('posts' => $posts));

	}
	public function edit() {

		$objPosts = new Posts();
		$posts    = $objPosts->selectAll("SELECT * FROM products ORDER BY  id DESC LIMIT 10");
		echo $this->twig->render('posts/create.html.twig', array('posts' => $posts));

	}
	public function delete() {

	}

}
