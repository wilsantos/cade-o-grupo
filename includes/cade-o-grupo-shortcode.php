<?php
require_once("classes/Reuniao.php");
require_once("classes/ColecaoReuniao.php");
require_once("classes/Estrutura.php");
require_once("classes/Util.php");

add_shortcode('cade-o-grupo?', 'cade_o_grupo_run');

function cade_o_grupo_run($att){

 ob_start();
 
 $dispFiltLocal = "";
 if($att['formato'] == "virtual")
	 $dispFiltLocal = "display:none;";
 
 ?>
 <div class="parent">
 	<input type="hidden" id="tpBusca" name="tpBusca" value="estado">

<div class="div1">
<table width="100%" border="0" style="background: #03457e;color: #FFF;">
	<tr><td colspan="2"><div class="div2" style="color: #FFF;">BUSCA POR REUNIÕES</div></td></tr>
	<tr style="<?php echo $dispFiltLocal ?>" id="trelemEstado">
		<td width="15%" align="left" style="background: #03457e;color: #FFF;">
<span id="elemEstado"><input type="search" id="estado" name="estado" list="state_list" placeholder="Digite o estado" style="width: 250px;background: #fff;color: #000;font-size: 15px;" /><datalist id="state_list" style="height:5.1em;overflow:hidden"><option>Buscar por geolocalização</option><option value="Acre">Acre</option><option value="Alagoas">Alagoas</option><option value="Amapá">Amapa</option><option value="Amazonas">Amazonas</option><option value="Bahia">Bahia</option><option value="Ceará">Ceara</option><option value="Distrito Federal">Distrito Federal</option><option value="Espírito Santo">Espirito Santo</option><option value="Goiás">Goias</option><option value="MS">MS</option><option value="Maranhão">Maranhão</option><option value="Mato Grosso">Mato Grosso</option><option value="Mato Grosso do Sul">Mato Grosso do Sul</option><option value="Minas Gerais">Minas Gerais</option><option value="Paraná">Parana</option><option value="Paraíba">Paraiba</option><option value="Pará">Pará</option><option value="Pernambuco">Pernambuco</option><option value="Piauí">Piaui</option><option value="Pára">Para</option><option value="Rio Grande do Norte">Rio Grande do Norte</option><option value="Rio Grande do Sul">Rio Grande do Sul</option><option value="Rio de Janeiro">Rio de Janeiro</option><option value="Rondônia">Rondonia</option><option value="Roraima">Roraima</option><option value="Santa Catarina">Santa Catarina</option><option value="Sergipe">Sergipe</option><option value="São Paulo">Sao Paulo</option></datalist></span></td></tr>
	<tr style="<?php echo $dispFiltLocal ?>">
		<td align="left" style="font-size: 15px;background: #03457e;color: #FFF;" ><span id="elemCidade"><input type="search" size="50" name="searchGoogle" id="searchGoogle" autocomplete="on" runat="server" placeholder="Digite a rua, cidade, bairro ou cep" style="width: 300px;background: #fff;color: #000;font-size: 15px;">&nbsp;<input type="hidden" id="city2" name="city2" /><input type="hidden" id="cityLat" name="cityLat" /><input type="hidden" id="cityLng" name="cityLng" /></span><span style="display: none;" id="loadCidade"><br><img src="<?php echo plugin_dir_url(__FILE__); ?>img/Ball-1s-20px.gif" align="absmiddle">&nbsp;um momento...</span></td>		
	</tr>
	<tr style="<?php echo $dispFiltLocal ?>">
		<td align="left" colspan="2" style="font-size: 15px;background: #03457e;color: #FFF;"><span id="elemBairro"><select name="bairro" id="bairro" style="background: #fff;color: #000;font-size: 15px;" onchange="carregaGrupos();"><option value="">Todos os bairros</option></select></span><span style="display: none;" id="loadBairro"><br><img src="<?php echo plugin_dir_url(__FILE__); ?>img/Ball-1s-20px.gif" align="absmiddle">&nbsp;um momento...</span><span style="display: none;" id="loadResult"><br><img src="<?php echo plugin_dir_url(__FILE__); ?>img/Ball-1s-20px.gif" align="absmiddle">&nbsp;buscando grupos...</span></td></tr>
	<tr style="<?php echo $dispFiltLocal ?>">
		<td colspan="2" style="background: #03457e;color: #FFF;" align="center"><span onclick="getLocation()"><img src="data:image/png;base64,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" align="absmiddle"/>&nbsp;Minha localização</span></td></tr>
	<tr><td align="left" colspan="2" style="background: #e9e9e9;color: #35414f;font-size: 15px;"><label><input type="checkbox" name="A" id="A" checked="checked" onclick="carregaGrupos();">&nbsp;Reunião Aberta (para visitantes)</label><br><label><input type="checkbox" name="B" id="B" checked="checked" onclick="carregaGrupos();">&nbsp;Reunião Fechada (para pessoas que tem ou pensam ter problemas com drogas)</label></td>
		</tr>
		<tr><td colspan="2" align="left" style="background: #e9e9e9;color: #35414f;font-size: 15px;"><select style="color: #35414f;" name="formatos" id="formatos" onchange="carregaGrupos();">
			<?php if($att['formato'] == "presencial" or $att['formato'] == "virtual"){ ?>
			<option value="">Todos os formatos de reuniões</option>			
			<option value="64">Amadrinhamento/Apadrinhamento</option>
			<option value="69">Ateus e Agnósticos</option>
			<option value="2">Bilíngue</option>
			<option value="53">Cadeirante Parcial</option>
			<option value="33">Cadeirante Total</option>
			<option value="55">Carimbo Beneficiário da Justiça</option>
			<option value="45">Conceitos</option>
			<option value="85">Estudo de Conceitos</option>
			<option value="36">Estudo de Literatura</option>
			<option value="74">Estudo do Livro Apadrinhamento</option>
			<option value="13">Estudo do livro Funciona - Como e Por quê</option>
			<option value="52">Estudo do livro Guia de Princípios</option>
			<option value="88">Estudo do livro Guia de Passos</option>
			<option value="3">Estudo do Texto Básico</option>
			<option value="51">Estudo do Livro Viver Limpo</option>
			<option value="89">Estudo dos Princípios Orientadores</option>
			<option value="30">Estudo de Tradições</option>
			<option value="47">Inglês - Reunião em língua inglesa</option>
			<option value="23">Estudo de Passos</option>
			<option value="62">Estudos</option>
			<option value="5">Fechada em Feriados</option>
			<option value="71">Funciona em Feriados</option>
			<option value="34">Jovens em NA</option>
			<option value="68">LGBTQIAPN+ (interesse LGBTQIAPN+)</option>
			<option value="76">Luz de velas</option>
			<option value="32">Mulheres (interesse feminino)</option>
			<option value="41">Meditação silenciosa</option>
			<option value="75">Morcegão (madrugada)</option>
			<option value="5">Não funciona em feriados</option>
			<option value="61">Partilha de sentimentos</option>
			<option value="97">Sexualidade (partilha livre de sexualidade independente de orientação)</option>
			<option value="26">Temática</option>
			<option value="73">Trabalho de passos através do guia</option>
		<?php }else{ ?>
			<option value="">Todos os formatos</option>			
			<option value="60">Grupos Institucionais</option>
			<option value="77">Subcomitê de Eventos</option>
			<option value="77">Subcomitê Guarda-chuva Unidade & Serviço</option>
			<option value="78">Subcomitê H&I</option>
			<option value="79">Subcomitê IP</option>
			<option value="81">Subcomitê LDA</option>
			<option value="80">Subcomitê Longo Alcance</option>
			<option value="82">Subcomitê RP</option>
			
		<?php } ?>
		</select><input type="hidden" name="ic_formato" id="ic_formato" value="<?php echo $att['formato']; ?>"><div id="dscFormato"></div></td></tr>
		<tr><td colspan="2" align="center" style="background: #e9e9e9;"><div id="map-canvas"></div></td></tr>
</table>

	<span id="tableResult" style="color: #000;"></span>


</div>


</div>
</div>

 <?php 
return ob_get_clean();
}

