<?php 

$ssg = $_SESSION['settings'];

$spacing = 12;

?>


<style>
#pleft{
	width:20%;
	float:left;
	padding-top:30px;
	text-align:left;
	padding-left:10px; 

}

#pcenter{
	width:50%;
	float:left;
	margin:10px;
	min-height:100px;
}

#pright{
	width:20%;
	font-size:14px;
	float:left;
	margin-top:20px;
	padding-right:20px;

}



#pdetails{
	width:100%;
	float:left;
	min-height:20px;
	border:1px solid white;
	text-align:left;
	padding-left:10px; 
	
}

#pclassroom{
	color:brown;
	position:relative;
	height:20px;
	border:1px solid green;
	text-align:right;
	padding-right:100px; 


}


</style>

<?php 



?>


<div class="center" >

<div id="pleft" class="b" ><span class="b" >DepEd</span> Form 18-E-1</div>

<!---------------------------------------------------------------------------------------------------->


<!---------------------------------------------------------------------------------------------------->

<div id="pcenter" >
	<h2 class="f24" >REPUBLIC OF THE PHILIPPINES
		<br />DEPARTMENT OF EDUCATION</h2>
		<h1 class="f26" >REPORT ON PROMOTION<br />		
		<span class="ub f20" >(GRADES I-III INCLUSIVE)</span>		
	</h2>
	
	<p class="f18" >SCHOOL YEAR 
		<input class="f18 vc60 center unbordered" value="<?php echo $_SESSION['sy']; ?>" /> - 
		<input class="f18 vc60 center unbordered" value="<?php echo ($_SESSION['sy']+1); ?>" />
	
		
	</p>

</div>	

<!---------------------------------------------------------------------------------------------------->

<div id="pright" class="bordered" style="padding:10px 10px 30px 10px;margin-top:50px;"   >
<span class="" >
	Due the day after the last day prescribed for regular classes
</span>
</div>


<!---------------------------------------------------------------------------------------------------->



</div>	<!-- center -->


<div id="pdetails" class="" >
	<table class="no-gis-table-bordered full"  >
		<tr>
			<td><b>Division:</b> <?php spacer(2); ?> <input class="vc150 unbordered" value="<?php echo $ssg['school_division']; ?>" /></td>
			<td><b>LEVEL</b></td>
			<td><b>Date:</b><?php spacer(5); ?> <input class="vc150 unbordered" value="<?php echo $_SESSION['today']; ?>" /></td>
		</tr>

		<tr>
			<td><b>School:</b><?php spacer(4); ?> <input class="vc250 unbordered" value="<?php echo $ssg['school_name']; ?>" /></td>
			<td><input class="vc100 unbordered" value="<?php echo $classroom['level']; ?>" /></td>
			<td><b>Teacher:</b><?php spacer(0); ?> <input class="vc200 unbordered" value="<?php echo $classroom['adviser']; ?>" /></td>
		</tr>
	</table>
</div>	<!-- pdetails -->



<div class="clear" >&nbsp;</div>
