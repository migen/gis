<?php

$data['qtr']=$qtr=isset($params[0])?$params[0]:$_SESSION['qtr'];
$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;
$data['current']=$current=($sy==DBYR)?true:false;
$dbg = VCPREFIX.$sy.US.DBG;
$data['home']=$home=$_SESSION['home'];
