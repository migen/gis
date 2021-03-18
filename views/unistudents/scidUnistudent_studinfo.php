
<style>

.hp{ border:1px solid white;float:left;width:30%; }

</style>

<div class="hp" > 
<table class="gis-table-bordered" >
<tr class="<?php echo ($student['is_active']!=1)? 'red':NULL; ?>" >
<td>Student | <a href="<?php echo URL.'unistudents/edit/'.$scid; ?>" >Edit</a></td>
<td><?php echo $student['name']; ?></td></tr>
<tr><td>Education R<?php echo $student['role_id']; ?></td><td><?php echo ($student['role_id']==8)? "College":"Basic"; ?></td></tr>

</table>
</div>

<div class="hp" > 

</div>

<div class="clear" ></div>
<br />
