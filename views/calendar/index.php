<?php // pr($data);  ?>

<h5>
	<?php $yr = ($moid<$_SESSION['settings']['month_start'])? $sy+1:$sy; ?>

	<?php echo $month.' - '.$yr; ?>
	| <a href="<?php echo URL; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					

	&nbsp; &nbsp; <button><a class="" onclick="includeAll();return false;" >Include All</a></button>
		   &nbsp; <button><a class="" onclick="excludeWeekends();return false;" >Exclude Weekends</a></button>
		   
		   
	<?php if($num_days<5): ?>
		   &nbsp; <button><a class="txt-black no-underline" href='<?php echo URL."mis/syncCalendar"; ?>'  >Sync Calendar</a></button>
	<?php endif; ?>

		   
		   
</h5>



<p>
<select class="vc200" onchange="redirCalendar(this.value);" >
	<option> Calendar </option>
	<?php foreach($months AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</p>


<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th></th>
	<th class="vc100" >Date</th>
	<th>Mo</th>
	<th>D</th>
	<th class="vc80" >Day</th>
	<th>Week<br />End</th>
	<th>Incl<br />Stud</th>
	<th>Incl<br />Empl</th>
</tr>

<?php for($i=0;$i<$num_days;$i++): ?>
<tr class="trow" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $days[$i]['date']; ?></td>
	<td><?php echo date('M',strtotime($days[$i]['date'])); ?></td>	
	<td id="<?php echo $days[$i]['id']; ?>" ondblclick="alert(this.id);" ><?php echo date('d',strtotime($days[$i]['date'])); ?></td>
	<td><?php $day = date('D',strtotime($days[$i]['date'])); echo $day; ?></td>
	
	<?php $weekend = (($day=='Sat') || ($day=='Sun'))? true:false;  ?>
	<td class="center ">
		<?php echo ($weekend)? 'Y':'-'; ?>
		
		<input class="wkend" type="hidden" value="<?php echo ($weekend)? '1':'0'; ?>" />

	</td>
	
	<?php $incs  	= ($days[$i]['is_included']==1)? true:false; ?>
	<?php $ince 	= ($days[$i]['is_included_employees']==1)? true:false; ?>
	<td>
		<select class="incs" name="days[<?php echo $i; ?>][is_included]" >
			<option value="1" <?php echo ($incs)? 'selected':NULL; ?> >Y</option>
			<option value="0" <?php echo (!$incs)? 'selected':NULL; ?> >-</option>
		</select>	
	</td>
	<td>
		<select class="ince" name="days[<?php echo $i; ?>][is_included_employees]" >
			<option value="1" <?php echo ($ince)? 'selected':NULL; ?> >Y</option>
			<option value="0" <?php echo (!$ince)? 'selected':NULL; ?> >-</option>
		</select>
	</td>	
	
</tr>

<input type="hidden" name="days[<?php echo $i; ?>][id]" value="<?php echo $days[$i]['id']; ?>"   />

<?php endfor; ?>
</table>

<p><input onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Save"  /></p>


</form>



<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy 	 = '<?php echo $sy; ?>';

$(function(){
	
})

	
function redirCalendar(moid){
	var rurl 	= gurl + '/mis/calendar/'+sy+'/'+moid;			
	window.location = rurl;		
}

function excludeWeekends(){
	var x = '';
	$('.trow').each(function(){
		var i = this.rowIndex;
		if($('.wkend').eq(i).val()=='1'){
			$('.incs').eq(i).val('0');
			$('.ince').eq(i).val('0');
		}
	
	});
	
}	

function includeAll(){
	$('.incs').val('1');
	$('.ince').val('1');
}
		
	
</script>