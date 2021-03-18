<?php 

$today = date('Y-m-d',time());


?>

<div class="left half"><table class="gis-table-bordered table-fx" >
<tr><th>Alias</th><td><input class="vc300" name='wp[alias]' value="<?php echo isset($wp['alias'])? $wp['alias']:null; ?>" /></td></tr>
<tr><th>Title</th><td><input class="vc300" name='wp[name]' value="<?php echo isset($wp['name'])? $wp['name']:null; ?>" /></td></tr>
<tr><th>Tags</th><td><input class="vc300" name='wp[keywords]' value="<?php echo isset($wp['keywords'])? $wp['keywords']:null; ?>" /></td></tr>
</table>
</div><div class="left half"><table class="gis-table-bordered table-fx" ><tr><th>Active</th><td><select class="vc100" name='wp[is_active]'  >	<option value="1" <?php echo (isset($wp['is_active']) && ($wp['is_active']==1))? 'selected':NULL; ?>  >Active</option>	<option value="0" <?php echo (isset($wp['is_active']) && ($wp['is_active']==0))? 'selected':NULL; ?>  >Inactive</option></select></td></tr><tr><th>Public</th><td><select class="vc100" name='wp[is_public]'  >	<option value="1" <?php echo (isset($wp['is_public']) && ($wp['is_public']==1))? 'selected':NULL; ?>  >Public</option>	<option value="0" <?php echo (isset($wp['is_public']) && ($wp['is_public']==0))? 'selected':NULL; ?>  >Private</option></select></td></tr><tr><th>Indexed</th><td><select class="vc100" name='wp[is_indexed]'  >	<option value="1" <?php echo (isset($wp['is_indexed']) && ($wp['is_indexed']==1))? 'selected':NULL; ?>  >Indexed</option>	<option value="0" <?php echo (isset($wp['is_indexed']) && ($wp['is_indexed']==0))? 'selected':NULL; ?>  >Not Indexed</option></select></td></tr><tr><th>Hidden</th><td><select class="vc100" name='wp[is_hidden]'  >	<option value="0" <?php echo (isset($wp['is_hidden']) && ($wp['is_hidden']==0))? 'selected':NULL; ?>  >Displayed</option>	<option value="1" <?php echo (isset($wp['is_hidden']) && ($wp['is_hidden']==1))? 'selected':NULL; ?>  >Hidden</option></select></td></tr><tr><th>Secret</th><td><input class="vc300" name='wp[hdpass]' value="<?php echo isset($wp['hdpass'])? $wp['hdpass']:null; ?>" /></td></tr></table></div>

<p><textarea name='wp[body]'  rows="16" cols="120" ><?php echo isset($wp['body'])? $wp['body']:'Note here'; ?></textarea></td></tr></p>

<!------------------------------------------------------------------------->

<input type='hidden' name='wp[id]' value="<?php echo isset($wp['id'])? $wp['id']:null; ?>"/>
<input type='hidden' name='wp[created]' value="<?php echo isset($wp['created'])? $wp['created']: $today; ?>"/>
<input type='hidden' name='wp[modified]' value="<?php echo $today; ?>"/>
<input type='hidden' name='wp[contact_id]' value="<?php echo $_SESSION['user']['ucid']; ?>">	
