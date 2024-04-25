jQuery( function() {
	
		/*$( "#estado" ).on( "change", function() {
			montaCidade($("#estado").val());
		});*/
		var ic_formato = $("#ic_formato").val();
		if(ic_formato == "presencial" || ic_formato == "subcomite"){
			habilitaGeoLocalizacao();
			getLocation();
		}else if(ic_formato == "virtual"){
			habilitaEstadoCidade();
			$( "#estado" ).on( "change", function() {
				montaCidade($("#estado").val());
			});
			carregaGrupos();
		}
	} );

function montaCidade(elemEstado){
	estado = elemEstado.value;
	var ic_formato = $("#ic_formato").val();
	if(estado == "Buscar por geolocalização"){
		habilitaGeoLocalizacao();
	}else{
				selectCidade = document.getElementById("cidade");
				selectCidade.value = "";
				$('#cidade').prop("disabled", true);

				if(estado != ""){
						$( "#loadCidade" ).show();
						 jQuery.ajax({
											url: AjaxDataCog.url,
											type: 'GET',
											data : {
														action : 'get_service_cidades',
														estado : estado,
														ic_formato: ic_formato
												},
											success: function(response) {
												
									Jsontxt = response.slice(0, -1);
											
											populaCidade(Jsontxt);
																 
											}
							});
				}else{
						var selectCidade = document.getElementById("cidade");
					 	while (selectCidade.options.length > 0) {
								selectCidade.remove(0);
						}
					var nome = document.createTextNode("Todas as cidades");
					var option = document.createElement("option");
					option.setAttribute("value","");
					option.appendChild(nome);
					selectCidade.appendChild(option);
				}
	}
}

function retira_acentos(str) 
{

    com_acento = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝŔÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿŕ";

sem_acento = "AAAAAAACEEEEIIIIDNOOOOOOUUUUYRsBaaaaaaaceeeeiiiionoooooouuuuybyr";
    novastr="";
    for(i=0; i<str.length; i++) {
        troca=false;
        for (a=0; a<com_acento.length; a++) {
            if (str.substr(i,1)==com_acento.substr(a,1)) {
                novastr+=sem_acento.substr(a,1);
                troca=true;
                break;
            }
        }
        if (troca==false) {
            novastr+=str.substr(i,1);
        }
    }
    return novastr;
}       

function populaCidade(txtJson){
	 // console.log(txtJson);
	
		cidades = JSON.parse(txtJson);
	
	 	var city_list = document.getElementById("city_list");
		var optionCityList = "";


		for(let Cities of Object.entries(cidades)){
			 
			optionCityList += '<option value="'+Cities[1].location_municipality+'">'+retira_acentos(Cities[1].location_municipality)+'</option>';

		}
		city_list.innerHTML = optionCityList;
		$( "#loadCidade" ).hide();
		$('#cidade').prop("disabled", false);
		document.getElementById("cidade").focus();

	}

function consultaCity(){
	
	var val = document.getElementById("cidade").value;
    var opts = document.getElementById('city_list').childNodes;
    for (var i = 0; i < opts.length; i++) {
      if (opts[i].value === val) {
        // An item was selected from the list!
       
        montaBairro(opts[i].value);
        break;
      }
    }
}

	function montaBairro(cidade){
	
	if(cidade != ""){
			$( "#loadBairro" ).show();
			
			 jQuery.ajax({
								url: AjaxDataCog.url,
								type: 'GET',
								data : {
											action : 'get_service_bairros',
											cidade : cidade
									},
								success: function(response) {
									
								Jsontxt = response.slice(0, -1);
								
								populaBairro(Jsontxt);
								carregaGrupos();
													 
								}
				});
		}else{
				var selectCidade = document.getElementById("bairro");
			 	while (selectCidade.options.length > 0) {
						selectCidade.remove(0);
				}
				var nome = document.createTextNode("Todos os bairros");
				var option = document.createElement("option");
				option.setAttribute("value","");
				option.appendChild(nome);
				selectCidade.appendChild(option);
				carregaGrupos();
	}
}

