<style>





/* Small devices (portrait tablets and large phones, 600px and upto 992) */
@media only screen and (max-width: 992px) {
	
	 .divsbox{ width:100%;min-height:550px;border:1px solid;overflow:scroll; }
	.div{ float:left;border:1px solid red;width:45%;color:red;font-size:2em;  }
	
}


/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
	.divsbox{ width:100%;height:1150px;border:1px solid;overflow:scroll; }
	.div{ float:left;border:1px solid red;width:20%;color:blue;font-size:1.0em;  }
	
	
}


</style>

<h3>
	
	Menu-<?php echo $axn; ?>

</h3>

<div class="divsbox" ><?php 

?>
<?php foreach($divs AS $i=>$div): ?>
	<div class="div" >
		<?php pr($i.' - '.$div); ?>
		<?php foreach($items[$i] AS $item): ?>
			<?php pr($item); ?>
		<?php endforeach; ?>
	</div>
<?php endforeach; ?>

</div>

<div >


</div>	<!-- main -->
