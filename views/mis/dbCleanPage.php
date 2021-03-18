<h5>DB Clean Page

</h5>



<form method="POST" >

<table class="gis-table-bordered table-fx" >
<tr><th>Main DB</th><td><input class="pdl05" name="dbone" value="<?php echo DBO; ?>" /></td></tr>
<tr><th>Rship DB</th><td><input class="pdl05" name="dbtwo" value="<?php echo DBO; ?>" /></td></tr>
<tr><th>Main Table</th><td><input class="pdl05" name="main" value="<?php echo 'contacts'; ?>" /></td></tr>
<tr><th>Rship Table</th><td><input class="pdl05" name="rship" value="<?php echo 'profiles'; ?>" /></td></tr>
<tr><th>Key</th><td><input class="pdl05" name="key" value="<?php echo 'contact_id'; ?>" /></td></tr>
</table>

<p><input type="submit" name="submit" value="Submit"  /></p>
</form>