function populaBairro(txtJson){
	  //console.log(txtJson);
	
		bairros = JSON.parse(txtJson);
	
	 var selectBairro = document.getElementById("bairro");
	 while (selectBairro.options.length > 0) {
				selectBairro.remove(0);
		}

		var nome = document.createTextNode("Todos os bairros");
		var option = document.createElement("option");
		option.setAttribute("value","");
		option.appendChild(nome);
		selectBairro.appendChild(option);

		for(let Neighborhoods of Object.entries(bairros)){
				//console.log(Neighborhoods[1].location_neighborhood);
				 
				
				var nome = document.createTextNode(Neighborhoods[1].location_neighborhood);
				var option = document.createElement("option");
				option.setAttribute("value",Neighborhoods[1].location_neighborhood);
				option.appendChild(nome);
				selectBairro.appendChild(option);

		}
		$( "#loadBairro" ).hide();
		carregaGrupos();
	}

function carregaGruposPeriodo(){
	$( "#loadPeriodo" ).show();
	carregaGrupos();
}
function carregaGrupos(){
	var tpBusca = $("#tpBusca").val();
	var formatos = $("#formatos").val();
	var periodo = $("#periodo").val();
	var weekdays = $("#weekdays").val();

	if(formatos != ""){
		$('#A').prop('checked', true);
		$('#B').prop('checked', true);
	}
	var A = "0";
	var B = "0";

	if($("#A").is(":checked")){
		 A = "1";
	}
	if($("#B").is(":checked")){
		 B = "1";
	}


	if(tpBusca == "estado"){
			var estado = $("#estado").val();
			var cidade = $("#cidade").val();
			var bairro = $("#bairro").val();
			var ic_formato = $("#ic_formato").val();
			

					$( "#loadResult" ).show();
					 jQuery.ajax({
										url: AjaxDataCog.url,
										type: 'GET',
										data : {
													action : 'get_service_grupos',
													estado : estado,
													cidade : cidade,
													bairro : bairro,
													A : A,
													B : B,
													formatos: formatos,
													periodo: periodo,
													ic_formato : ic_formato,
													weekdays: weekdays
											},
										success: function(response) {
											
										arrTxt = response.split("||");
										txt = arrTxt[1];
										txt = txt.slice(0, -1);
										
										populaGrupo(txt);
															 
										}
						});
	}else{
		$( "#loadResult" ).show();
		var rangekm = document.getElementById("rangekm").value;
		var cityLat = document.getElementById("cityLat").value;
    	var cityLng = document.getElementById("cityLng").value;
    	var ic_formato = $("#ic_formato").val();

			 jQuery.ajax({
								url: AjaxDataCog.url,
								type: 'GET',
								data : {
											action : 'get_service_grupos',
											lat : cityLat,
											long : cityLng,											
											A : A,
											B : B,
											estado : '',
											cidade : '',
											bairro : '',
											formatos: formatos,
											rangekm: rangekm,
											periodo: periodo,
											ic_formato : ic_formato,
											weekdays: weekdays
									},
								success: function(response) {
									
								arrTxt = response.split("||");
								txt = arrTxt[1];
								txt = txt.slice(0, -1);
								if(arrTxt[0] != "}"){ //correção de bug quando não vem resultado para não dar pau
									exibeMapa(arrTxt[0]);
								}
								populaGrupo(txt);
													 
								}
				});
	}


}

function populaGrupo(txt){
	
	$( "#loadResult" ).hide();
	var tableResult = document.getElementById("tableResult");

	tableResult.innerHTML = txt;
	
	$( "#loadPeriodo" ).hide();
	//console.log(txt);
	var ic_formato = $("#ic_formato").val();
	if(ic_formato == "virtual"){		
    	document.getElementById("periodo").focus();
	}
}

function copy(idCopy) {
	alert("As informações deste grupo foram copiadas!");
			var target = document.getElementById(idCopy);
			var range, select;
			if (document.createRange) {
				range = document.createRange();
				range.selectNode(target)
				select = window.getSelection();
				select.removeAllRanges();
				select.addRange(range);
				document.execCommand('copy');
				select.removeAllRanges();
			} else {
				range = document.body.createTextRange();
				range.moveToElementText(target);
				range.select();
				document.execCommand('copy');
			}

}
function initialize() {
          var input = document.getElementById('searchGoogle');
          var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                document.getElementById('city2').value = place.name;
                document.getElementById('cityLat').value = place.geometry.location.lat();
                document.getElementById('cityLng').value = place.geometry.location.lng();
            });
        }