# INSERÇÃO DO JS
function enqueueAjaxAssetsCog()
{
	if (is_page('grupos') or is_page('reunioes-subcomite') or is_page('virtual')) {
    $baseUrl = plugin_dir_url( __FILE__ );
    wp_enqueue_script('jsAjaxCog', $baseUrl . 'js/js-ajax.js', ['jquery'], null, true);
    wp_localize_script('jsAjaxCog', 'AjaxDataCog', [
        'url' => admin_url('admin-ajax.php')
    ]);

  }
}
add_action('wp_enqueue_scripts', 'enqueueAjaxAssetsCog');//Fim da inserção do JS



 wp_enqueue_style('main-styles', plugin_dir_url(__FILE__). 'css/style.css');
 wp_enqueue_style('main-styles', plugin_dir_url(__FILE__). 'css/jquery-ui.css');


function enqueue_backend_files()
{
	//Implementar algoritmo para "esconder essas includes em outras paginas"
	$baseUrl = plugin_dir_url(__FILE__);
   
   if (is_page('grupos') or is_page('reunioes-subcomite') or is_page('virtual')) {
    wp_enqueue_script('cade-o-grupo', $baseUrl . 'js/jquery-3.6.0.js', ['jquery'], null, true);
    wp_enqueue_script('cade-o-grupo-ui', $baseUrl . 'js/jquery-ui.js', ['jquery'], null, true);
    wp_enqueue_script('cade-o-grupojs', $baseUrl . 'js/cade-o-grupo.js', ['jquery'], null, true);
    wp_enqueue_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBzAcxLVgPJeq1PNriO_kPUnnSPbdkX_vk&libraries=places', array(), '', true);
  }

}
add_action('wp_enqueue_scripts', 'enqueue_backend_files');


