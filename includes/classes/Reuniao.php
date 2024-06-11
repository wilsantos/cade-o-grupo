<?php
class ReuniaoCog{

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
	public $virtual_meeting_link;
	public $virtual_meeting_additional_info;
	public $location_info;
	public $location_infoGrupo = array();
	
	private $semana = array(1=>'',2=>'',3=>'',4=>'',5=>'',6=>'',7=>'');


	public function setSemana($diaSemana, $horario, $duration_time, $formato, $virtual_meeting_link, $virtual_meeting_additional_info,$location_info){
		
		$aux = explode(",", $formato);
		$txtFormato = "";
		foreach ($aux as $key => $value) {
			if($value == "A")
				$txtFormato .= " Aberta para visitantes,";			
			if($value == "CadP")
				$txtFormato .= " Cadeirante Parcial,";
			if($value == "CadT")
				$txtFormato .= " Cadeirante Total,";
			if($value == "CAR")
				$txtFormato .= " Carimbo Beneficiário da Justiça,";
			if($value == "EP")
				$txtFormato .= " Estudo de Passos,";
			if($value == "Est")
				$txtFormato .= " Estudos,";
			if($value == "LGBTQIAPN+")
				$txtFormato .= " LGBTQIAPN+,";
			if($value == "LV")
				$txtFormato .= " Luz de velas,";
			if($value == "IF")
				$txtFormato .= " Interesse feminino,";
			if($value == "AmAp")
				$txtFormato .= " Amadrinhamento/Apadrinhamento,";
			if($value == "VM")
				$txtFormato .= " Reunião Virtual,";
			if($value == "AtAg")
				$txtFormato .= " Ateus e Agnósticos,";
			if($value == "BL")
				$txtFormato .= " Bilíngue,";
			if($value == "Con")
				$txtFormato .= " Conceitos,";
			if($value == "EC")
				$txtFormato .= " Estudo de Conceitos,";
			if($value == "EL")
				$txtFormato .= " Estudo de Literatura,";
			if($value == "ELA")
				$txtFormato .= " Estudo do livro Apadrinhamento,";
			if($value == "ENG")
				$txtFormato .= " Inglês - Reunião em língua inglesa,";
			if($value == "ET")
				$txtFormato .= " Estudo de Tradições,";
			if($value == "ETB")
				$txtFormato .= " Estudo do Texto Básico,";
			if($value == "EVL")
				$txtFormato .= " Estudo do livro Viver Limpo,";
			if($value == "FeF")
				$txtFormato .= " Fechada em Feriados,";
			if($value == "FuF")
				$txtFormato .= " Funciona em Feriados,";
			if($value == "FUN")
				$txtFormato .= " Estudo do livro Funciona - Como e Por quê,";
			if($value == "GP")
				$txtFormato .= " Estudo do livro Guia de Princípios,";
			if($value == "GPa")
				$txtFormato .= " Trabalho de Passos através do guia,";
			if($value == "HY")
				$txtFormato .= " Hibrida (virtual e presencial),";
			if($value == "Jv")
				$txtFormato .= " Jovens,";
			if($value == "ME")
				$txtFormato .= " Prática de meditação silenciosa,";
			if($value == "Mo")
				$txtFormato .= " Morcegão (madrugada),";
			if($value == "TM")
				$txtFormato .= " Temática,";
			if($value == "Sent")
				$txtFormato .= " Partilha de sentimentos,";
			if($value == "EGP")
				$txtFormato .= " Estudo do guia de passos,";
			if($value == "NfF")
				$txtFormato .= " Não funciona em feriados,";
			if($value == "Sx")
				$txtFormato .= " Sexualidade,";
			if($value == "SUB-RP")
				$txtFormato .= " Subcomitê RP,";
			if($value == "SUB-U&S")
				$txtFormato .= " Subcomitê Sistema Guarda-chuva Unidade & Serviço";
			if($value == "SUB-IP")
				$txtFormato .= " Subcomitê IP,";
			if($value == "SUB-LDA")
				$txtFormato .= " Subcomitê LDA,";
			if($value == "SUB-LA")
				$txtFormato .= " Subcomitê Longo Alcance,";
			if($value == "SUB-HI" or $value == "SUB-H&I")
				$txtFormato .= " Subcomitê H&I,";
			if($value == "INST")
				$txtFormato .= " Grupos Institucionais,";
			if($value == "SUB-EV")
				$txtFormato .= " Subcomitê de Eventos,";
			if($value == "EPO")
				$txtFormato .= " Estudo dos Princípios Orientadores,";


			
			

		}
		/*if($location_info != "") //Exibir os detalhes da reuniao em cada linha de reuniao
			$txtFormato .= $location_info.",";*/

		$txtFormato = substr($txtFormato, 0,strlen($txtFormato)-1);
		
		//$this->semana[$diaSemana] .= substr($horario, 0,5) ." às ". substr(somaHoraCog($horario,$duration_time), 0,5) ." (". $txtFormato. ")". "|". $virtual_meeting_link. "|".$virtual_meeting_additional_info ."<br>";
		if($virtual_meeting_link == ""){
			$this->semana[$diaSemana] .= substr($horario, 0,5) ." às ". substr($this->somaHoraCog($horario,$duration_time), 0,5);
			if($txtFormato != ""){
				$this->semana[$diaSemana] .= " (". substr($txtFormato,1). ")";
			}
			
			$this->semana[$diaSemana] .= "<br>";
		}else{

			$img = "";
			if(strstr($virtual_meeting_link,"ello")){
				$img = '<img src="'.plugin_dir_url(__FILE__) . 'img/logo-zello.svg'.'" align="absmiddle" title="Aplicativo Zello" border="0"/>';
				//$img = "Aplicativo Zello: ".$virtual_meeting_link . " ";
			}

			if(strstr($virtual_meeting_link,"zoom")){
				$img = '<img src="'.plugin_dir_url(__FILE__) . 'img/zoomus.svg'.'" align="absmiddle" title="Aplicativo Zoom" border="0"/>';
				//$img = "Aplicativo Zoom: ".$virtual_meeting_link . " ";
				
			}
			
			$this->semana[$diaSemana] .= '<a href="'.$virtual_meeting_link.'" target="_blank">'.substr($horario, 0,5) ." às ". substr($this->somaHoraCog($horario,$duration_time), 0,5) ." (". $txtFormato. ")".'&nbsp;'.$img.'</a><br>'.$virtual_meeting_additional_info.'<br>';
			//$this->semana[$diaSemana] .= substr($horario, 0,5) ." às ". substr($this->somaHoraCog($horario,$duration_time), 0,5) ." (". $txtFormato. ")".'&nbsp;'.$img.'<br>'.$virtual_meeting_additional_info.'<br>';
		}
	}