function habilitaGeoLocalizacao(){

	mapCanvas = document.getElementById("map-canvas");
	mapCanvas.innerHTML = "";
	mapCanvas.style.height = "500px";	

	tpBusca = document.getElementById("tpBusca");
	tpBusca.value = "geolocalizacao";
	elemCidade = document.getElementById("elemCidade");
	selectCidade = document.getElementById("estado").value = "";
	elemEstado = document.getElementById("elemEstado");

	
	elemEstado.innerHTML = '';
	var htmlMaps = '<input type="search" size="50" name="searchGoogle" id="searchGoogle" autocomplete="on" runat="server" placeholder="Digite a rua, cidade, bairro ou cep" style="width: 300px;background: #fff;color: #000;font-size: 15px;">&nbsp;<input type="hidden" id="city2" name="city2" /><input type="hidden" id="cityLat" name="cityLat" /><input type="hidden" id="cityLng" name="cityLng" />';
	elemCidade.innerHTML = htmlMaps;
	
	var searchGoogle = document.getElementById('searchGoogle');
    var autocomplete = new google.maps.places.Autocomplete(searchGoogle);
    autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    document.getElementById("cityLat").value = JSON.stringify(place.geometry.location.lat());
    document.getElementById("cityLng").value = JSON.stringify(place.geometry.location.lng());



    	$( "#loadResult" ).show();
    	var formatos = $("#formatos").val();
		if(formatos != ""){
			$('#A').prop('checked', true);
			$('#B').prop('checked', true);
		}
		var A = "0";
		var B = "0";
		
		if($("#A").is(":checked")){
			 A = "1";
		}
		if($("#B").is(":checked")){
			 B = "1";
		}
		var ic_formato = $("#ic_formato").val();
		var rangekm = document.getElementById("rangekm").value;
			 jQuery.ajax({
								url: AjaxDataCog.url,
								type: 'GET',
								data : {
											action : 'get_service_grupos',
											lat : JSON.stringify(place.geometry.location.lat()),
											long : JSON.stringify(place.geometry.location.lng()),											
											A : A,
											B : B,
											bairro : '',
											formatos: formatos,
											rangekm: rangekm,
											ic_formato : ic_formato
									},
								success: function(response) {
									
								arrTxt = response.split("||");
								txt = arrTxt[1];
								txt = txt.slice(0, -1);
								
								exibeMapa(arrTxt[0]);
								populaGrupo(txt);
													 
								}
				});
  });

	document.getElementById("searchGoogle").focus();
	
	var html = "<input type='range' value='50' max='100' id='rangekm'><span id='labelkm'>50</span>&nbsp;Km de raio de distância";
	html += '<br><span onclick="habilitaEstadoCidade()"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAABmJLR0QA/wD/AP+gvaeTAAABKklEQVRIie2Uv0sCYRjHP9e93aV0Qg39BQltgWgO/RstUVDYQWuDBbZUINZQ0BQ4tLn0b0Tu1dSSqWnU0g8sRcW7ljSksOPupOX9bO/7fHk/8DwPL0gkEolLFIDkyYXt9SHxceM4e7BpKqJ7WF+edy3N5vLsJ9ccZVOHpwCMuLZ55N/E4u+IE2yOzi45v34YmIrNTIGt+ClW2FiYpdZo81iD6XCYr73FtqF4d8u4aLG1GGHn+ArwsdWqqrC9FCGkdSgWCr37SrmEsBrsrkTRxLfO1xlroyp7q1FUq859uUS1UqVVfyWdiBHQ+5vr+3IFdEE6MUfz/YW35ycyZhwjqP3I+TTjfoygRsaM0+5YTBj6r5mhiAEmQ2MD6z1xNpf3JOr+SBKJRDJ0PgE8kEjs/OqHLQAAAABJRU5ErkJggg==" align="absmiddle"/>&nbsp;Selecionar estado, cidade ou bairro</span>';
	elemCidade = document.getElementById("elemBairro").innerHTML = html;



	var $range = document.querySelector('#rangekm'),
    $labelkm = document.getElementById("labelkm");

	$range.addEventListener('input', function() {
  		//$value.textContent = this.value;
  		$labelkm.innerHTML = this.value;
  		//console.log(this.value);
	});
}

