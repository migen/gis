<table class="gis-table-bordered" >

<tr>
<td>Cutoff <input class="pdl05" type="date" id="cutoff" value="<?php echo $cutoff; ?>"  /></td>
<td>
<select id="paymode" >
<option value="0">Paymode</option>
<?php foreach($paymodes AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" 
		<?php echo (isset($_GET['paymode']) && ($_GET['paymode']==$sel['id']))? 'selected':NULL ?>
	><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td>

<td>
<select id="sxn" >
<option value="0">Section</option>
<?php foreach($sections AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" 
		<?php echo (isset($_GET['sxn']) && ($_GET['sxn']==$sel['id']))? 'selected':NULL ?>	
	><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td>

<td>
<select id="sy" >	
<?php $sy1=DBYR-1;if($sy1>=$_SESSION['settings']['sy_beg']): ?>
	<option value="<?php echo $sy1; ?>" <?php echo ($sy==$sy1)? 'selected':NULL; ?> ><?php echo $sy1 ; ?></option>
<?php endif; ?>
	<option value="<?php echo DBYR; ?>" <?php echo ($sy==DBYR)? 'selected':NULL; ?> ><?php echo DBYR; ?></option>	
<?php $sy2=DBYR+1;if($sy2<=$_SESSION['settings']['sy_end']): ?>
	<option value="<?php echo $sy2; ?>" <?php echo ($sy==$sy2)? 'selected':NULL; ?> ><?php echo $sy2 ; ?></option>
<?php endif; ?>	
</select>	
</td>

<td><input type="submit" onclick="gotoUrl();" value="Filter" /></td>
</tr>
</table>

<script>


function gotoUrl(){
	var DS='/';
	var cutoff=$('#cutoff').val();
	var paymode=$('#paymode').val();
	var sxn=$('#sxn').val();
	var sy=$('#sy').val();
	var lvl="<?php echo $level_id; ?>";
	var url = gurl+"/balances/level/"+lvl+DS+sy+"?paymode="+paymode+"&sxn="+sxn+"&cutoff="+cutoff;
	window.location=url;
}

</script>