function getEstruturaServiceCidades(){
	$strEstado = str_replace(" ", "+", $_GET['estado']); 

	$uri = "https://bmlt.na.org.br/ativo/main_server/client_interface/json/?switcher=GetSearchResults&meeting_key=location_province&meeting_key_value=".$strEstado;

		if($_GET['ic_formato'] == "virtual"){
			$uri .= "&venue_types[]=2&venue_types[]=3";
		}

		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $uri);
		$json = curl_exec($c);
		curl_close($c);
		$estruturas = json_decode($json);
		$arrCidades = array();

		//Varrendo o array para construir o Json:
		$stringJson = "[";

		//Este laço corre os nós de reuniões
		foreach($estruturas as $estrutura){
			if($estrutura->location_municipality != ""){
				if(!in_array($estrutura->location_municipality, $arrCidades))
					array_push($arrCidades, $estrutura->location_municipality);
			}
			

		}
		//Ordenando alfabeticamente
		sort($arrCidades);

		foreach ($arrCidades as $key => $value) {

			$stringJson .= "{";
			$stringJson .= '"location_municipality":"'.$value.'"';
			$stringJson .= "},";
		}


		$stringJson = substr($stringJson, 0,strlen($stringJson)-1);
		$stringJson .= "]";
		return $stringJson;
}

function getEstruturaBairros(){

	$strCidade = str_replace(" ", "+", $_GET['cidade']); 
	$uri = "https://bmlt.na.org.br/ativo/main_server/client_interface/json/?switcher=GetSearchResults&meeting_key=location_municipality&meeting_key_value=".$strCidade;

		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $uri);
		$json = curl_exec($c);
		curl_close($c);
		$estruturas = json_decode($json);
		$arrCidades = array();

		//Varrendo o array para construir o Json:
		$stringJson = "[";

		//Este laço corre os nós de reuniões
		foreach($estruturas as $estrutura){
			if($estrutura->location_neighborhood != ""){
				if(!in_array($estrutura->location_neighborhood, $arrCidades))
					array_push($arrCidades, $estrutura->location_neighborhood);
			}
			

		}
		//Ordenando alfabeticamente
		sort($arrCidades);

		foreach ($arrCidades as $key => $value) {
			$stringJson .= "{";
			$stringJson .= '"location_neighborhood":"'.$value.'"';
			$stringJson .= "},";
		}


		$stringJson = substr($stringJson, 0,strlen($stringJson)-1);
		$stringJson .= "]";
		return $stringJson;
}

function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit) {
  $theta = $longitude1 - $longitude2; 
  $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
  $distance = acos($distance); 
  $distance = rad2deg($distance); 
  $distance = $distance * 60 * 1.1515; 
  switch($unit) { 
    case 'miles': 
      break; 
    case 'kilometers' : 
      $distance = $distance * 1.609344; 
  } 
  return (round($distance,2)); 
}

// Compara se $a é maior que $b
function cmpCog($a, $b) {
	return $a['distancia'] > $b['distancia'];
}


