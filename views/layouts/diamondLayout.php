<style>

#content div {  min-height:100px; padding:2em; border:1px solid black; 	 }

div.page{ width:60%; border: 1px solid white; float:left; }

.nav { float:left; width:20%; margin:2em; border: 1px solid black; margin:auto; height:100px;  } 

.row{ text-align:center; }

a:link {margin:auto; text-decoration:none; font-size:1.2em; }

.side{ float:right;min-height:200px; border:1px solid black; width:5%; }

.accordion{ z-index:2; }
.accordion tr:nth-child(odd) { background:#f9f9f9; }
.accordion tr:nth-child(even) { background:white; }

/* 
	https://www.w3schools.com/css/tryit.asp?filename=tryresponsive_breakpoints 
	for desktop
 */
.col-1 {width: 8.33%;}
.col-2 {width: 16.66%;}
.col-3 {width: 25%;}
.col-4 {width: 33.33%;}
.col-5 {width: 41.66%;}
.col-6 {width: 50%;}
.col-7 {width: 58.33%;}
.col-8 {width: 66.66%;}
.col-9 {width: 75%;}
.col-10 {width: 83.33%;}
.col-11 {width: 91.66%;}
.col-12 {width: 100%;}

@media only screen and (max-width: 768px) {
  /* For mobile phones: */
  [class*="col-"] {
    width: 100%;
  }
}

</style>

<h3>
	Enrollment


</h3>

<div class="page" >

<div class="first_row clear row" >
	
	<div class="nav col-3" >	
		<table class="accordion menu gis-table-bordered table-altrow" >
			<tr><th class="accorHeadrow" onclick="accordionTable('menu');" >Tree Setup</th></tr>
			<tr><td class="" ><a href="<?php echo URL.'setup/gis'; ?>" >GIS Setup</a></td></tr>
			<tr><td class="" ><a href="<?php echo URL.'setup/gis'; ?>" >Two</a></td></tr>
			<tr><td class="" ><a href="<?php echo URL.'setup/gis'; ?>" >Three</a></td></tr>
			<tr><td class="" ><a href="<?php echo URL.'setup/gis'; ?>" >Four</a></td></tr>
			<tr><td class="" ><a href="<?php echo URL.'setup/gis'; ?>" >Five</a></td></tr>
		</table>	

	</div>
	<div class="nav col-3" ><a class="center" href="#" >Registration</a></div>
	<div class="nav col-3" ><a href="#" >RFID</a></div>

</div>

<div class="second_row clear row" >	
	<div class="nav col-3" ><a href="#" >Levels</a></div>
	<div class="nav col-3" ><a href="#" >Enrollment</a></div>
	<div class="nav col-3" ><a href="#" >Teachers</a></div>
</div>

<div class="third_row clear row" >	
	<div class="nav col-3" ><a href="#" >Advising</a></div>
	<div class="nav col-3" ><a href="#" >Attendance</a></div>
</div>


</div>	<!-- page -->

<div class="side" >

</div>	<!-- side -->


<script>


$(function(){
	
	// $("."+cls+" td").hide();
	$(".accordion td").hide();
	
})


</script>