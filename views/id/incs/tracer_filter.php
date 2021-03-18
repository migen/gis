<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<th>ID</th>
	<th>Code</th>
</tr>


<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="code<?php echo $i; ?>" class="full" name="posts[<?php echo $i; ?>]" /></td>				
</tr>
<?php endfor; ?>			

</table>


<p>
	<input type="submit" name="submit" value="Submit"  />
</p>

</form>

<p><?php $this->shovel('numrows'); ?></p>


<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="code" >Code</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>

