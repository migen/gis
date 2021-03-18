
<?php 

// pr($data);



?>

<style>


</style>

<?php 
	$dbo=PDBO;
	$dbsubjects="{$dbo}.05_subjects";

?>

<h3>
	Batch Update | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."batch/setfield/$dbsubjects/subjtype_id?fields=code"; ?>' >Setfield</a>
	
	
</h3>

<div class="" >
	Fields: 
	<?php foreach($table_fields AS $f): ?>
		<?php echo $f.' | '; ?>
	<?php endforeach; ?>
</div>


<div style="width:80%;float:left;" >	<!-- main form -->

<form method="POST" >	<!-- form add -->

<div class="addrows" style="width:600px;float:left;"  >
<h5> 
	Update <?php echo $dbtable; ?>
	| <a class="u" onclick="pclass('smartboard');" >Smartboard</a>
</h5>
<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th>ID</th>	
	<th>Key<br />
		<input id="ikey" class=''><br />		
		<input type="button" value="All" onclick="populateColumn('key');" >						
	</th>	
	<th>Value</th>	
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="id<?php echo $i; ?>" name="posts[<?php echo $i; ?>][id]" /></td>		
	<td><input id="key<?php echo $i; ?>" class="key" name="posts[<?php echo $i; ?>][key]" /></td>		
	<td><input id="value<?php echo $i; ?>" name="posts[<?php echo $i; ?>][value]" /></td>			
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="update" value="Update" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>


<p><?php $this->shovel('numrows'); ?></p>

</form> <!-- add -->

</div>	<!-- main -->




<div class="" style="width:300px;float:right;"  >
	<p class="smartboard" >
	<select id="classbox" class="vc100"  >
		<option value="id" >ID</option>
		<option value="key" >Key</option>
		<option value="value" >Value</option>
	</select>
	</p>
	<?php 
		$width=isset($_GET['width'])? $_GET['width']:30;
	?>
	<?php $this->shovel('smartboard',$data=array('width'=>$width)); ?>
</div>	<!-- side / smartboard -->






<script>

var gurl = "http://<?php echo GURL; ?>";
var limits='20';

$(function(){
	// itago('smartboard');
	pclass('smartboard');
	nextViaEnter();
	$('html').live('click',function(){ $('#names').hide(); });

})



</script>


