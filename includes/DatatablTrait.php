<?php

trait DatatablTrait {

	public function action($list_item, $twig) {
		$data = array();
		foreach ($list_item as $list_item_val) {
			$data['list_item'][] = $list_item_val;
		}
		return $twig->render('action.html.twig', $data);

	}

}