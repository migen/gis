<p>
<?php foreach($levels AS $sel): ?>
<input type="checkbox" name="levels[]" value="<?php echo $sel['id']; ?>" >
<?php echo $sel['code']; ?> &nbsp; 
<?php endforeach; ?>
</p>