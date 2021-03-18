<?php 

	
	$dbclassrooms="{$dbg}.05_classrooms";


?>

<h3>
	Rollback (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'rosters/draft';?>" >Drafter</a>
</h3>

<p class="b" >
<?php echo '#'.$classroom['id'].' - '.$classroom['name'].' | Acid: '.$classroom['acid']; ?>
</p>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Classrooms" onclick='getDataByTable(dbclassrooms,limits);return false;' />
	</td></tr>
</table></p>
<div id="names" >names</div>


<?php 



?>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th>Prev<br />Crid</th>
	<th>Crid</th>
	<th>Prev<br />Crid</th>
	<th>Crid</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
	<td><?php echo $rows[$i]['prevcrid']; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><input class="vc50" id="prevcrid-<?php echo $i; ?>" value="<?php echo $rows[$i]['prevcrid']; ?>" ></td>
	<td><input class="vc50" id="crid-<?php echo $i; ?>" value="<?php echo $rows[$i]['crid']; ?>" ></td>
	<td><button id="btn-<?php echo $i; ?>" onclick="xeditCridAndPrevcrid(<?php echo $i; ?>)" >Save</button>
		<input readonly type="hidden" class="vc50" id="scid-<?php echo $i; ?>" value="<?php echo $rows[$i]['scid']; ?>" >
	</td>
	
</tr>
<?php endfor; ?>
</table>

<div  class="ht100" >&nbsp;</div>


<script>

const gurl="http://<?php echo GURL; ?>";	
const sy="<?php echo $sy; ?>";	
const dbclassrooms = "<?php echo $dbclassrooms; ?>";
const limits='20';

$(function(){
	nextViaEnter();
	selectFocused();
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})


function xeditCridAndPrevcrid(i){
	$('#btn-'+i).hide();		
	const scid = $('#scid-'+i).val();
	const prevcrid = $('#prevcrid-'+i).val();
	const crid = $('#crid-'+i).val();

	var vurl 	= gurl + '/ajax/xrosters.php';	
	var task	= "xeditCridAndPrevcrid";	
	var pdata = "task="+task+"&sy="+sy+"&prevcrid="+prevcrid+"&crid="+crid+"&scid="+scid;
	
	$.ajax({type: 'POST',url: vurl,data: pdata,success:function(){} 
   });				
	
}	/* fxn */

	
function axnFilter(id){
	var url=gurl+"/rosters/rollback/"+id+"/"+sy;
	window.location=url;
}


</script>


<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
