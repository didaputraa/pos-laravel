<?php
$map = [
	'public/src/beranda.js',
	'public/src/app.js',
];



$str = '';
foreach($map as $row){
	$str .= file_get_contents($row);
}

$o=fopen('public/src/bundle.js','w');
fwrite($o,$str);
fclose($o);