function getEstruturaGrupos(){

	$periodo = $_GET['periodo'];
	if($periodo == ""){
		$periodo = "all";
	}


	
	if(isset($_GET['long'])){
		$lat = $_GET['lat'];
		$long = $_GET['long'];
		$rangekm = $_GET['rangekm'];
		

		$uri = "https://bmlt.na.org.br/ativo/main_server/client_interface/json/?switcher=GetSearchResults&get_used_formats&lang_enum=pt&data_field_key=location_postal_code_1,location_nation,duration_time,start_time,time_zone,weekday_tinyint,service_body_bigint,location_province,location_municipality,location_street,location_info,formats,format_shared_id_list,comments,location_sub_province,worldid_mixed,root_server_uri,id_bigint,venue_type,meeting_name,location_text,location_neighborhood,virtual_meeting_additional_info,virtual_meeting_link,phone_meeting_number,latitude,longitude,contact_name_1,contact_phone_1,contact_email_1,contact_name_2,contact_phone_2,contact_email_2&venue_types=-2%20&formats=-60%20&formats=-77%20&formats=-78%20&formats=-79%20&formats=-80%20&formats=-81%20&formats=-82%20&formats=-83&lat_val=".$lat."&long_val=-".$long."&geo_width_km=-".$rangekm."&lat_val=".$lat."&long_val=".$long."&geo_width_km=-".$rangekm."&sort_keys=start_time&callback=jsonp_1651544975499_18261";
		
	}else{
		 $uri = "https://bmlt.na.org.br/ativo/main_server/client_interface/json/?switcher=GetSearchResults";
		

			if($_GET['estado'] != "" && $_GET['cidade'] == ""){
					$strEstado = $nomeGrupo = str_replace(" ", "+", $_GET['estado']);
					$uri .= "&meeting_key=location_province&meeting_key_value=".$strEstado;
			}

			if($_GET['cidade'] != ""){
					$strCidade = str_replace(" ", "+", $_GET['cidade']); 
					$uri .= "&meeting_key=location_municipality&meeting_key_value=".$strCidade;
			}
	}

		// Nunca existirão reuniões abertas e fechadas ao mesmo tempo
		if(!($_GET['A'] == "1" && $_GET['B'] == "1")){  //se não estiver checado os dois
			if($_GET['A'] == "1"){
				$uri .= "&formats[]=17";
			}
		
			if($_GET['B'] == "1"){
				$uri .= "&formats[]=4";
			}
		}
			//Trazendo os formatos e virtual que também é um formato:
			if($_GET['formatos'] != "" && $_GET['ic_formato'] != "virtual"){
					$uri .= "&formats=".$_GET['formatos'];
			}else if($_GET['formatos'] != "" && $_GET['ic_formato'] == "virtual"){
				$uri .= "&formats[]=".$_GET['formatos']."&venue_types[]=2&venue_types[]=3";
			}else if($_GET['formatos'] == "" && $_GET['ic_formato'] == "virtual"){
				$uri .= "&venue_types[]=2&venue_types[]=3";
			}else if($_GET['formatos'] != "" && $_GET['ic_formato'] == "subcomite"){
				$uri .= "&formats=".$_GET['formatos'];
			}

		$weekdays = $_GET['weekdays'];
		
		//Condição se for o primeiro load e não for virtual
		if($weekdays == "" && $_GET['ic_formato'] != "virtual"){  
				$weekdays = "all"; 
		}else if($weekdays == "" && $_GET['ic_formato'] == "virtual"){ 
			//condição se for o primeiro load e for virtual exibir só a do dia
			date_default_timezone_set('America/Sao_Paulo'); // Configura o fuso horário para Brasília
				$numero_dia_semana = date('w')+1;
				$weekdays = $numero_dia_semana;
				
		}

		if($weekdays != "all"){
			$uri .= "&weekdays=".$weekdays;
		}

		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $uri);
		$json = curl_exec($c);
		curl_close($c);
		$reunioes = json_decode($json);


		$listaDeGrupos = array();
		$colecaoReuniao = new colecaoReuniaoCog();
		$diasDaSemana[1] =  "Dom";
		$diasDaSemana[2] =  "Seg";
		$diasDaSemana[3] =  "Ter";
		$diasDaSemana[4] =  "Qua";
		$diasDaSemana[5] =  "Qui";
		$diasDaSemana[6] =  "Sex";
		$diasDaSemana[7] =  "Sáb";
		
		if(isset($_GET['long'])){ //O resultado quando busca por longitude e latitude no bmlt vem com uma estrutura raiz diferente:
			$reunioes = $reunioes->meetings;
		}

		foreach($reunioes as $reuniao){ //Varre o Json e constroi a Colecao de Reuniões
				
				$ic_formato = false;
				
				if($_GET['ic_formato'] == "subcomite"){
						if(!strstr($reuniao->formats,"VM") && (strstr($reuniao->formats,"SHI") OR strstr($reuniao->formats,"SUB-RP") OR strstr($reuniao->formats,"SUB-U&S") OR strstr($reuniao->formats,"SUB-LDA") OR strstr($reuniao->formats,"SUB-IP") OR strstr($reuniao->formats,"SUB-LA") OR strstr($reuniao->formats,"SUB-EV") OR strstr($reuniao->formats,"INST") OR strstr($reuniao->formats,"SUB-H&I") OR strstr($reuniao->formats,"SUB-HI"))){
							$ic_formato = true;
						}
				}else if($_GET['ic_formato'] == "presencial"){
				if(!strstr($reuniao->formats,"VM") && !strstr($reuniao->formats,"SHI") && !strstr($reuniao->formats,"SUB-RP") && !strstr($reuniao->formats,"SUB-U&S") && !strstr($reuniao->formats,"INST") && !strstr($reuniao->formats,"SUB-LDA") && !strstr($reuniao->formats,"SUB-IP") && !strstr($reuniao->formats,"SUB-H&I") && !strstr($reuniao->formats,"SUB-LA") && !strstr($reuniao->formats,"SUB-EV") && !strstr($reuniao->formats,"SUB-HI")){
						$ic_formato = true;
					}

				}else if($_GET['ic_formato'] == "virtual"){
				if(!strstr($reuniao->formats,"SHI") && !strstr($reuniao->formats,"SUB-RP") && !strstr($reuniao->formats,"SUB-U&S") && !strstr($reuniao->formats,"INST") && !strstr($reuniao->formats,"SUB-LDA") && !strstr($reuniao->formats,"SUB-IP") && !strstr($reuniao->formats,"SUB-LA") && !strstr($reuniao->formats,"SUB-H&I") && !strstr($reuniao->formats,"SUB-EV") && !strstr($reuniao->formats,"SUB-HI")){
						$ic_formato = true;
					}

				}

				if($ic_formato && ($reuniao->service_body_bigint != 142)){ //formato de reunião e tambem não traz um grupo de um CSA que foi excluido mas insiste em aparecer.
				   $virtual_meeting_link = "";
				   if(isset($reuniao->virtual_meeting_link)){
				   		$virtual_meeting_link = $reuniao->virtual_meeting_link;
				   }

				   $virtual_meeting_additional_info = "";
				   if(isset($reuniao->virtual_meeting_additional_info)){
				   		$virtual_meeting_additional_info = $reuniao->virtual_meeting_additional_info;
				   }

				   $location_info = "";
				   if(isset($reuniao->location_info)){
				   		$location_info = $reuniao->location_info;
				   }
					if($_GET['bairro'] == ""){
						 $nomeGrupo = str_replace("Reunião Grupo ", "", $reuniao->meeting_name); 
						 $colecaoReuniao->hasReuniao($nomeGrupo,$reuniao->location_neighborhood,$reuniao->location_municipality,$reuniao->start_time,$reuniao->weekday_tinyint,$reuniao->formats, $reuniao->location_street, $reuniao->location_sub_province,$reuniao->location_province,$reuniao->location_postal_code_1,$reuniao->location_nation,$reuniao->location_text,$reuniao->longitude,$reuniao->latitude, $reuniao->duration_time, $virtual_meeting_link,$virtual_meeting_additional_info,$location_info,$periodo);
						}else{
							if($_GET['bairro'] == $reuniao->location_neighborhood){
								$nomeGrupo = str_replace("Reunião Grupo ", "", $reuniao->meeting_name); 
							 	$colecaoReuniao->hasReuniao($nomeGrupo,$reuniao->location_neighborhood,$reuniao->location_municipality,$reuniao->start_time,$reuniao->weekday_tinyint,$reuniao->formats, $reuniao->location_street, $reuniao->location_sub_province,$reuniao->location_province,$reuniao->location_postal_code_1,$reuniao->location_nation,$reuniao->location_text,$reuniao->longitude,$reuniao->latitude, $reuniao->duration_time,$virtual_meeting_link,$virtual_meeting_additional_info, $location_info,$periodo);
							}
						}
				} // formato: SHI
		} 

		if(isset($_GET['long'])){

			$arrReunioes = array();
			foreach($colecaoReuniao->Reunioes as $reuniao){ 
				$km = getDistanceBetweenPointsNew($lat, $long, $reuniao->latitude, $reuniao->longitude, $unit = 'kilometers');
				array_push($arrReunioes,array('distancia' => $km, 'reuniao' => $reuniao));
				
			}
			// Ordena por KM
			usort($arrReunioes, 'cmpCog');
		}else{
			//Correr as reuniões para organizar alfabeticamente depois
			$arrReunioesPorNome = array();
			foreach($colecaoReuniao->Reunioes as $reuniao){ 
			
				$arrReunioesPorNome[$reuniao->meeting_name] = $reuniao;
			}

			if($_GET['ic_formato']  != "virtual"){ 
			//Ordenar alfabeticamente somente se não for virtual porque as virtuais é interessante trazer a ordenação por horário
						//Ordenar alfabeticamente
						sort($arrReunioesPorNome);
			}
			$arrReunioes = array();
			foreach($arrReunioesPorNome as $reuniao){ 
				
				array_push($arrReunioes,array('distancia' => "0", 'reuniao' => $reuniao));
				
			}
		}


			
			
		$contador = 0;
		$jsonGeoLocalizacao = "{";
		$contGeo = 0;
		foreach($arrReunioes as $value){ 
			$reuniao = $value['reuniao'];
			$jsonGeoLocalizacao .= '"grupo'.$contGeo.'": [ {';
			$jsonGeoLocalizacao .= '"meeting_name":"<b>Grupo '.$reuniao->meeting_name.'</b>",';
			$jsonGeoLocalizacao .= '"longitude":"'.$reuniao->longitude.'",';
			$jsonGeoLocalizacao .= '"endereco":"'.$reuniao->location_street . "<br>". $reuniao->location_municipality . " ". $reuniao->location_province . " ".  $reuniao->location_postal_code_1 ." " . $reuniao->location_neighborhood.'",';
			$jsonGeoLocalizacao .= '"latitude":"'.$reuniao->latitude.'"';
			$jsonGeoLocalizacao .= "}],";
			$contGeo++;
			
		}
		$jsonGeoLocalizacao = substr($jsonGeoLocalizacao, 0,strlen($jsonGeoLocalizacao)-1);
		$jsonGeoLocalizacao .= "}||";

	
		echo $jsonGeoLocalizacao; 
		


		?>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background: background: #dddddd;color: #515151;">
			<tr><td align="right"><select name="weekdays" id="weekdays" style="width: 200px;" onchange="carregaGruposPeriodo();"><option value="all" <?php if($weekdays == "all"){
					echo 'selected';
				} ?>>Todos os dias</option><option value="1" <?php if($weekdays == "1"){
					echo 'selected';
				} ?>>Domingo</option><option value="2" <?php if($weekdays == "2"){
					echo 'selected';
				} ?>>Segunda-feira</option><option value="3" <?php if($weekdays == "3"){
					echo 'selected';
				} ?>>Terça-feira</option><option value="4" <?php if($weekdays == "4"){
					echo 'selected';
				} ?>>Quarta-feira</option><option value="5" <?php if($weekdays == "5"){
					echo 'selected';
				} ?>>Quinta-feira</option><option value="6" <?php if($weekdays == "6"){
					echo 'selected';
				} ?>>Sexta</option><option value="7" <?php if($weekdays == "7"){
					echo 'selected';
				} ?>>Sábado</option></select><span style="display: none;" id="loadDiaSemana"><br><img src="<?php echo plugin_dir_url(__FILE__); ?>img/Ball-2s-20px.gif" align="absmiddle">&nbsp;um momento...</span>
			</td></tr>
			<tr><td align="right">
				<select name="periodo" id="periodo" style="width: 200px;" onchange="carregaGruposPeriodo();"><option value="all" <?php if($periodo == "all"){
					echo 'selected';
				} ?>>Todos os horários</option><option value="manha" <?php if($periodo == "manha"){
					echo 'selected';
				} ?>>Manhã</option><option value="tarde" <?php if($periodo == "tarde"){
					echo 'selected';
				} ?>>Tarde</option><option value="noite" <?php if($periodo == "noite"){
					echo 'selected';
				} ?>>Noite</option><option value="corujao" <?php if($periodo == "corujao"){
					echo 'selected';
				} ?>>Corujão</option></select><span style="display: none;" id="loadPeriodo"><br><img src="<?php echo plugin_dir_url(__FILE__); ?>img/Ball-2s-20px.gif" align="absmiddle">&nbsp;um momento...</span>
			</td></tr>
		<?php 

		if(count($arrReunioes) == 0){
			echo '<tr><td valign="top">Sem reuniões para esta busca.</td></tr>';
		}

		switch ($weekdays) {
    case 1:
        $nomeDaSemana = " que tem reuniões no domingo";
        break;
    case 2:
        $nomeDaSemana = " que tem reuniões na segunda-feira";
        break;
    case 3:
        $nomeDaSemana = " que tem reuniões na terça-feira";
        break;
    case 4:
        $nomeDaSemana = " que tem reuniões na quarta-feira";
        break;
    case 5:
        $nomeDaSemana = " que tem reuniões na quinta-feira";
        break;
    case 6:
        $nomeDaSemana = " que tem reuniões na sexta-feira";
        break;
    case 7:
        $nomeDaSemana = " que tem reuniões no sábado";
        break;
    case "all":
        $nomeDaSemana = " que tem reuniões em diversos dias da semana ";
        break;
   
		}
		switch ($periodo) {
    case "manha":
        $periodo = " no período da manhã";
        break;
    case "tarde":
        $periodo = " no período da tarde";
        break;
    case "noite":
        $periodo = " no período da noite";
        break;
    case "corujao":
        $periodo = " com reuniões à partir das 22:00 (horário de Brasília)";
        break;
    case "all":
        $periodo = "";
        break;   
   
		}
