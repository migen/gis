
<?php 

// pr($_SESSION['q']);

?>





<h5>
	
	<span class="u" onclick="tracehd();" >Dashboard Stats</span> SY <?php echo $sy; ?>
	| <a href="<?php echo URL.'mis/index/'.$sy; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'setup/grading/'.$sy; ?>" > Setup </a>	
	| <a href="<?php echo URL.'dashboard/syncs/'.$sy; ?>" >Syncs</a>	
	| <a href="<?php echo URL.'dashboard/mis/'.$sy; ?>" >MIS Dash</a>	
	| <a href="<?php echo URL.'locking/controls/'.$sy; ?>" >Locking</a>	
	
</h5>


<table class="gis-table-bordered table-fx table-altrow" >
<tr>
<th>#</th>
<th>Name</th>
<th>Value</th>
<th>Updated</th>
<th class="hd" >Url-Task</th>
<th>Action</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<?php $name=str_replace('_',' ',$rows[$i]['name']); $name=ucfirst($name); ?>	
	<td><?php echo $name; ?></td>
	<td id="" ><input id="val-<?=$i; ?>" class="vc50" value="<?=$rows[$i]['value']; ?>"  /></td>
	<td><?php echo $rows[$i]['updated']; ?></td>
<td class="hd" >	
	<input type="" value="<?php echo $rows[$i]['name']; ?>" id="name-<?=$i; ?>" />
	<input type="" value="<?php echo $rows[$i]['url']; ?>" id="vurl-<?=$i; ?>" />
	<input type="" value="<?php echo $rows[$i]['task']; ?>" id="task-<?=$i; ?>" />
</td>	
	<td><a id="btn-<?=$i; ?>" class="u" onclick="sync(<?=$i;?>);return false;" >Sync</a></td>
</tr>
<?php endfor; ?>

</table>


<script>

var gurl="http://<?php echo GURL; ?>";
var sy="<?php echo $sy; ?>";

$(function(){
	hd();
})


function sync(i){
	$('#btn-'+i).hide();
	var vurl=gurl+'/'+$('#vurl-'+i).val()+'.php';
	var task=$('#task-'+i).val();
	var name=$('#name-'+i).val();
	var pdata='task='+task+'&sy='+sy+'&name='+name;	
	$.ajax({	  
		url: vurl,dataType: "json",type: 'POST',async: true,data: pdata,
		success:function(s){ $('#val-'+i).val(s.numrows); } 
	});				
		
}	/* fxn */



</script>

