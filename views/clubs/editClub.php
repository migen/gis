<h5>
	Edit Club
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/all'; ?>" >All</a>
	
</h5>

<?php 


?>



<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th class="vc100" >Code</th><td class="vc200" >
<input class="pdl05 full" id="code" type="text" name="code" value="<?php echo $row['code']; ?>"  /></td></tr>

<tr><th class="vc100" >Name</th><td class="vc200" >
<input class="pdl05 full" id="name" type="text" name="name" value="<?php echo $row['name']; ?>"  /></td></tr>

<tr><th>Teacher <br />#<input id="tcid" class="tcid pdl05 vc50" name="tcid" value="<?php echo $row['tcid']; ?>"  /></th>
<td>
	<?php $teacher = $row['teacher']; ?>	
	<input class="vc100 pdl05 vc200" id="part" value="<?php echo $teacher; ?>" /><br />	
	<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />			
</td>
</tr>



</table>

<p><input onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Save"   /></p>
</form>


<div id="names" ></div>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var limits='20';

$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	

function redirContact(ucid){ $('#tcid').val(ucid); }	/* fxn */

</script>



<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>


