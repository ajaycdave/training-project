<?php
require_once __DIR__ ."/includes/common.php";
require_once __DIR__ ."/models/Thread.php";
require_once __DIR__ ."/models/Category.php";

require_once __DIR__ .'/auth_admin.php';
require_once __DIR__ .'/Adminacess.php';
Adminacess::create('Threadpage', $twig);

class Threadpage {

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
		echo $this->twig->render('thread/index.html.twig');
	}
	public function datalisting() {
		$columns = array(
			0=> 'id',
			1=> 'title',
			2=> 'action',
		);

		$limit         = $_REQUEST['length'];
		$start         = $_REQUEST['start'];
		$order         = $columns[$_REQUEST['order'][0]['column']];
		$dir           = $_REQUEST['order'][0]['dir'];
		$search        = $_REQUEST['search']['value'];
		$search_string = '';
		$objThread     = new Thread();
		$select_query  = "SELECT id,title  FROM threads where user_id='".$_SESSION["user_id"]."'  ";
		$orderby       = "order by $order $dir";

		$postscollection = $objThread->selectAll($select_query);

		$totalData = count($postscollection);

		if (isset($search) && $search != "") {
			$search_string = " and title like '%".stripcslashes($search)."%'";
		}
		//LIMIT 20 OFFSET 20

		$select_query    = $select_query." $search_string";
		$postscollection = $objThread->selectAll($select_query);
		$totalFiltered   = count($postscollection);
		$filter_query    = $select_query." $search_string $orderby limit $limit OFFSET $start ";
		$postscollection = $objThread->selectAll($filter_query);
		$data            = array();
		foreach ($postscollection as $key => $item) {
			$row['id']    = $item['id'];
			$row['name']  = '<a href="threadpost.php?id='.$item['id'].'">'.$item['title'].'</a>';
			$action_array = array();

			$action_array[] = array(
				'text'       => 'Edit',
				'action'     => "thread.php?action=edit&id=".$item['id']."",
				'id'         => $item['id'],
				'class'      => '',
				'permission' => true,
				'icon'       => 'flaticon2-contract',
			);
			$action_array[] = array(
				'text'       => 'Delete',
				'action'     => "thread.php?action=delete&id=".$item['id']."",
				'id'         => $item['id'],
				'class'      => 'delete-confirm',
				'permission' => true,
				'icon'       => 'flaticon2-trash',
			);

			$row['action'] = $objThread->action($action_array, $this->twig);

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

		$objThread   = new Thread();
		$title       = strip_tags(trim($_POST['title']));
		$category_id = strip_tags(trim($_POST['category_id']));
		$user_id     = $_SESSION["user_id"];
		$description = strip_tags(trim($_POST['description']));
		$insert_sql  = "insert into threads(title,category_id,user_id,description ) values('".$title."','".$category_id."','".$user_id."','".$description."')";

		$objThread->execute($insert_sql);
		$message['status']  = 'success';
		$message['message'] = 'Thread added Succefully';

		echo $this->twig->render('thread/index.html.twig', $message);
	}
	public function add() {
		$data             = array();
		$objCategory      = new Category();
		$data['category'] = $objCategory->selectAll('select * from category');

		echo $this->twig->render('thread/create.html.twig', $data);
	}
	public function edit() {
		$data             = array();
		$id               = $_REQUEST['id'];
		$objThread        = new Thread();
		$thread           = $objThread->selectOne("SELECT * FROM threads where id=$id");
		$objCategory      = new Category();
		$data['category'] = $objCategory->selectAll('select * from category');

		$data['thread'] = $thread;

		echo $this->twig->render('thread/edit.html.twig', $data);

	}
	public function update() {
		$objThread   = new Thread();
		$id          = $_REQUEST['id'];
		$title       = strip_tags(trim($_POST['title']));
		$category_id = strip_tags(trim($_POST['category_id']));
		$user_id     = $_SESSION["user_id"];
		$description = strip_tags(trim($_POST['description']));

		$update_sql = "update threads set title='".$title."',category_id='".$category_id."',description='".$description."' where id=$id";
		$objThread->execute($update_sql);

		$message['status']  = 'success';
		$message['message'] = 'Thread update Succefully';

		echo $this->twig->render('thread/index.html.twig', $message);

	}
	public function delete() {
		$objThread     = new Thread();
		$id            = $_REQUEST['id'];
		$delete_record = "delete from threads where id='".$id."'";
		$objThread->execute($delete_record);

		$json_data = array('success' => true, 'message' => 'Thread  deleted successfully.');
		echo json_encode($json_data, 200);
	}

}