var longitude = "";
var latitude = "";
function buscaGoogleMaps(elemento){
	 var searchGoogle = elemento.value;

	 jQuery.ajax({
					url: AjaxDataCog.url,
					type: 'GET',
					data : {
								action : 'get_service_google_maps',
								searchGoogle : searchGoogle
						},
					success: function(response) {
						
					
						arrTxt = response.split("||");
						txt = arrTxt[1];
						Jsontxt = txt.slice(0, -1);
						
					

						responseMaps = JSON.parse(Jsontxt);
						var status = responseMaps.status;
						if(status == "OK"){
							var noresultsGoogleMaps = document.getElementById("noresultsGoogleMaps");
							noresultsGoogleMaps.innerHTML = "";

							formatted_address = responseMaps.results[0].formatted_address;
							geometry = responseMaps.results[0].geometry;

							
							this.latitude = geometry.bounds.northeast.lat;
							this.longitude = geometry.bounds.northeast.lng;

							var searchGoogle_list = document.getElementById("searchGoogle_list");
							var optionList = "";								 
							optionList = '<option value="'+formatted_address+'">'+retira_acentos(formatted_address)+'</option>';
							searchGoogle_list.innerHTML = optionList;
							//console.log(formatted_address);
							exibeMapa(arrTxt[0]);

						}else{

							var noresultsGoogleMaps = document.getElementById("noresultsGoogleMaps");
							noresultsGoogleMaps.innerHTML = "Sem resultado";
							
							
						}
						
										 
					}
	});
}
"use strict";
		var map;
		var activeInfoWindow ;		
		var varMaps = [];
		var varMarkers = [];


function exibeMapa(JsonGrupos){
	var cityLat = document.getElementById("cityLat").value;
    var cityLng = document.getElementById("cityLng").value;

	var mapOptions = {
			  zoom : 12,
			  draggable: true,
			  center : new google.maps.LatLng(cityLat, cityLng),
			  mapTypeId : google.maps.MapTypeId.ROADMAP
			};
			
			
			map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		
		var long = cityLng;
		var lat = cityLat;
		var desc = "Meu Local";
		var local 	= new google.maps.LatLng(lat,long);
		fnPlaceMarkers(local,desc,true);

		grupos = JSON.parse(JsonGrupos);
		
		for(let Groups of Object.entries(grupos)){
			var long = Groups[1][0].longitude;
			var lat = Groups[1][0].latitude;
			var desc = Groups[1][0].meeting_name + "<br>"+Groups[1][0].endereco;
			var local 	= new google.maps.LatLng(lat,long);
			fnPlaceMarkers(local,desc,false);			
		
		}


		window.addEventListener('load', initialize);
}

function fnPlaceMarkers(myLocation,myCityName,isLocal){
			var image = 'https://www.na.org.br/wp-content/plugins/cade-o-grupo/includes/img/NAMarkerB.png';
			if(isLocal){
				var marker = new google.maps.Marker({
					position : myLocation
				

				});
			}else{
				var marker = new google.maps.Marker({
					position : myLocation,
					icon: image
				});

			}
		
			// Renders the marker on the specified map
			marker.setMap(map);	
			varMarkers.push(marker);

			// create an InfoWindow
			var infoWnd = new google.maps.InfoWindow();			
			
			// add content to your InfoWindow
			infoWnd.setContent('<div class="scrollFix">' + myCityName + '</div>');
			
			// add listener on InfoWindow - close last infoWindow  before opening new one 
			google.maps.event.addListener(marker, 'click', function() {
				
				//Close active window if exists - [one might expect this to be default behaviour no?]				
				if(activeInfoWindow != null) activeInfoWindow.close();

				// Open InfoWindow
				infoWnd.open(map, marker);

				// Store new open InfoWindow in global variable
				activeInfoWindow = infoWnd;
			}); 							
		}
