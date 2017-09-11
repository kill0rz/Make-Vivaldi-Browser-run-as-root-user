<?php

/*
Makes Vivaldi Browser run on Debian based Linux distributions

Works with versions starting from 1.12.953.8.

See: https://github.com/kill0rz/Make-Vivaldi-Browser-run-as-root-user
 */

$file = explode("\n", file_get_contents("/usr/bin/vivaldi"));

for ($i = 0; $i < count($file); $i++) {
	if (trim($file[$i]) == 'exec -a "$0" "$HERE/vivaldi"-bin "$@"') {
		$replacezeile = $i;
	}
}

if (isset($replacezeile)) {
	$file[$replacezeile] .= " --user-data-dir=/root/.config/vivaldi --no-sandbox";

	file_put_contents("/usr/bin/vivaldi", '');
	foreach ($file as $line) {
		file_put_contents("/usr/bin/vivaldi", $line . "\n", FILE_APPEND);
	}
}