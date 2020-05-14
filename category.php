<?php

require_once __DIR__ ."/includes/common.php";

require_once __DIR__ ."/models/Category.php";

require_once __DIR__ .'/auth_admin.php';
require_once __DIR__ .'/Adminacess.php';

Adminacess::create('Categorypage', $twig);

class Categorypage {

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
		//$objCategory = new Category();
		//	$category->action(array(), $this->twig);

		echo $this->twig->render('category/index.html.twig');

	}
	public function datalisting() {
		$columns = array(
			0=> 'id',
			1=> 'name',
			2=> 'is_active',
			3=> 'action',
		);

		$limit         = $_REQUEST['length'];
		$start         = $_REQUEST['start'];
		$order         = $columns[$_REQUEST['order'][0]['column']];
		$dir           = $_REQUEST['order'][0]['dir'];
		$search        = $_REQUEST['search']['value'];
		$search_string = '';
		$objCategory   = new Category();
		$select_query  = "SELECT id,name,is_active  FROM category where 1";
		$orderby       = "order by $order $dir";

		$postscollection = $objCategory->selectAll($select_query);

		$totalData = count($postscollection);

		if (isset($search) && $search != "") {
			$search_string = " and name like '%".stripcslashes($search)."%'";
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
			$row['name']  = $item['name'];
			$action_array = array();
			if ($item['is_active'] == 'Yes') {
				$row['status'] = 'Active';
			} else {

				$row['status'] = 'InActive';
			}
			$action_array[] = array(
				'text'       => 'Edit',
				'action'     => "category.php?action=edit&id=".$item['id']."",
				'id'         => $item['id'],
				'class'      => '',
				'permission' => true,
				'icon'       => 'flaticon2-contract',
			);
			$action_array[] = array(
				'text'       => 'Delete',
				'action'     => "category.php?action=delete&id=".$item['id']."",
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
		$objCategory = new Category();

		$name       = strip_tags(trim($_REQUEST['name']));
		$status     = strip_tags(trim($_REQUEST['is_active']));
		$insert_sql = "insert into category(name,is_active,parent_id) values('".$name."','".$status."',0)";

		$insert_query = $objCategory->execute($insert_sql);

		$message['status']  = 'success';
		$message['message'] = 'Category added Succefully';

		echo $this->twig->render('category/index.html.twig', $message);
	}
	public function add() {
	}
	public function edit() {
		$id          = $_REQUEST['id'];
		$objCategory = new Category();
		$category    = $objCategory->selectOne("SELECT * FROM category where id=$id");

		echo $this->twig->render('category/edit.html.twig', array('category' => $category));

	}
	public function update() {
		$objCategory = new Category();
		$id          = $_REQUEST['id'];
		$name        = strip_tags(trim($_REQUEST['name']));
		$status      = strip_tags(trim($_REQUEST['is_active']));
		$update_sql  = "update category set name='".$name."',is_active='".$status."' where id=$id";
		$objCategory->execute($update_sql);

		$message['status']  = 'success';
		$message['message'] = 'Category update Succefully';

		echo $this->twig->render('category/index.html.twig', $message);

	}
	public function delete() {
		$objCategory   = new Category();
		$id            = $_REQUEST['id'];
		$delete_record = "delete from category where id='".$id."'";
		$objCategory->execute($delete_record);

		$json_data = array('success' => true, 'message' => 'Category  deleted successfully.');
		echo json_encode($json_data, 200);
	}

}
