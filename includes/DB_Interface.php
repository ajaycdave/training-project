<?php
interface DB_interface 
{
  public function selectAll($sql);
  public function selectOne($sql);
  public function execute($sql);
}