if($_GET['ic_formato']  == "subcomite"){
	if(count($arrReunioes) > 1)
		$entidade = "subcomitês";
	else
		$entidade = "subcomitê";

}else if($_GET['ic_formato']  == "presencial"){	
	if(count($arrReunioes) > 1)
		$entidade = "grupos presenciais";
	else
		$entidade = "grupo presencial";

}else if($_GET['ic_formato']  == "virtual"){

	if(count($arrReunioes) > 1)
		$entidade = "grupos virtuais";
	else
		$entidade = "grupo virtual";
}
echo '<tr><td valign="top">Exibindo '.count($arrReunioes).' '.$entidade.' '.$nomeDaSemana . $periodo.'</td></tr>';
		foreach($arrReunioes as $value){ 
			$reuniao = $value['reuniao'];
			
			if(isset($_GET['long'])){
				$km_distancia = $value['distancia'] . " km";
			}else{
				$km_distancia = "";
			}
			?>
			
<tr><td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #CCC;" id="copy<?php echo $contador; ?>">
<tr><td colspan="2" style="font-weight: bold;background: #9fc7ea;border-top: 1px solid #000;" align="center"><?php 

			if($_GET['ic_formato']  != "subcomite"){
					echo "Grupo " . $reuniao->meeting_name . " " . $km_distancia;
					$txtWeek = "Grupo ".$reuniao->meeting_name ."<br>";
			}else{
				echo $reuniao->meeting_name . " " . $km_distancia;
				$txtWeek = $reuniao->meeting_name ."<br>";
			}

?></td></tr>
<?php 
$cor = 0;

$hasReuniaoVirtual = false;
foreach($reuniao->semana as $keyWeek=>$week){ 
	
	if(strstr($week,"Virtual")){
		//$hasReuniaoVirtual = true;
	}

	if($week != ""){
		if($cor % 2 == 0){
			$bg   = "#fff";
		}else{
			$bg   = "#f7f7f7";
		}
	?>
	<tr>
		<td width="25%" style="background: <?php echo $bg; ?>;color: #35414f;font-size: 15px;border-bottom: 1px dashed #ccc;font-weight: bold;" valign="top"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABmJLR0QA/wD/AP+gvaeTAAAB9UlEQVQ4jb2RzWsTQRjGf5PsR5aY1jTaSkEs2EJPQgQLkYJSEOmlHguCB0/6J3jx/+jJiwdvWs+FeDDYS6uXHiTYmiAmuilZ89FsduLueKgJ2WSlfmCf0zvPzPvO75mB09CLV69vbuYLG0opMbqnlBKb+cLG8/ybG1G9Wr/4trycjpvePaGEtftx/44zt5Cz19fs9srS0XCDvb6W5OGjB5lS8Up7ZemlEsr1PfPp2ULBCQ3UTPkMxG0EdEtlmFvArdcfJ0cY3XodAK9UziHICQSaKVeBVYDY0NnsIFbpAFH5jGyG4ACQzTaiWiEoHQzbV/vF4P7WrVxdBH4awJXfOer2yKQSCBFGVEpx2PY4Y2pYxnFAFYs7qa3tqVDk1rXrVqwnB40JYJzvWBbgA+2f60A3LLa2w4Tv3n+wgfO/mHGSatnF+ekQ4bC+HDrUG00uX5xl/1OFqckJgDHvwrn0WG9szAFanQ41p4HvB9ScBq1OJ9KLUmRk2evR830sw8SVHno8DjDmGbo+FjmSsFy12dkr0vUkO3tFylU70otS5BtmJlPomoaux7k0O8NE0gKI9H5roOz5dNwuQaDouF0ShgEQ6Y3qv37KV2A68tTJsrOL8zMhQgFv/3IYwG6/GLxhTOp3A1PeD9SfUcYEtjK0J/8Ac8r6ASTtCW9YdsJaAAAAAElFTkSuQmCC" align="absmiddle"/> &nbsp;<?php echo $diasDaSemana[$keyWeek]; ?></td>
		<td style="background: <?php echo $bg; ?>;color: #35414f;font-size: 15px;border-bottom: 1px dashed #ccc;" align="left"><?php 
			
			echo $week;
		 ?></td>
	</tr>
<?php 
		$txtWeek .= $diasDaSemana[$keyWeek] . " " .$week."<br>";
		$cor++;
		} 

		
	}

	$txtWeek .= $reuniao->location_street . ", " . $reuniao->location_neighborhood ."<br>". $reuniao->location_municipality . " / " . $reuniao->location_province . " - ". $reuniao->location_postal_code_1;
	?>
	<tr><td style="font-size: 15px;background: #f7f7f7;padding-left: 10px;" valign="top" colspan="2">
<?php echo $reuniao->location_street . ", " . $reuniao->location_neighborhood ."<br>". $reuniao->location_municipality . " / " . $reuniao->location_province . " - ". $reuniao->location_postal_code_1;

			echo "&nbsp&nbsp"; ?>
<?php 

		if($hasReuniaoVirtual){
			echo "Este grupo oferece reuniões virtuais. Clique no horário para acessar o link da reunião virtual.";
		}else{
    	echo "<div>".$reuniao->location_text."</div>";

 ?>
<?php 
		echo "<br>";
		foreach ($reuniao->location_infoGrupo as $key => $value) {
				echo $value . " ";
			}

	}
?></td></tr>
</table></td>
        </tr>
<tr><td align="center" colspan="2" style="font-size: 15px;background: #f7f7f7;"><?php 
if(!$hasReuniaoVirtual){ ?><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABxklEQVRIieXUz4uOURQH8M+YLC0ZyszsZjJLNvJjdhZTlNloSjEpNiQbejd2FhYshizU/AGUJiskm7FQQqYpReFNKKJkvKbBeMfinqfnpqHnfeddKKdu557zPPf7Pefecw7/g/TjHGbxCQt4grPYuBLgLpzCdyz9Yc3jSLsE5wOkiTs4iZvh+4oH2ffDrYKPZlG+xwFcDvsHatiNC0GwiG1VwbvwLMA+hv4cQEv4gmmMB8nV8N+qSrAlDnzAfry2/P3PBcmZjHzod7BVyxBsDv04vq8N+x360Cu9xRocxYnIGnZUyaAW0UzhaRbxQPZPb/gWQ78JXauSwdvQ2zEopU8qyUJWh+7Gc7wKu14lg6Es6oayHG9E5H1ZxN+kPpgLe7AKAdzPQMczgHw1cRqTYd+tCg4jWQYHg2RaKtGCYCL882GPtEIA1+PgI+yRqmUhfJPhexj2tVbBoUfqhQKwaLrbUoNdVDbjhnYIYCxAfoaewV4cUl7NvnbBC5lSTs4xKfp74buyUnBYLz12E8dwPPYN6Rr/Kt0VCBpYh63SJO3HJlySsuuI7JSu5CVexH64U+Ck0VBX9kBdOS46JrukCTsT+39DfgGVi55SasT41gAAAABJRU5ErkJggg==" align="absmiddle"/>&nbsp;<a href="https://www.google.com/maps/search/?api=1&query=<?php echo $reuniao->latitude; ?>,<?php echo $reuniao->longitude; ?>&q=<?php echo $reuniao->latitude; ?>,<?php echo $reuniao->longitude; ?>" target="_blank">Mapa</a>&nbsp;&nbsp;&nbsp;<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABmJLR0QA/wD/AP+gvaeTAAAAxUlEQVQ4jd3UQU4CQRCF4S9uXUk4Aq70BkSWxAMYw1GEs8gBBrdwDUI8xOwY4QA4LnoWk5ER6J6w8CW9q/q7ql518181wgZ7fKCfAuvhC2XtLFKAzw1YiV0s7AHLI8B1DCjDAZ+Y47uCbTFsS5zgHVPcHgG94KaKHWCMuzbYrNFG3gI6W7nfs5ldCqoHl5dWcEpTHbcMr4Ipb06bci+Y0ou56K+1KfAUA4VHrHSw2HV1+vQIMysawCwFSJjZuqosk/h9XVc/syZOhxKKx3YAAAAASUVORK5CYII=" align="absmiddle"/>&nbsp;<a href="#copy<?php echo $contador; ?>" onclick="navigator.share({
    title: 'web.dev',
    text: '*Grupo <?php echo $reuniao->meeting_name;?>*<?php echo $reuniao->location_street;?>, <?php echo $reuniao->location_municipality;?>, <?php echo $reuniao->location_province;?>, <?php echo $reuniao->location_postal_code_1;?> <?php echo $reuniao->location_neighborhood;?>',
    url: 'https://www.google.com/maps/search/?api=1&query=<?php echo $reuniao->latitude; ?>,<?php echo $reuniao->longitude; ?>&q=<?php echo $reuniao->latitude; ?>,<?php echo $reuniao->longitude; ?>',
  });">Compartilhar mapa</a>&nbsp;&nbsp;&nbsp;<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABmJLR0QA/wD/AP+gvaeTAAAAtElEQVQ4je3UPQ5BQRSG4cdPoiDR+1kHWp0FsBBLsAAb0bMFK9FSKN1Q3Cu5yDCDjjeZzGTmnC/nS84cvkyldO5igFpC/ir00MUB58T1QL3YB2hjiW1ChUHBq82tJzZiqAbu5ziKs33CGo1yhfcssC8CX9HDBGNsQoLNQmwWITjFCC3Clt/mL/gLgtc+XLmdPB8L3pOhL2/aVwxLOUHW0sbYHh3CNhvyv9mKqDCTT6ldRGw6F9ALNYw7J2X9AAAAAElFTkSuQmCC" align="absmiddle"/>&nbsp;<a href="#copy<?php echo $contador; ?>" onclick="copy('copy<?php echo $contador; ?>')">Copiar</a><?php }?></td></tr>
