<h5>
	Setup Paymodes 
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	| <a href="<?php echo URL.'id/tracer'; ?>">Tracer</a>
	| <a href="<?php echo URL.'setaxis/auxes'; ?>">Setup Auxes</a>
	| <a href="<?php echo URL.'setaxis/payments'; ?>">Setup Payments</a>
	
	
	
</h5>



<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>SCID</th>
	<th>PMID</th>
</tr>


<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td><?php echo $i+1; ?></td>
	<td><input id="scid<?php echo $i; ?>" class="vc60" name="posts[<?php echo $i; ?>][scid]" /></td>				
	<td><input id="pmid<?php echo $i; ?>" class="vc50" name="posts[<?php echo $i; ?>][pmid]" /></td>				
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
	<option value="scid" >SCID</option>
	<option value="pmid" >PMID</option>
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



