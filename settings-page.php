<?php

/**
 * Special thanks to: https://deliciousbrains.com/create-wordpress-plugin-settings-page/
 */

add_action( 'admin_menu', function (): void {
	add_options_page(
		TBE_PLUGIN_NAME,
		TBE_PLUGIN_NAME,
		'manage_options',
		TBE_SLUG,
		'tbe_render_plugin_settings_page'
	);
} );

function tbe_render_plugin_settings_page(): void {
	?>
	<h2><?php echo TBE_PLUGIN_NAME;?></h2>
	<form action="options.php" method="post">
        <?php
        settings_fields( TBE_OPTIONS_NAME );
		do_settings_sections( 'lrfw_plugin' ); ?>
		<div>
            <hr style="padding-top: 30px; margin-top: 30px;" />
            <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
        </div>
	</form>
	<?php
}

add_action( 'admin_init', function () {
	register_setting( TBE_OPTIONS_NAME, TBE_OPTIONS_NAME, 'lrfw_example_plugin_options_validate' );
	add_settings_section( 'api_settings', 'Translations', 'lrfw_plugin_section_text', 'lrfw_plugin' );
} );

function lrfw_example_plugin_options_validate( $input ) {
    if(isset($_POST['translations']) && is_array($_POST['translations'])) {
        $contents = json_encode($_POST["translations"], JSON_PRETTY_PRINT);

        file_put_contents(TBE_PLUGIN_DIR."/data.json", $contents);

	    return $_POST["translations"];
    };
}

function lrfw_plugin_section_text() {
    $options = file_get_contents(TBE_PLUGIN_DIR."/data.json");
    $options = $options ? @json_decode($options, true) : null;

    //print_r(get_option(TBE_OPTIONS_NAME));

    foreach($options as $key => $value) {
        ?>
        <div style="margin-top: 20px">
            <label style="font-weight: bold"><?php echo tbe_make_label_from_key($key);?>:</label>
            <textarea style="width: 700px; display: block;" class="input-text" rows="3" name="translations[<?php echo esc_attr($key);?>]"><?php echo esc_attr($value);?></textarea>
        </div>
        <?php
    }
}

