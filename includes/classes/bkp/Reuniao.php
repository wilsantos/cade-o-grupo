<?php
class Reuniao{

	private $meeting_name;
	private $location_street;
	private $location_neighborhood;
	private $location_municipality;
	private $location_sub_province;
	private $location_province;
	private $location_postal_code_1;
	private $location_nation;
	private $location_text;
	private $longitude;
	private $latitude;
	public $acessibilidade;
	public $duration_time;
	private $service_body_bigint;
	
	private $semana = array(1=>'',2=>'',3=>'',4=>'',5=>'',6=>'',7=>'');

	function __construct() {
	    $this->duration_time = 0;
	}

	public function setSemana($diaSemana, $horario, $formato){
		if(strstr($formato,"Cad"))
			$this->acessibilidade = true;
		
		$aux = explode(",", $formato);

		$this->semana[$diaSemana] .= substr($horario, 0,5)  ." (".$aux[0] . ")". "<br>";
	}

	public function setDuracao($duration_time){
		$this->duration_time += $duration_time;
	}

	public function __set($atrib, $value){
        $this->$atrib = $value;
    }
  
    public function __get($atrib){
        return $this->$atrib;
    }

}

?>