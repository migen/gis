<form method='post' >


<tr>
<td><b class='ez'>EZ</b></td>
<td><input id='eztext' type='text' name='data[Txn][0][name]' onkeyup='suggestions(this.value);return false;'  /></td>
<td>
	<input type='submit' name='submit' id='index' value='Search' onclick="subform('txns','Txn',this.id);" />
	<input type='submit' name='submit' id='add' value='Quick Add' onclick="subform('txns','Txn',this.id);" />
	<input type="button" name="cancel" value="Cancel" onclick="location.reload();" />
</td>
<td><input type='button' value='Advanced!' onclick="peekaboo('searchTxn');return false;" ></td></tr>


<?php $suid = Session::get('user_id'); ?>
<input type='hidden' name='data[Txn][0][user_id]' value="<?php echo $suid; ?>" />
<input type='hidden' name='data[Txn][0][date]' value='<?php echo sqlToday(); ?>' />
<input type='hidden' name='data[Txn][0][txntype_id]' value='1' />
<input type='hidden' name='data[Txn][0][tag_id]' value='1' />
<input type='hidden' name='data[Txn][0][status_id]' value='2' />
</form>
