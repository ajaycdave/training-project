<?php

class Adminacess {

	public function create($object_name, $twig) {

		//$this->objname = new $object_name($twig);
		//return $this->objname;
		return new $object_name($twig);
	}
		

}
