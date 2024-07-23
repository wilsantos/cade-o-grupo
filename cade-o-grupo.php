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


function configuracoes_cade_o_grupo()
{
	register_setting ( 
		'grupoconf_cade_o_grupo',
		'chave_api_cade_o_grupo',
		[
			'sanitize_callback' => function ($value){ return $value;}
		]
		);

	add_settings_field( 
		'chave_api_cade_o_grupo', 
		'Chave da API do google Maps',
		function ($args){
			$options = get_option( 'chave_api_cade_o_grupo' );
			?>
				<input
					id="<?php echo esc_attr($args['label_for']) ;?>"
					type="text"
					size="50"
					name="chave_api_cade_o_grupo" 
					value="<?php echo esc_attr( $options );?>"
				/>
			<?php 
		}, 
		'grupoconf_cade_o_grupo',
		'section_cade_o_grupo',
		[
			'label_for' => 'chave_api_cade_o_grupo_html_id',
			'class' => 'minha-class-tr'
		]
	);

	add_settings_section( 
		'section_cade_o_grupo', 
		'Configurações Cadê o Grupo',
		function(){
			echo '<p>Campo reservado para colocar a chave do google maps que será usada na localização dos grupos<p/>';
		},
		'grupoconf_cade_o_grupo'
	);

}
	

add_action('admin_init', 'configuracoes_cade_o_grupo');
function cade_o_grupo_menu(){
	add_options_page( 
		'Configurações - Cadê o Grupo',
		'Cade o Grupo',
		'manage_options', 
		'cade-o-grupo',
		'cade_o_grupo_html' );
}

function cade_o_grupo_html(){
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title());?></h1>
		<form action="options.php" method="post">
			<?php 
				settings_fields( 'grupoconf_cade_o_grupo' );
				do_settings_sections( 'grupoconf_cade_o_grupo' );
				submit_button();
			?>
		</form>
	</div>
	<?php 
}

function filterPluginActions($links)
{
	// If your plugin is under a different top-level menu than Settings (IE - you changed the function above to something other than add_options_page)
	// Then you're going to want to change options-general.php below to the name of your top-level page
	$settings_link = '<a href="options-general.php?page=' . basename(__FILE__) . '">' . __('Settings') . '</a>';
	array_unshift($links, $settings_link);
	// before other links
	return $links;
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'filterPluginActions');



add_action('admin_menu', 'cade_o_grupo_menu');
?>