<h5>ABC Index</h5>

<?php

$conduct=98;

$tardy=8;


// function adjustConduct($conduct,$tardy,$major_a=NULL,$major_b=NULL,$minor=NULL){
function adjustConduct($conduct,$tardy){
	switch($tardy){
		case $tardy >6: $conduct-=3;break;
		case $tardy > 4: $conduct-=2;break;
		default: $conduct-=10;
	}
	return $conduct;
}

if(isset($_POST['submit'])){
	$conduct=$_POST['conduct'];
	$tardy=$_POST['tardy'];
	$x=adjustConduct($conduct,$tardy);
	echo "conduct: $conduct <br />";
	echo "tardy: $tardy <br />";
	echo "results: $x <br />";
	
}	/* post */



?>


<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Conduct</th><td><input name="conduct" value="100" ></td></tr>
<tr><th>Tardy</th><td><input name="tardy" value="" autofocus ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="submit"  /></th></tr>

</table>
</form>