	public function somaHoraCog($hora1,$hora2){
 
	 	$h1 = explode(":",$hora1);
	 	$h2 = explode(":",$hora2);
	 	
	 	$segundo = $h1[2] + $h2[2] ;
	 	$minuto  = $h1[1] + $h2[1] ;
	 	$horas   = $h1[0] + $h2[0] ;
	 	$dia   	= 0 ;
	 	
	 	if($segundo > 59){
	 	
	 		$segundodif = $segundo - 60;
	 		$segundo = $segundodif;
	 		$minuto = $minuto + 1;
	 	}
	 	
	 	if($minuto > 59){
	 		
	 		$minutodif = $minuto - 60;
	 		$minuto = $minutodif;
	 		$horas = $horas + 1;
	 	}
	 	
	 
			
		if(strlen($horas) == 1){
		
			$horas = "0".$horas;
		}
		
		if(strlen($minuto) == 1){
		
			$minuto = "0".$minuto;
		}
		
		if(strlen($segundo) == 1){
		
			$segundo = "0".$segundo;
	 	}
	 	
	 	switch ($horas) {
		    case "24":
		       	$horas = "00";
		        break;
		    case "25":
		        $horas = "01";
		        break;
		    case "26":
		        $horas = "02";
		        break;
		    case "27":
		        $horas = "03";
		        break;

		    case "28":
		        $horas = "04";
		        break;
		    case "29":
		        $horas = "05";
		        break;
		    case "30":
		        $horas = "06";
		        break;
		    case "31":
		        $horas = "07";
		        break;

		}
	 	return  $horas.":".$minuto.":".$segundo;
 
	}
	public function __set($atrib, $value){
        $this->$atrib = $value;
    }
  
    public function __get($atrib){
        return $this->$atrib;
    }

}

?>