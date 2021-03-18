<h5>
	ID Tracer
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	| <a href="<?php echo URL.'id/tracer'; ?>">Tracer</a>
	
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<th>ID</th>
	<th>Code</th>
</tr>
<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<?php if(isset($_POST['submit'])): ?>
<?php echo $rows[$i]['id']; ?>
<?php echo $rows[$i]['code']; ?>
<?php else: ?>
<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="code<?php echo $i; ?>" class="full" name="posts[<?php echo $i; ?>]" /></td>				
</tr>
<?php endif; ?>
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



<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";

$(function(){
	// itago('clipboard');
	

})




</script>



