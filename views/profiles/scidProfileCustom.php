<style>




/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {

	 colsbox{ width:100%;height:1150px;border:1px solid;overflow:scroll; }
	.col{ float:left;border:1px solid red;width:100%;  }
	
	
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
	
	 colsbox{ width:100%;height:1150px;border:1px solid;overflow:scroll; }
	.col{ float:left;border:1px solid red;width:50%;  }
	
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {

	 colsbox{ width:100%;height:1150px;border:1px solid;overflow:scroll; }
	.col{ float:left;border:1px solid red;width:30%;font-size:2em;  }
	
	
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
	 colsbox{ width:100%;height:1150px;border:1px solid;overflow:scroll; }
	.col{ float:left;border:1px solid red;width:20%;  }
	
	
}


</style>

<h3>
	
	Profile

</h3>

<div class="colsbox" ><?php 
// pr($field_str); 
// pr($cols); 

?>
<?php foreach($cols AS $col): ?>
	<div class="col" ><?php pr($col); ?></div>
<?php endforeach; ?>

</div>

<div >


</div>	<!-- main -->
