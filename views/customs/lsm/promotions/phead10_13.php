<?php 

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
	height:100px;
}

#pright{
	width:20%;
	font-size:14px;
	float:left;
	margin-top:60px;
	padding-right:80px;

}



#pdetails{
	float:left;
	height:20px;
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


<div class="<?php echo $phead_align; ?>" >

<div id="pleft" ><span class="" >DepEd</span> Form 18-E-2</div>

<!---------------------------------------------------------------------------------------------------->


<!---------------------------------------------------------------------------------------------------->

<div id="pcenter" >
	<h2 class="<?php echo $h2; ?>" >REPUBLIC OF THE PHILIPPINES
		<br />DEPARTMENT OF EDUCATION</h2>
		<h1 class="<?php echo $h1; ?>" >REPORT ON SECONDARY PROMOTIONS<br />
	</h2>
</div>	

<!---------------------------------------------------------------------------------------------------->

<div id="pright" >
<span class="" >
	<?php echo $classroom['level']; ?>
	<?php  for($i=0;$i<$spacing;$i++){ echo "&nbsp;"; } ?>
	Section <?php echo $classroom['section']; ?>
</span>
</div>


<!---------------------------------------------------------------------------------------------------->



<div id="pdetails" >
Curriculum: <?php spacer(2); ?> <span class="b" >K12</span> <br />
School: <?php spacer(10); ?><span class="b" ><?php echo $_SESSION['settings']['school_name']; ?></span>
<?php  for($i=0;$i<$spacing;$i++){ echo "&nbsp;"; } ?>
Municipality: <?php spacer(2); ?><span class="b" ><?php echo $_SESSION['settings']['school_city']; ?></span>
<?php  spacer($spacing); ?>
Division: <span class="b" ><?php echo $_SESSION['settings']['school_division']; ?></span>
<?php  spacer($spacing); ?>
Date: <input style="border:none;" class="vc120 center" value="<?php echo date('F d, Y',strtotime($_SESSION['today'])); ?>" />

</div>

</div>

<div class="clear" >&nbsp;</div>
