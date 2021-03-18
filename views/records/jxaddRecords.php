<h5>
	<?php 
		
	?>
	Add <?php echo $table; ?> | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<?php

// pr($data);

?>
<?php

pr($dbtable);

$kvpair="";
$kvfields="";
foreach($columns AS $k=>$key){
	$kvpair.="\"&$key=\"+".$key."+";
	$kvfields.=$key.",";	
}	/* foreach */
$kvpair=rtrim($kvpair,"+");
$kvfields=rtrim($kvfields,",");

?>


<form id="form" method="POST" >
<table class="gis-table-bordered" >

<?php foreach($columns AS $k=>$key): ?>
<tr><th><?php echo $key; ?></th>
	<td><input id="<?php echo $key; ?>" name="post[<?php echo $key; ?>]" /></td></tr>
<?php endforeach; ?>
<tr><td colspan=2 ><button onclick="xsaveData();return false;" >JX Save</button></td></tr>
</table>
</form>

<div class="ht50 clear" >&nbsp;</div>


<table class="gis-table-bordered" >
<tr><th>ID</th>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<th><?php echo $columns[$j]; ?></th>
	<?php endfor; ?>
</tr>
<?php foreach($rows AS $row): ?>
	<tr><td><?php echo $row['id']; ?></td>	
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<?php $key=$columns[$j]; ?>
		<td><?php echo $row[$key]; ?></td>
	<?php endfor; ?>	
	</tr>
<?php endforeach; ?>
</table>

<script>
var gurl = "http://<?php echo GURL; ?>";
var dbtable = "<?php echo $dbtable; ?>";
var kvpair='<?php echo $kvpair; ?>';
var kvfields='<?php echo $kvfields; ?>';
var varStr="";

$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function varBuilder(value,index,array){
	varStr=varStr+"var "+value+"=$('#"+value+"').val();";	
}	/* fxn */

function xsaveData(){
	var url=gurl+"/ajax/xdata.php";
	var task="xsaveData";
	
	var res=kvfields.split(',');	
	res.forEach(varBuilder);	
	eval(varStr);

	kvpair=eval(kvpair);
	var pdata="task="+task+"&dbtable="+dbtable+kvpair;
	
	$.ajax({
		url:url,type:"POST",data:pdata,
		success:(function(){
			var form=document.querySelector('#form');
			form.reset();		
		})	/* success */	
	})	/* ajax */
	
}	/* fxn */



</script>
<script type="text/javascript" src='<?php echo URL."views/js/data.js"; ?>' ></script>

