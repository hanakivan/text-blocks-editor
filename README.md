## Text Blocks Editor for WordPress

Have you ever needed a way to edit hardcoded texts from a wordpres theme via the WP-ADMIN?
Well, this is the way!

A plugin that allows you to use hardcoded texts and edit them via wp-admin

- works with php >= 7.4
- works with wordpress >= 5.0.0


### How to set it up
1. install the plugin
2. update the theme codebase to use translation keys and put default values into the `data.json`
3. re-save the translation from `WP-ADMIN` / `Settings` / `Text Blocks Editor`

### How to use it in code
- use contextual translations with the current's theme textdomain

Example
```php

$textdomain = "textdomain";

//data.json
{
    foo: "bar"
}

//index.php
_ex("foo", $textdomain, $textdomain);

//or 
echo _x("foo", $textdomain, $textdomain);

```