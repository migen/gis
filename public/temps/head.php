<html><head>
<script type='text/javascript' src="<?php echo URL; ?>public/js/jquery.js"></script>

<?php 
	if(isset($this->js)){
 		foreach($this->js as $js){
			echo '<script type="text/javascript" src="'.URL."public/js/".$js.'"></script>';
		}
	}
?>


</head><body>


<div id="main">


