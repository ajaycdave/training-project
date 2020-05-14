<?php
require_once __DIR__ ."/includes/common.php";
require_once __DIR__ ."/models/Thread.php";
require_once __DIR__ ."/models/Category.php";

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
		echo $this->twig->render('thread/thread_all.html.twig');
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
		$select_query  = "SELECT id,title  FROM threads where 1 ";
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

}
