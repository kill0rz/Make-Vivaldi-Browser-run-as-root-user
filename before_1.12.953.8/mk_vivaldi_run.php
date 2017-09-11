<?php

/*
Makes Vivaldi Browser run on Debian based Linux distributions

Works with versions before 1.12.953.8.

See: https://github.com/kill0rz/Make-Vivaldi-Browser-run-as-root-user
 */

$file = explode("\n", file_get_contents("/usr/bin/vivaldi"));

for ($i = 0; $i < count($file); $i++) {
	if ($file[$i] == 'if [[ -n "$CHROME_USER_DATA_DIR" ]]; then') {
		$startzeile = $i;
	}

	if (isset($startzeile) && $i > $startzeile && $file[$i] == 'fi') {
		$endzeile = $i;
	}
}

if (isset($endzeile) && isset($startzeile)) {
	$file[$endzeile - 1] .= " --user-data-dir --no-sandbox";
	for ($i = $startzeile; $i < $endzeile + 1; $i++) {
		if ($i != $endzeile - 1) {
			unset($file[$i]);
		}
	}

	file_put_contents("/usr/bin/vivaldi", '');
	foreach ($file as $line) {
		file_put_contents("/usr/bin/vivaldi", $line . "\n", FILE_APPEND);
	}
}