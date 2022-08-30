<?php
/**
 *
"Login Redirect for WordPress" is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
"Login Redirect for WordPress" is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with "Login Redirect for WordPress". If not, see https://www.gnu.org/licenses/gpl-3.0.html.
 *
 * Plugin Name: Text Blocks Editor
 * Description: A plugin that allows you to use hardcoded texts and edit them via wp-admin
 * Version: 1.0
 * Author: Ivan Hanák <kontakt@hanakivan.sk>
 * Author URI: https://hanakivan.sk
 * Text Domain: tutor
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

const TBE_PLUGIN_NAME = "Text Blocks Editor";
const TBE_SLUG = "text-blocks-editor";

const TBE_OPTIONS_NAME = "tbe_plugin_options";
define("TBE_PLUGIN_DIR", dirname(__FILE__));

if(is_admin()) {
	require_once TBE_PLUGIN_DIR."/settings-page.php";
	require_once TBE_PLUGIN_DIR."/functions.php";
}

function tbe_get_current_theme_textdomain(): string {
	$td = (string)wp_get_theme()->get("TextDomain");

	return $td ?: "default";
}

function tbe_get_translations(): array {
	static $translations = null;

	if($translations === null) {
		$translations = get_option(TBE_OPTIONS_NAME);

		if(!is_array($translations)) {
			$translations = [];
		}
	}

	return $translations;
}

add_filter("gettext_with_context_".tbe_get_current_theme_textdomain(), function ($translation, $text, $context, $domain) {
	if($translation === $text && $context === $domain) {
		if($context === tbe_get_current_theme_textdomain()) {
			$translated = nl2br(tbe_get_translations()[$text]);

			return $translated;
		}
	}

	return $translation;
}, 10, 4);