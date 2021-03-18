<h5>
	Add PO
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'purchases/filterPO'; ?>" >Filter</a>

<?php 
	// pr($suppliers);
?>
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
	<input type="hidden" name="po[ecid]" value="<?php echo $_SESSION['ucid']; ?>" />
	<input type="hidden" name="po[terminal]" value="1" />
<tr>
	<th>Date | Supp</th>
	<td>
		<input type="date" name="po[date]" value="<?php echo $_SESSION['today']; ?>"  />
		<input class="vc50" id="suppid" name="po[suppid]" value="0"  />		
	</td>
</tr>


<tr>
	<th>Supplier</th>
	<td>
		<input id="suppname" name="po[suppname]" hidden />
		<select class="vc200" onchange="getSuppid(this.value);return false;" id="supplier" >
			<option value="0" >Choose</option>
			<?php foreach($suppliers AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
			<?php endforeach; ?>
		</select><br />
		<input class="vc200" id="part" autofocus />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" />
	</td>
</tr>

</table>
<p class="brown" >*Can either Select or Filter supplier.</p>


<p>
<input type="submit" name="submit" value="Add PO" onclick="return confirm('Sure?');" />
</p>
</form>


<div class="hd" id="names" ></div>

<script>
var gurl = 'http://<?php echo GURL; ?>';

$(function(){
	hd();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){  $('#suppid').val(ucid);   }


function getSuppid(ucid) { 
	$('#suppid').val(ucid); 
	var e = document.getElementById("supplier");
	var suppval = e.options[e.selectedIndex].text;
	$('#suppname').val(suppval);

}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>