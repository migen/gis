<?php

// pr($rows[0]);

?>

<div style="width:75%;float:left;"  >
<form method="POST" >
<table class="gis-table-bordered table-fx"  >
<tr> 
	<th>#</th>
	<th>UCID</th>
	<th>Level</th>
	<th>Section</th>
	<th>Name</th>
	<th class="vc80" >ID No</th>
	<th>Male</th>	
	<th>Nationality</th>	
	<th>SY</th>	
	
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$ucid=$rows[$i]['id'];
	$pcid=$rows[$i]['parent_id'];
?>
<tr>
	<td><?php echo $i+1;  ?></td>
	<td><?php echo $rows[$i]['ucid']; ?></td>
	<td><?php echo $rows[$i]['level']; ?></td>
	<td><?php echo $rows[$i]['section']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo ($rows[$i]['is_male']==1)? '1':'-'; ?></td>
	<td><?php echo $rows[$i]['nationality']; ?></td>
	<td><?php echo $rows[$i]['sy']; ?></td>

	<td>
		<button><a class="txt-black" href="<?php echo URL.'students/sectioner/'.$ucid; ?>" >Sxnr</a></button>
		<button><a class="txt-black" href="<?php echo URL.'assessment/assess/'.$ucid; ?>" >Assmt</a></button>
		<button><a class="txt-black" href="<?php echo URL.'profiles/scid/'.$ucid; ?>" >Profile</a></button>
	</td>
		
	<input type="hidden" name="posts[<?php echo $i; ?>][ucid]" value="<?php echo $ucid; ?>"  />		
</tr>
<?php endfor; ?>
</table>


</form>

</div> 	<!-- left -->


<div class="clipboard" style="width:20%;float:left;"  >
<p>
<select id="classbox" >
	<option value="pcid" >PCID</option>
	<option value="code" >Code</option>
	<option value="name" >Name</option>
	<option value="title" >Title</option>
	<option value="role" >Role</option>
	<option value="priv" >Privilege</option>	
	<option value="prnt" >Prnt</option>
	<option value="male" >Male</option>
	<option value="actv" >Active</option>
	<option value="clrd" >Cleared</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<!------------------------------------------------------->
<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){

	itago('clipboard');


})


function xeditContact(i,ucid){

	$('#csb'+i).hide();	

	var parent_id = $('input[name="posts['+i+'][parent_id]"]').val();
	var ctp = $('input[name="posts['+i+'][ctp]"]').val();
	var code = $('input[name="posts['+i+'][code]"]').val();
	var name = $('input[name="posts['+i+'][name]"]').val();
	var is_male = $('input[name="posts['+i+'][is_male]"]').val();
	var is_active = $('input[name="posts['+i+'][is_active]"]').val();
	var is_cleared = $('input[name="posts['+i+'][is_cleared]"]').val();

	var title_id = $('input[name="posts['+i+'][title_id]"]').val();
	var role_id = $('input[name="posts['+i+'][role_id]"]').val();
	var privilege_id = $('input[name="posts['+i+'][privilege_id]"]').val();
	var sy = $('input[name="posts['+i+'][sy]"]').val();
			
	var vurl 	= gurl+'/ajax/xcontacts.php';	
	var task	= "xeditContact";

	var pdata = "task="+task+"&id="+ucid+"&code="+code+"&name="+name+"&parent_id="+parent_id;
	pdata += "&is_male="+is_male+"&is_active="+is_active+"&is_cleared="+is_cleared+"&ctp="+ctp;
	pdata += "&title_id="+title_id+"&role_id="+role_id+"&privilege_id="+privilege_id+"&sy="+sy;
		
	$.ajax({
		type: 'POST',url: vurl,data: pdata,success:function(){} 
	});				
	
}	/* fxn */





</script>




