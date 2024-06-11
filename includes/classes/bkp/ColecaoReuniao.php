<?php
class ColecaoReuniao{

	private $Reuniao;
	private $Reunioes = array();

	public function hasReuniao($meeting_name,$location_neighborhood,$location_municipality,$start_time,$weekday_tinyint,$formats,$location_street,$location_sub_province,$location_province,$location_postal_code_1,$location_nation,$location_text,$longitude,$latitude,$duration_time,$service_body_bigint){

		$flagReuniao = false;
		//Varre o array de Reunioes a procura da reunião
		foreach($this->Reunioes as $indice=>$reuniao){
			if($reuniao->meeting_name == $meeting_name && $reuniao->location_neighborhood == $location_neighborhood && $reuniao->location_municipality == $location_municipality){
				$flagReuniao = true;

				$reuniao->setSemana($weekday_tinyint,$start_time,$formats); //Tendo a reunião só insere mais um dia na semana.
				$reuniao->setDuracao($duration_time); //Para calcular a duração das horas por grupo
				
			}
		}

		//Se após varrer o Array não achou a reunião, insira
		if($flagReuniao == false){
			$reuniao = new Reuniao();
			$reuniao->meeting_name = $meeting_name;
			$reuniao->location_neighborhood = $location_neighborhood;
			$reuniao->location_municipality = $location_municipality;
			$reuniao->location_street = $location_street;
			$reuniao->location_sub_province = $location_sub_province;
			$reuniao->location_province = $location_province;
			$reuniao->location_postal_code_1 = $location_postal_code_1;
			$reuniao->location_nation = $location_nation;
			$reuniao->location_text = $location_text;
			$reuniao->longitude = $longitude;
			$reuniao->latitude = $latitude;
			$reuniao->service_body_bigint = $service_body_bigint;
			
	
			//Insere o dia da semana
			$reuniao->setSemana($weekday_tinyint,$start_time,$formats);
			$reuniao->setDuracao($duration_time);
			array_push($this->Reunioes, $reuniao);
			
		}
	}


	public function __set($atrib, $value){
        $this->$atrib = $value;
    }
  
    public function __get($atrib){
        return $this->$atrib;
    }

}

?>