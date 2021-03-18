<?php

	
	$a=$last_studcode;
	$b=explode("-",$last_studcode);
	$c=reset($b);
	$d=end($b);	
	$numchars=5;	
	if($c==$sy){
		$e=$d+1;
	} else {
		$e=1;		
	}
	$f=sprintf('%05d',$e);			
	$g=$sy.'-'.$f;
	$next_studcode=$g;
	// pr("$last_studcode: $a");
	// pr("next_studcode: $next_studcode");
	$init_birthdate="2010-12-25";
	
	$dbo=PDBO;
	$dbcontacts="{$dbo}.00_contacts";

?>

<h3>
	Register New Student | <?php $this->shovel('homelinks'); ?>
	
</h3>



<div class="third" >

<span class="brown" >*Check to avoid duplicates.</span><br />

<table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="id / name" />
		<input type="submit" name="auto" value="Check" onclick='getDataByTable(dbcontacts,30);return false;' />	
	</td></tr>
</table><br />


<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th colspan=2 >New Student Information</th>
</tr>
<tr>
	<th>ID No.</th>
	<td><input name="contact[code]" value="<?php echo $next_studcode; ?>"  ></td>
</tr>

<tr>
	<th>Last name</th>
	<td><input name="profile[last_name]" placeholder="Last name"  ></td>
</tr>
<tr>
	<th>First name</th>
	<td><input name="profile[first_name]" placeholder="First name"  ></td>
</tr>
<tr>
	<th>Middle name</th>
	<td><input name="profile[middle_name]" placeholder="Middle name"  ></td>
</tr>

<tr>
	<th>Birth date</th>
	<td><input type="date" name="profile[birthdate]" placeholder="Birth date"  value="<?php echo $init_birthdate; ?>" ></td>
</tr>


<tr>
	<th>Gender</th>
	<td>
		<select name="contact[is_male]" >
			<option value="1" >Boy</option>
			<option value="0" >Girl</option>
		</select>
	</td>
</tr>

<tr>
	<th colspan=2><input type="submit" name="submit" value="Register" ></th>
</tr>


</table>
</form>
</div>	<!-- half registration form -->

<div id="names" >names</div>


<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	selectFocused();
	nextViaEnter();
	
	
})	/* fxn */




function axnFilter(id){
	// var url=gurl+"/tests/encrid/"+id+"/"+sy;
	alert("Student has been registered.");

}	/* fxn */






</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

