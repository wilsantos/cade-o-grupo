<?php
class Estrutra{

	private $id;
	private $parent_id;
	private $name;
	private $csa;

	public function __construct(){
		$this->csa = array();
	}
	public function __set($atrib, $value){
        $this->$atrib = $value;
    }
  
    public function __get($atrib){
        return $this->$atrib;
    }

    public function setCSa($newCsa){
    	array_push($this->csa, $newCsa);
    }

}

?>