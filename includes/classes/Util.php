<?php 
function somaHoraCog($hora1,$hora2){
 
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
 	
 	return  $horas.":".$minuto.":".$segundo;
 
}

?>