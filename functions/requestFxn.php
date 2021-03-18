<?php


function sages($get){ $strget='?';foreach($get as $k=>$v){ if($k=='url'){continue;} $strget.=$k.'='.$v.'&'; } $strget=rtrim($strget,'&');return $strget; }	

