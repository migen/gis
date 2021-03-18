<?php 
session_start();
function pr($r){ echo "<pre>"; print_r($r); echo "</pre>";}
pr($_SESSION);

?>