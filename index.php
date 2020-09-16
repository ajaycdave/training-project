<?php
require_once __DIR__ ."/includes/common.php";
require_once __DIR__ ."/models/Posts.php";
require_once __DIR__ ."/models/Thread.php";
require_once __DIR__ ."/models/Category.php";
//require_once __DIR__ .'/auth_admin.php';
require_once __DIR__ .'/Adminacess.php';
Adminacess::create('Home', $twig);
class Home {

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
		$objCategory      = new Category();
		$data['category'] = $objCategory->selectAll('select * from category');

		echo $this->twig->render('thread/thread_all.html.twig', $data);
	}
	public function datalisting() {
		$columns = array(
			0=> 'title',
			1=> 'category_name',
			2=> 'action',
		);

		$limit       = $_REQUEST['length'];
		$start       = $_REQUEST['start'];
		$order       = $columns[$_REQUEST['order'][0]['column']];
		$dir         = $_REQUEST['order'][0]['dir'];
		$category_id = $_REQUEST['categoryID'];
		if (isset($_REQUEST['searchText']) && $_REQUEST['searchText'] != "") {
			$search = $_REQUEST['searchText'];
		} else {
			$search = $_REQUEST['search']['value'];
		}

		/*
		SELECT th.id,title,ca.name as category_name,ca.id as category_id,th.description,tp.description as post_message FROM threads as th
		join category as ca on ca.id=th.category_id
		LEFT JOIN thread_posts as tp on tp.thread_id=th.id
		where  1 and (title like '%New thread%' or th.description like '%New thread%' or tp.description like '%New thread%')
		GROUP by th.id
		 */

		$search_string   = '';
		$objThread       = new Thread();
		$select_query    = "SELECT th.id,title,ca.name as category_name,ca.id as category_id,th.description,tp.description as post_message  FROM threads as th join category as ca on ca.id=th.category_id LEFT JOIN thread_posts as tp on tp.thread_id=th.id  where 1";
		$group_by        = ' GROUP By th.id';
		$orderby         = "order by $order $dir";
		$base_query      = $select_query." $group_by";
		$postscollection = $objThread->selectAll($base_query);


		$totalData = count($postscollection);

		if (isset($category_id) && $category_id != "") {
			$search_string .= " and category_id ='".$category_id."'";
		}
		if (isset($search) && $search != "") {
			//$search_string .= " and title like '%".stripcslashes($search)."%'";
			$search_string .= " and (title like '%".stripcslashes($search)."%' or th.description like '%".stripcslashes($search)."%' or tp.description like '%".stripcslashes($search)."%')";
		}

		//LIMIT 20 OFFSET 20

		$select_query = $select_query." $search_string $group_by";

		$postscollection = $objThread->selectAll($select_query);
		$totalFiltered   = count($postscollection);
		$filter_query    = $select_query." $search_string  $orderby limit $limit OFFSET $start ";
		$postscollection = $objThread->selectAll($filter_query);
		$data            = array();
		foreach ($postscollection as $key => $item) {
			$row['id']            = $item['id'];
			$row['name']          = '<a href="threadpost.php?id='.$item['id'].'">'.$item['title'].'</a>';
			$action_array         = array();
			$row['category_name'] = $item['category_name'];
			$row['description']   = stripslashes($item['description']);

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
