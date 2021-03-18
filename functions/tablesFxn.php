<?php

function tableRow($rows,$field){
	echo "<table><tr>";
		foreach($rows AS $row){ echo "<td style='border:1px solid black;' >{$row[$field]}</td>"; }	
	echo "</tr></table>";
}	/* fxn */


