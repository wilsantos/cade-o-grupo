<?php
class ColecaoReuniaoCog{

	private $Reuniao;
	private $Reunioes = array();
	


	public function hasReuniao($meeting_name,$location_neighborhood,$location_municipality,$start_time,$weekday_tinyint,$formats,$location_street,$location_sub_province,$location_province,$location_postal_code_1,$location_nation,$location_text,$longitude,$latitude, $duration_time, $virtual_meeting_link,$virtual_meeting_additional_info,$location_info,$periodo){

		$flagReuniao = false;
		//Varre o array de Reunioes a procura da reunião
		foreach($this->Reunioes as $indice=>$reuniao){
			if($reuniao->meeting_name == $meeting_name && $reuniao->location_neighborhood == $location_neighborhood && $reuniao->location_municipality == $location_municipality && $reuniao->location_street == $location_street){
				$flagReuniao = true;

				//Verificar informações adicionais de uma reunião unica
				if(!in_array($location_info,$reuniao->location_infoGrupo)){
					array_push($reuniao->location_infoGrupo, $location_info);
				}
				if($periodo == "all"){
					$reuniao->setSemana($weekday_tinyint,$start_time,$duration_time,$formats,$virtual_meeting_link,$virtual_meeting_additional_info,$location_info); //Tendo a reunião só insere mais um dia na semana.
				}else{
					
					$hora = substr($start_time, 0,2);
					if($this->verificaPeriodo($periodo,$hora)){
						$reuniao->setSemana($weekday_tinyint,$start_time,$duration_time,$formats,$virtual_meeting_link,$virtual_meeting_additional_info,$location_info); //Tendo a reunião só insere mais um dia na semana.
					}
				}
				
			}
		}

		//Se após varrer o Array não achou a reunião, insira
		if($flagReuniao == false){
			$reuniao = new ReuniaoCog();
			$reuniao->meeting_name = $meeting_name;
			$reuniao->location_neighborhood = $location_neighborhood;
			$reuniao->location_municipality = $location_municipality;
			$reuniao->location_street = $location_street;
			$reuniao->location_sub_province = $location_sub_province;
			$reuniao->location_province = $location_province;
			$reuniao->location_postal_code_1 = $location_postal_code_1;
			$reuniao->location_nation = $location_nation;
			$reuniao->location_text = $location_text;
			$reuniao->location_info = $location_info;
			$reuniao->longitude = $longitude;
			$reuniao->latitude = $latitude;

			//Verificar informações adicionais de uma reunião unica
				if(!in_array($location_info,$reuniao->location_infoGrupo)){
					array_push($reuniao->location_infoGrupo, $location_info);
				}
			
			if($periodo == "all"){
				//Insere o dia da semana
				$reuniao->setSemana($weekday_tinyint,$start_time,$duration_time,$formats,$virtual_meeting_link,$virtual_meeting_additional_info,$location_info);
				array_push($this->Reunioes, $reuniao);
			}else{
				$hora = substr($start_time, 0,2);

					if($this->verificaPeriodo($periodo,$hora)){
						//Insere o dia da semana
						$reuniao->setSemana($weekday_tinyint,$start_time,$duration_time,$formats,$virtual_meeting_link,$virtual_meeting_additional_info,$location_info);
						array_push($this->Reunioes, $reuniao);
					}
			}
		}
	}


	public function __set($atrib, $value){
        $this->$atrib = $value;
    }
  
    public function __get($atrib){
        return $this->$atrib;
    }

    public function verificaPeriodo($vperiodo,$vhora){

		$periodo["06"] = "manha";
    	$periodo["07"] = "manha";
    	$periodo["08"] = "manha";
    	$periodo["09"] = "manha";
    	$periodo[10] = "manha";
    	$periodo[11] = "manha";

    	$periodo[12] = "tarde";
    	$periodo[13] = "tarde";
    	$periodo[14] = "tarde";
    	$periodo[15] = "tarde";
    	$periodo[16] = "tarde";
    	$periodo[17] = "tarde";
    	
		$periodo[18] = "noite";
		$periodo[19] = "noite";
		$periodo[20] = "noite";
		$periodo[21] = "noite";

		$periodo[22] = "corujao";
		$periodo[23] = "corujao";
		$periodo["00"] = "corujao";
		$periodo["01"] = "corujao";
		$periodo["02"] = "corujao";
		$periodo["03"] = "corujao";
		$periodo["04"] = "corujao";
		$periodo["05"] = "corujao";
		

		if($periodo[$vhora] == $vperiodo){
			return true;
		}else{
			return false;
		}


    }

}

?>