function habilitaEstadoCidade(){

	mapCanvas = document.getElementById("map-canvas");
	mapCanvas.innerHTML = "";
	mapCanvas.style.height = "0px";	
	tpBusca = document.getElementById("tpBusca");
	tpBusca.value = "estado";
	var elemCidade = document.getElementById("elemCidade");
	var trelemEstado = document.getElementById("trelemEstado");
	//trelemEstado.style.display = "";
	var elemEstado = document.getElementById("elemEstado");
	var elemBairro = document.getElementById("elemBairro");
	

	elemEstado.innerHTML = '<input type="search" id="estado" name="estado" list="state_list" placeholder="Digite o estado" style="width: 250px;background: #fff;color: #000;font-size: 15px;" onchange="montaCidade(this);"/><datalist id="state_list" style="height:5.1em;overflow:hidden"><option>Buscar por geolocalização</option><option value="Acre">Acre</option><option value="Alagoas">Alagoas</option><option value="Amapá">Amapa</option><option value="Amazonas">Amazonas</option><option value="Bahia">Bahia</option><option value="Ceará">Ceara</option><option value="Distrito Federal">Distrito Federal</option><option value="Espírito Santo">Espirito Santo</option><option value="Goiás">Goias</option><option value="MS">MS</option><option value="Maranhão">Maranhão</option><option value="Mato Grosso">Mato Grosso</option><option value="Mato Grosso do Sul">Mato Grosso do Sul</option><option value="Minas Gerais">Minas Gerais</option><option value="Paraná">Parana</option><option value="Paraíba">Paraiba</option><option value="Pará">Pará</option><option value="Pernambuco">Pernambuco</option><option value="Piauí">Piaui</option><option value="Pára">Para</option><option value="Rio Grande do Norte">Rio Grande do Norte</option><option value="Rio Grande do Sul">Rio Grande do Sul</option><option value="Rio de Janeiro">Rio de Janeiro</option><option value="Rondônia">Rondonia</option><option value="Roraima">Roraima</option><option value="Santa Catarina">Santa Catarina</option><option value="Sergipe">Sergipe</option><option value="São Paulo">Sao Paulo</option></datalist>';

	var html = '<input type="search" id="cidade" name="cidade" oninput="consultaCity()" list="city_list" placeholder="Digite ou selecione a cidade" style="width: 250px;background: #fff;color: #000;font-size: 15px;" disabled="true" /><datalist id="city_list" style="height:5.1em;overflow:hidden"></datalist>';
	

	elemCidade.innerHTML = html;
	html = '<select name="bairro" id="bairro" style="background: #fff;color: #000;font-size: 15px;" onchange="carregaGrupos();"><option value="">Todos os bairros</option></select>';
	html += '<br><span onclick="habilitaGeoLocalizacao()"><img src="data:image/png;base64,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" align="absmiddle"/>&nbsp;Digitar endereço</span>';
	elemBairro.innerHTML = html;
	var ic_formato = $("#ic_formato").val();
	if(ic_formato != "virtual"){
		document.getElementById("estado").focus();
	}
}
function getLocation() {
  
  if (navigator.geolocation) {
  	
    navigator.geolocation.getCurrentPosition(showPosition,showErrorGeo);

  } else { 
  	alert("Geolocation is not supported by this browser.");
    
  }
  
}

function showPosition(position) {
	
 // alert(position.coords.latitude);
 // alert(position.coords.longitude);
	$( "#loadResult" ).show();
	var formatos = $("#formatos").val();
	if(formatos != ""){
		$('#A').prop('checked', true);
		$('#B').prop('checked', true);
	}
	var A = "0";
	var B = "0";
	
	if($("#A").is(":checked")){
		 A = "1";
	}
	if($("#B").is(":checked")){
		 B = "1";
	}
	if(document.getElementById("tpBusca") == "geolocalizacao"){
  		var rangekm = document.getElementById("rangekm").value;
  	}else{
  		var rangekm = 50;
  	}
  		document.getElementById("cityLat").value = position.coords.latitude; 
    	document.getElementById("cityLng").value = position.coords.longitude;
	var ic_formato = $("#ic_formato").val();
			 jQuery.ajax({
								url: AjaxDataCog.url,
								type: 'GET',
								data : {
											action : 'get_service_grupos',
											lat : position.coords.latitude,
											long : position.coords.longitude,											
											A : A,
											B : B,
											bairro : '',
											formatos: formatos,
											rangekm: rangekm,
											ic_formato : ic_formato
									},
								success: function(response) {
								arrTxt = response.split("||");
								txt = arrTxt[1];
								txt = txt.slice(0, -1);

								exibeMapa(arrTxt[0]);
								populaGrupo(txt);
													 
								}
				});
}

function showErrorGeo(error)
  {
  switch(error.code)
    {
    case error.PERMISSION_DENIED:
      alert("Usuário rejeitou a solicitação de Geolocalização.");
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Localização indisponível.");
      break;
    case error.TIMEOUT:
      alert("O tempo da requisição expirou.");
      break;
    case error.UNKNOWN_ERROR:
      alert("Algum erro desconhecido aconteceu.");
      break;
    }
  }

function shareGrupo(texto,url){
	
	var texto = texto.replaceAll("<br>", "\n");

	navigator.share({
    title: 'web.dev',
    text: texto,
    url: url,
  });
}
function consultaCoordenadas(){
	
	var val = document.getElementById("searchGoogle").value;
    var opts = document.getElementById('searchGoogle_list').childNodes;
    for (var i = 0; i < opts.length; i++) {
      if (opts[i].value === val) {
        // An item was selected from the list!
       	alert(opts[i].value);
       	alert(this.longitude);
       	alert(this.latitude);
        
        break;
      }
    }
}