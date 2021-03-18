<form method="POST" >


MS 
<select name="levels[]" multiple >

<?php foreach($levels AS $sel): ?>
<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>

<input type="submit" name="submit" value="Submit"  />

</form>