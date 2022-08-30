<?php

function tbe_make_label_from_key($key): string {
	$key = ucfirst($key);

	$key = str_replace("_", " ", $key);

	return $key;
}