<tr><td align="left" colspan="2" style="font-size: 15px;background: #f7f7f7;">&nbsp;</td></tr>
		<?php 
			$contador++;
	} ?>
		
</table>
<?php } //final da function getEstruturaGrupos

function getEstruturaGoogleMaps(){
	$searchGoogle = str_replace(" ", "+", $_GET['searchGoogle']);
	$uri = "https://maps.googleapis.com/maps/api/geocode/json?address=".$searchGoogle."&key=AIzaSyBzAcxLVgPJeq1PNriO_kPUnnSPbdkX_vk";

		
		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $uri);
		$json = curl_exec($c);
		curl_close($c);
		$reunioes = json_decode($json);
		return $json;


} //função da function getEstruturaGoogleMaps

# FUNÇÃO AJAX
function get_service_cidades()
{
    
    $stringJson = getEstruturaServiceCidades();

    //header("Content-type: application/json");
	echo $stringJson;
}
add_action('wp_ajax_get_service_cidades', 'get_service_cidades');
add_action('wp_ajax_nopriv_get_service_cidades', 'get_service_cidades');

function get_service_bairros()
{
    
    $stringJson = getEstruturaBairros();

    //header("Content-type: application/json");
	echo $stringJson;
}
add_action('wp_ajax_get_service_bairros', 'get_service_bairros');
add_action('wp_ajax_nopriv_get_service_bairros', 'get_service_bairros');

function get_service_grupos()
{
    
    $stringJson = getEstruturaGrupos();

    //header("Content-type: application/json");
	echo $stringJson;
}
add_action('wp_ajax_get_service_grupos', 'get_service_grupos');
add_action('wp_ajax_nopriv_get_service_grupos', 'get_service_grupos');

function get_service_google_maps()
{
    
    $stringJson = getEstruturaGoogleMaps();

    //header("Content-type: application/json");
	echo $stringJson;
}
add_action('wp_ajax_get_service_google_maps', 'get_service_google_maps');
add_action('wp_ajax_nopriv_get_service_google_maps', 'get_service_google_maps');




?>