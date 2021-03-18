<h5>
	Edit Classroom Adviser
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'classrooms/all'; ?>" >Classrooms</a>

</h5>


<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><td><?php echo $row['crid']; ?></td></tr>
<tr><th>Classroom #<?php echo $row['crid']; ?></th><td><?php echo $row['classroom']; ?></td></tr>
<tr><th>Adviser</th>
<td>
	<input class="pdl05 vc300" id="part" value="<?php echo $row['adviser']; ?>"  />
	<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
</td></tr>
<tr><th>ACID</th><td><input class="vc70 pdl05" id="acid" name="post[acid]" value="<?php echo $row['acid']; ?>" /></td></tr>


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


function redirContact(ucid){ $('#acid').val(ucid); }



</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
