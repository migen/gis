<?php 

$today = date('Y-m-d',time());


?>

<div class="left half">
<tr><th>Alias</th><td><input class="vc300" name='wp[alias]' value="<?php echo isset($wp['alias'])? $wp['alias']:null; ?>" /></td></tr>
<tr><th>Title</th><td><input class="vc300" name='wp[name]' value="<?php echo isset($wp['name'])? $wp['name']:null; ?>" /></td></tr>
<tr><th>Tags</th><td><input class="vc300" name='wp[keywords]' value="<?php echo isset($wp['keywords'])? $wp['keywords']:null; ?>" /></td></tr>
</table>
</div>

<p><textarea name='wp[body]'  rows="16" cols="120" ><?php echo isset($wp['body'])? $wp['body']:'Note here'; ?></textarea></td></tr></p>

<!------------------------------------------------------------------------->

<input type='hidden' name='wp[id]' value="<?php echo isset($wp['id'])? $wp['id']:null; ?>"/>
<input type='hidden' name='wp[created]' value="<?php echo isset($wp['created'])? $wp['created']: $today; ?>"/>
<input type='hidden' name='wp[modified]' value="<?php echo $today; ?>"/>
<input type='hidden' name='wp[contact_id]' value="<?php echo $_SESSION['user']['ucid']; ?>">	