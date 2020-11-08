<?php

$a = [0=>['id' => 1],1=>['id'=>2]];

$b=array_filter($a,function($r){
	return $r['id'] != 1;
});

print_r($b);