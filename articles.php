<?php
require_once __DIR__ ."/includes/common.php";
require_once __DIR__ ."/models/Article.php";
require_once __DIR__ .'/auth_admin.php';
require_once __DIR__ .'/Adminacess.php';
Adminacess::create('Articlespage', $twig);

class Articlespage {

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
		echo $this->twig->render('article/index.html.twig');
	}
	public function datalisting() {
		$columns = array(
			0=> 'id',
			1=> 'title',
			2=> 'is_active',
			3=> 'action',
		);

		$limit         = $_REQUEST['length'];
		$start         = $_REQUEST['start'];
		$order         = $columns[$_REQUEST['order'][0]['column']];
		$dir           = $_REQUEST['order'][0]['dir'];
		$search        = $_REQUEST['search']['value'];
		$search_string = '';
		$objCategory   = new Article();
		$select_query  = "SELECT id,title,is_active  FROM articles where 1";
		$orderby       = "order by $order $dir";

		$postscollection = $objCategory->selectAll($select_query);

		$totalData = count($postscollection);

		if (isset($search) && $search != "") {
			$search_string = " and title like '%".stripcslashes($search)."%'";
		}
		//LIMIT 20 OFFSET 20

		$select_query    = $select_query." $search_string";
		$postscollection = $objCategory->selectAll($select_query);
		$totalFiltered   = count($postscollection);
		$filter_query    = $select_query." $search_string $orderby limit $limit OFFSET $start ";
		$postscollection = $objCategory->selectAll($filter_query);
		$data            = array();
		foreach ($postscollection as $key => $item) {
			$row['id']    = $item['id'];
			$row['name']  = $item['title'];
			$action_array = array();
			if ($item['is_active'] == 'Yes') {
				$row['status'] = 'Active';
			} else {

				$row['status'] = 'InActive';
			}
			$action_array[] = array(
				'text'       => 'Edit',
				'action'     => "articles.php?action=edit&id=".$item['id']."",
				'id'         => $item['id'],
				'class'      => '',
				'permission' => true,
				'icon'       => 'flaticon2-contract',
			);
			$action_array[] = array(
				'text'       => 'Delete',
				'action'     => "articles.php?action=delete&id=".$item['id']."",
				'id'         => $item['id'],
				'class'      => 'delete-confirm',
				'permission' => true,
				'icon'       => 'flaticon2-trash',
			);

			$row['action'] = $objCategory->action($action_array, $this->twig);

			$data[] = $row;
		}
		$json_data = array(
			"draw"            => intval($_REQUEST['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data,
		);
		echo json_encode($json_data);
	}
	public function store() {

		$objArticle = new Article();
		$title      = strip_tags(trim($_POST['title']));
		$status     = strip_tags(trim($_POST['is_active']));
		$insert_sql = "insert into articles(title,is_active) values('".$title."','".$status."')";

		$objArticle->execute($insert_sql);
		$message['status']  = 'success';
		$message['message'] = 'Article added Succefully';

		echo $this->twig->render('article/index.html.twig', $message);
	}
	public function add() {
		echo $this->twig->render('article/create.html.twig');
	}
	public function edit() {
		$data       = array();
		$id         = $_REQUEST['id'];
		$objArticle = new Article();
		$article    = $objArticle->selectOne("SELECT * FROM articles where id=$id");

		$data['article'] = $article;

		echo $this->twig->render('article/edit.html.twig', $data);

	}
	public function update() {
		$objArticle = new Article();
		$id         = $_REQUEST['id'];
		$title      = strip_tags(trim($_POST['title']));
		$status     = strip_tags(trim($_POST['is_active']));
		$update_sql = "update articles set title='".$title."',is_active='".$status."' where id=$id";
		$objArticle->execute($update_sql);

		$message['status']  = 'success';
		$message['message'] = 'Article update Succefully';

		echo $this->twig->render('article/index.html.twig', $message);

	}
	public function delete() {
		$objArticle    = new Article();
		$id            = $_REQUEST['id'];
		$delete_record = "delete from articles where id='".$id."'";
		$objArticle->execute($delete_record);

		$json_data = array('success' => true, 'message' => 'Article  deleted successfully.');
		echo json_encode($json_data, 200);
	}

}
