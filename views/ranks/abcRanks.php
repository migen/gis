<h5>
	Ranks Abc
	
	
</h5>

<?php

$x=array(
	2=>array('toyota','honda'),
	5=>array('dmci','smdc'),
	8=>array('anvaya','pico'),
);


pr($x);

$oldkeys=array_keys($x);

pr($oldkeys);

echo "<hr />";

$i=0;
foreach($x AS $y){
	$x[$i]=$y;
	$ok=$oldkeys[$i];
	// pr($ok);
	unset($x[$ok]);
	$i++;
}

// echo "<hr />";
pr($x);

