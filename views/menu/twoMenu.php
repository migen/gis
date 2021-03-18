<style>





/* Small devices (portrait tablets and large phones, 600px and upto 992) */
@media only screen and (max-width: 992px) {
	
	 colsbox{ width:100%;height:1150px;border:1px solid;overflow:scroll; }
	.col{ float:left;border:1px solid red;width:45%;color:red;font-size:2em;  }
	
}


/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
	 colsbox{ width:100%;height:1150px;border:1px solid;overflow:scroll; }
	.col{ float:left;border:1px solid red;width:20%;color:blue;font-size:1.2em;  }
	
	
}


</style>

<h3>
	
	Menu-<?php echo $axn; ?>

</h3>

<div class="colsbox" ><?php 

?>
<?php foreach($cols AS $col): ?>
	<div class="col" ><?php pr($col); ?></div>
<?php endforeach; ?>

</div>

<div >


</div>	<!-- main -->
