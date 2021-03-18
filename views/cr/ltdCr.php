<h5>
	Edit Classroom 
	| <?php $this->shovel('homelinks'); ?>
	| <a onclick="getName();" class="txt-blue underline" >Get</a>
	| <a href="<?php echo URL.'cr/edit/'.$crid; ?>" >Edit</a>
	| <a href="<?php echo URL.'cr/view/'.$crid; ?>" >View</a>
	
</h5>

<?php 
// pr($classroom);

?>



<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr class="<?php echo ($is_active==0)? 'bg-pink':NULL; ?>"  ><th class="vc100" >Name</th><td class="vc200" >
<input class="pdl05 full" id="name" type="text" name="name" value="<?php echo $classroom['classroom']; ?>"  /></td></tr>

<tr class="<?php echo ($is_active==0)? 'bg-pink':NULL; ?>"  ><th class="vc100" >Label</th><td class="vc200" >
<input class="pdl05 full" type="text" name="label" value="<?php echo $classroom['label']; ?>"  /></td></tr>

<tr><th>Level</th><td>
<select name="level_id" class="full"  >
<?php foreach($levels AS $sel): ?>
  <option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$classroom['level_id'])? 'selected':NULL; ?>  ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Section</th><td>
<select name="section_id" class="full"  >
<?php foreach($sections AS $sel): ?>
  <option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$classroom['section_id'])? 'selected':NULL; ?>  ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Major</th><td>
<select name="major_id" class="full"  >
	<option value=0 >None</option>
<?php foreach($majors AS $sel): ?>
  <option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$classroom['major_id'])? 'selected':NULL; ?>  ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>


<tr class="<?php echo ($is_active==0)? 'bg-pink':NULL; ?>" >
<th>Status</th>
<td>
<select name="is_active" class="full" >
<option value="1" <?php echo ($is_active==1)? 'selected':NULL; ?> >Active</option>
<option value="0" <?php echo ($is_active==0)? 'selected':NULL; ?> >NOT Active</option>
</select>
</td>
</tr>

<tr class="<?php echo ($is_active==0)? 'bg-pink':NULL; ?>" >
<th>Adviser <br />#<input id="acid" class="tcid pdl05 vc50" name="acid" value="<?php echo $classroom['acid']; ?>"  /></th>
<td>
	<?php $adviser = $classroom['adviser']; ?>	
	<input class="vc100 pdl05 vc200" id="part" value="<?php echo $adviser; ?>" /><br />	
	<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />			
</td>
</tr>

<tr><th class="vc100" >Num</th><td class="vc200" >
<input class="pdl05 full" type="text" name="num" value="<?php echo $classroom['num']; ?>"  /></td></tr>


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

function getName(){
	var name="<?php echo $classroom['lvlcode'].'-'.$classroom['section']?>";
	$('#name').val(name);
}

function redirContact(ucid){ $('#acid').val(ucid); }	/* fxn */

</script>



<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>


