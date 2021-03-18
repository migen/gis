<h5>
	Attendance Employees Index


</h5>



<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>ID</th>
	<th>Employee</th>
	<th>&nbsp;</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $employees[$i]['ecid']; ?></td>
	<td><?php echo $employees[$i]['employee']; ?></td>
	<td>
		<select onchange="gotoAttendanceLogs(this.value,<?php echo $employees[$i]['ecid']; ?>);" >
			<?php foreach($months AS $sel): ?>
				<option value="<?php echo $sel['index']; ?>" ><?php echo $sel['name']; ?></option>				
			<?php endforeach; ?>
		</select>
	</td>
	<td>
		<?php foreach($mq AS $row): ?>
			<a href='<?php echo URL."attdlogs/person/$sy/".$row['id']."/".$employees[$i]['ecid']; ?>' >
				<?php echo ucfirst($row['code']); ?></a> &nbsp; 
		<?php endforeach; ?>
	</td>
</tr>
<?php endfor; ?>
</table>


<!---------------------------------------------------------------------->

<script>


var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';

$(function(){

})


function gotoAttendanceLogs(month,ecid){
	var url = gurl+'/attdlogs/person/'+sy+'/'+month+'/'+ecid;
	window.location = url;			
}




</script>