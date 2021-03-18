<?php 


?>

<h5 class="screen" >
	Settify 
	| <?php $this->shovel('homelinks'); ?>
	
</h5>


<p>
<table class="gis-table-bordered" >
<tr><th>
<select id="crid" >
	<?php foreach($rows AS $sel): ?>
		<option value="<?php echo $sel['crid']; ?>" ><?php echo $sel['classroom'].' #'.$sel['crid']; ?></option>
	<?php endforeach; ?>
</select>
</th>
<th>Value <input class="vc50 center" id="srcval" value="0" /></th>
<th><button onclick="gotoUrl();" >Settify</button></th>
</tr>


<tr><th colspan=3><a href="<?php echo URL.'zerofy/allGrades'; ?>" 
	onclick="return confirm('Dangerous! Sure?');" >Zerofy All Grades/Scores (All Qtrs) - during Q1 only</a></th></tr>

<tr><th colspan=3><a href="<?php echo URL.'zerofy/truncateClubScores'; ?>" 
	onclick="return confirm('Dangerous! Sure?');" >Truncate Club Scores (All) - during Q1 only</a></th></tr>

		
	
</table>






<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";

$(function(){
	selectFocused();

})

function gotoUrl(){
	var crid=$('#crid').val();
	var val=$('#srcval').val();
	var url=gurl+"/settify/crid/"+crid+'&value='+val;
	window.location=url;			
	
}	/* fxn */


</script>


