<?php
require_once __DIR__ ."/includes/common.php";
require_once __DIR__ ."/models/Thread.php";
require_once __DIR__ ."/models/Threadpost.php";
require_once __DIR__ ."/models/Category.php";
require_once __DIR__ ."/models/Sendmail.php";

//require_once __DIR__ .'/auth_admin.php';
require_once __DIR__ .'/Adminacess.php';
Adminacess::create('Threadpostpage', $twig);

class Threadpostpage {

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

		$objThread    = new Thread();
		$objThredpost = new Threadpost();

		$thred_id       = $_GET['id'];
		$select_thread  = "select * from threads where id='".$thred_id."' ";
		$data['thread'] = $objThread->selectOne($select_thread);

		echo $this->twig->render('thread_post/index.html.twig', $data);
	}
	public function datalisting() {
		$columns = array(
			0=> 'id',
			1=> 'description',
			2=> 'action',
		);
		$id            = $_REQUEST['id'];
		$limit         = $_REQUEST['length'];
		$start         = $_REQUEST['start'];
		$order         = $columns[$_REQUEST['order'][0]['column']];
		$dir           = $_REQUEST['order'][0]['dir'];
		$search        = $_REQUEST['search']['value'];
		$search_string = '';
		$objThreadpost = new Threadpost();
		$select_query  = "SELECT id,description  FROM thread_posts where thread_id='".$id."' ";

		$orderby = "order by $order $dir";

		$postscollection = $objThreadpost->selectAll($select_query);

		$totalData = count($postscollection);
		if (isset($search) && $search != "") {
			$search_string = " and description like '%".stripcslashes($search)."%'";
		}
		//LIMIT 20 OFFSET 20

		$select_query    = $select_query." $search_string";
		$postscollection = $objThreadpost->selectAll($select_query);
		$totalFiltered   = count($postscollection);
		$filter_query    = $select_query." $search_string $orderby limit $limit OFFSET $start ";
		$postscollection = $objThreadpost->selectAll($filter_query);
		$data            = array();
		foreach ($postscollection as $key => $item) {

			$row['id']          = $item['id'];
			$row['description'] = $item['description'];
			$action_array       = array();
			$row['action']      = $objThreadpost->action($action_array, $this->twig);

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

		$objThreadpost = new Threadpost();
		$objThread     = new Thread();
		$user_id       = $_SESSION["user_id"];
		$id            = $_POST['id'];
		$description   = addslashes(trim($_POST['description']));
		$insert_sql    = "insert into thread_posts(thread_id,user_id,description) values('".$id."','".$user_id."','".$description."')";

		$objThreadpost->execute($insert_sql);

		$select_thread = "select * from threads as th
							inner join users as u on u.id=th.user_id where th.id='".$id."'";
		$get_thread_detail     = $objThread->selectOne($select_thread);
		$data['subject']       = 'New Thread Replay';
		$data['email_address'] = $get_thread_detail['email_address'];
		$content               = '<h5>'.$get_thread_detail['title'].'</h5>';
		$content .= '<label>Replay Description:'.$description.'</lable>';
		$data['content'] = $content;
		$mailsend        = new Sendmail($data);
		$mailsend->sendMail($data);

		$message['status']  = 'success';
		$message['message'] = 'Thread post added Succefully';
		header("Location:threadpost.php?id=".$id);
		//echo $this->twig->render('thread_post/index.html.twig', $message);
	}
	public function add() {
		$objThread      = new Thread;
		$data           = array();
		$thred_id       = $_GET['id'];
		$select_thread  = "select * from threads where id='".$thred_id."' ";
		$data['thread'] = $objThread->selectOne($select_thread);

		echo $this->twig->render('thread_post/create.html.twig', $data);
	}

}
