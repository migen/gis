<h5>
	Club Moderator
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs'; ?>" >Clubs</a>
	
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><td><?php echo $row['club_id']; ?></td></tr>
<tr><th>Club</th><td><input class="pdl05" name="post[name]" value="<?php echo $row['club']; ?>" ></td></tr>
<tr><th>Moderator</th>
<td>
	<input class="pdl05" id="part" value="<?php echo $row['moderator']; ?>"  />
	<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
</td></tr>
<tr><th>MCID</th><td><input class="vc70 pdl05" id="tcid" name="post[tcid]" value="<?php echo $row['tcid']; ?>" /></td></tr>


<tr><th colspan=2 ><input type="submit" name="submit" value="Save" /></th></tr>
</table>
</table>
</form>



<div id="names" >names</div>

<script>
var gurl = 'http://<?php echo GURL; ?>';
var limits='20';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });

})


function redirContact(ucid){ $('#tcid').val(ucid); }



</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
