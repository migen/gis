<h5>
	Settings | 
	<?php 	$controller = $_SESSION['home']; $this->shovel('homelinks',$controller); ?>
	<?php 	
		$d['sy']=$sy;$d['repage']="settings/all";
		$d['params']=NULL;
		$this->shovel('sy_selector',$d); 
	?>

	
</h5>


<?php 


$rows = $data['settings'];


$count = count($rows);
?>

<p><?php $this->shovel('hdpdiv'); ?></p>


<span class="hd" > <?php echo $this->shovel('adder'); ?> </span>

<table class='table-fx gis-table-bordered'>
<thead>
<tr class='headrow'>
	<th>#</th>
	<th>ID</th>
	<th>Setting</th>
	<th>Key</th>
	<th>Value</th>
	<th>Edit</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['id']; ?></td>
		<td><input id="label-<?php echo $i; ?>" class="pdl05 vc300" type="text" value="<?php echo $rows[$i]['label']; ?>" /></td>		
		<td><?php echo $rows[$i]['name']; ?></td>
		<td><input id="value-<?php echo $i; ?>" class="pdl05" type="text" value="<?php echo $rows[$i]['value']; ?>" /></td>
		<input type="hidden" id="name-<?php echo $i; ?>" value="<?php echo $rows[$i]['name']; ?>" />	

<td> 
	<button id="sgb<?php echo $i; ?>" onclick="xeditSettingGis(<?php echo $i.','.$rows[$i]['id']; ?>);return false;" > Save </button>  
	<button class="hd" ><a onclick="return confirm('Sure? Dangerous!');" class="txt-black no-underline" 
		href='<?php echo URL."mis/eraser/dbm/settings/".$rows[$i]['id']."/$sy"; ?>' >Eraser</a></button>	
</td>
	


</tr>	
<?php endfor; ?>

</table>
<br />

<!------------------------------------------------------------------------------------------------------------->

<script>
var hdpass = '<?php echo HDPASS; ?>';
var gurl = 'http://<?php echo GURL; ?>';
var sy   = '<?php echo $sy; ?>';

$(function(){
	hd();
	$('#hdpdiv').hide();

})

function xeditSettingGis(i,sgid){
	$('#sgb'+i).hide();
	var name 	= $('#name-'+i).val();
	var label 	= $('#label-'+i).val();
	var value 	= $('#value-'+i).val();
	
	var vurl = gurl + '/ajax/xsettings.php';	
	var task = 'xeditSettings';	
	var pdata = "name="+name+"&label="+label+"&value="+value+"&task="+task+"&sy="+sy+"&sgid="+sgid;
	
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,success:function(){} 
   });				

	
} 


</script>

<!------------------------------------------------------------------------------------------------------------->