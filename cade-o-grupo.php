<?php
/**
 Plugin Name: Cadê o grupo?
 Description: Lista os grupos de Narcóticos Anônimos através do BMLT
 Version:     1.1
 Author: GS-Tecnologia
 2024-04-23 - William - Remover o filtro de cidade e estado da parte de reuniões virtuais
 */

//Diretivas de segurança
 if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
	die('Sorry, but you cannot access this page directly.');

}

 //Incluindo o script de shortcode
require_once plugin_dir_path(__FILE__) . 'includes/cade-o-grupo-shortcode.php';

?>