<?php 
// $pos_id=isset($pos_id)? $pos_id:NULL;
$pos_id=isset($pos['id'])? $pos['id']:NULL;
// $pos_id=$pos['id'];
?>

<table class="screen gis-table-bordered" >
<tr><th><input name="findorno" class="pdl05" id="orno" placeholder="OR" value="<?php echo $pos_id; ?>" /></th>
<td>
	<button onclick="jsredirect('npos/orno/'+$('#orno').val());" >Or No</button>
	<button onclick="jsredirect('npos/view/'+$('#orno').val());" >ID</button>
</td>
<?php 

?>
<td>Last Orno: <span class="u" onclick="copier(<?php echo $last_orno; ?>,'findorno');" >
	<?php echo $last_orno; ?></span></td>
<td>Last ID: <span class="u" onclick="copier(<?php echo $last_posid; ?>,'findorno');" >
	<?php echo $last_posid; ?></span></td>	
	
</tr>
</table>
