<h5>
	Edit Club Scores
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<p>
<?php 
	require_once(SITE.'/views/elements/filter_codename.php');
?>
</p>


<div class="third" >

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>SCID</th><td><?php echo $row['scid']; ?></td></tr>
<tr><th>ID No.</th><td><?php echo $row['studcode']; ?></td></tr>
<tr><th>Student</th><td><?php echo $row['student']; ?></td></tr>
<tr><th>Qtr</th><td><?php echo $row['qtr']; ?></td></tr>
<tr><th>Peformance</th><td><input name="score[cri1]" id="cri1" value="<?php echo $row['cri1']; ?>" onchange="clubtotal();return false;" /></td></tr>
<tr><th>Attendance</th><td><input name="score[cri2]" id="cri2" value="<?php echo $row['cri2']; ?>" onchange="clubtotal();return false;" /></td></tr>
<tr><th>Behavior</th><td><input name="score[cri3]" id="cri3" value="<?php echo $row['cri3']; ?>" onchange="clubtotal();return false;" /></td></tr>
<tr><th>Total</th><td>
	<input name="score[total]" id="total" value="<?php echo $row['total']; ?>"  >
	<input type="hidden" name="score_id" value="<?php echo $row['score_id']; ?>" />
	<input type="hidden" name="club_id" value="<?php echo $row['club_id']; ?>" />
</td></tr>


<tr class="hd" ><th>Crs</th><td><input name="grade[crs]" value="<?php echo $grade['crs']; ?>" /></td></tr>

</table>


<p><input type="submit" name="submit" value="Save" /></p>


</form>

</div>

<div class="hd" id="names" >names</div>



<script>

var gurl="http://<?php echo GURL; ?>";
var sy="<?php echo $sy; ?>";
var limits=20;

$(function(){
	hd();shd();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){ $('#names').hide(); });

})	


function clubtotal(){
	var total=0;
	var cri1=parseInt($('#cri1').val());
	var cri2=parseInt($('#cri2').val());
	var cri3=parseInt($('#cri3').val());
	total=cri1+cri2+cri3;
	$('#total').val(total);

}	/* fxn */


function redirContact(ucid){
	var url=gurl+'/clubs/editStudentClubscores/'+ucid;	
	window.location = url;		
}


</script>



<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
