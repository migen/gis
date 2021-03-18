<div style="width:75%;float:left;"  >
<form method="POST" >
<table class="gis-table-bordered table-fx"  >
<tr> 
	<th>#</th>
	<th>Ucid</th>
	<th>Pcid</th>
	<th>Name</th>
	<th class="vc80" >Code<br />ID No.</th>
	<th class="vc80" >Account<br />Login</th>
	<th>Pass</th>
	<th>TitleId<br />
		<input class="pdl05 vc40" id="ititle" />	
		<br /><input type="button" value="All" onclick="populateColumn('title');" >							
	</th>
	<th class="vc100" >Role-Priv<br />
		<input class="pdl05 vc40" id="irole" />	
		<input class="pdl05 vc40" id="ipriv" /><br />	

		<input type="button" value="All" onclick="populateColumn('role');" >					
		<input type="button" value="All" onclick="populateColumn('priv');" >							
	</th>
	<th>Male<br />
		<input class="pdl05 vc50" id="imale" /><br />	
		<input type="button" value="All" onclick="populateColumn('male');" >						
	</th>	
	<th>Actv<br />
		<input class="pdl05 vc50" id="iactv" /><br />	
		<input type="button" value="All" onclick="populateColumn('actv');" >						
	</th>	
	<th>Clrd<br />
		<input class="pdl05 vc50" id="iclrd" /><br />	
		<input type="button" value="All" onclick="populateColumn('clrd');" >						
	</th>	
	<th>SY<br />
		<input class="pdl05 vc50" id="isy" /><br />	
		<input type="button" value="All" onclick="populateColumn('sy');" >						
	</th>	
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$ucid=$rows[$i]['id'];
	$pcid=$rows[$i]['parent_id'];
?>
<tr>
	<td><?php echo $i+1;  ?></td>
	<td><?php echo $ucid;  ?></td>
	<td><input id="pcid<?php echo $i; ?>" name="posts[<?php echo $i; ?>][parent_id]" class="vc60" 
		value="<?php echo $rows[$i]['parent_id'];?>" tabindex="2" /></td>
	<td><input id="name<?php echo $i; ?>" name="posts[<?php echo $i; ?>][name]" tabindex="4"
		value="<?php echo $rows[$i]['name'];?>" />
		<br /><?php echo $rows[$i]['account'].'-'.$rows[$i]['ctp']; ?>
		</td>		
	<td><input id="code<?php echo $i; ?>" name="posts[<?php echo $i; ?>][code]" class="full" tabindex="6"
		value="<?php echo $rows[$i]['code'];?>" /></td>
	<td><input id="account<?php echo $i; ?>" name="posts[<?php echo $i; ?>][account]" class="full" tabindex="6"
		value="<?php echo $rows[$i]['account'];?>" /></td>		
	<td>
		<?php if(isset($rows[$i]['ctp'])): ?>
			<input id="ctp<?php echo $i; ?>" name="posts[<?php echo $i; ?>][ctp]" class="full" tabindex="8"
				value="<?php echo $rows[$i]['ctp'];?>" />		
		<?php else: ?>
			<a href="<?php echo URL.'syncs/syncCtp/syncs'; ?>" >Sync</a>
		<?php endif; ?>
	</td>
	<td>
		<input id="title<?php echo $i; ?>" class="title vc40" name="posts[<?php echo $i; ?>][title_id]" tabindex="9" 
			value="<?php echo $rows[$i]['title_id'];?>" />	
	</td>
	
	<td>
		<input id="role<?php echo $i; ?>" class="role vc40" name="posts[<?php echo $i; ?>][role_id]" tabindex="10"
			value="<?php echo $rows[$i]['role_id'];?>" />
		<input id="priv<?php echo $i; ?>" class="priv vc40" name="posts[<?php echo $i; ?>][privilege_id]" tabindex="11"
			value="<?php echo $rows[$i]['privilege_id'];?>" />
	</td>

	<td><input id="male<?php echo $i; ?>" class="male vc30" name="posts[<?php echo $i; ?>][is_male]" tabindex="14"
		value="<?php echo $rows[$i]['is_male']; ?>" /></td>
	<td><input id="actv<?php echo $i; ?>" class="actv vc30" name="posts[<?php echo $i; ?>][is_active]" tabindex="16"
		value="<?php echo $rows[$i]['is_active']; ?>" /></td>
	<td><input id="clrd<?php echo $i; ?>" class="clrd vc30" name="posts[<?php echo $i; ?>][is_cleared]" tabindex="18"
		value="<?php echo $rows[$i]['is_cleared']; ?>" /></td>
	<td><input id="sy<?php echo $i; ?>" class="sy vc60" name="posts[<?php echo $i; ?>][sy]" tabindex="20"
		value="<?php echo $rows[$i]['sy']; ?>" /></td>
	<td><button id="csb<?php echo $i; ?>" onclick="xeditContact(<?php echo $i.','.$ucid; ?>);return false;" >
		Save</button> 
		<button><a class="txt-black" href="<?php echo URL.'contacts/ucis/'.$ucid; ?>" >UCIS</a></button>
	</td>
		
	<input type="hidden" name="posts[<?php echo $i; ?>][ucid]" value="<?php echo $ucid; ?>"  />		
</tr>
<?php endfor; ?>
</table>

<p><input type="submit" name="update" value="Update All" onclick="return confirm('Sure?');"  /></p>

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
	var account = $('input[name="posts['+i+'][account]"]').val();
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

	var pdata = "task="+task+"&id="+ucid+"&code="+code+"&account="+account+"&name="+name;
	pdata += "&parent_id="+parent_id;
	pdata += "&is_male="+is_male+"&is_active="+is_active+"&is_cleared="+is_cleared+"&ctp="+ctp;
	pdata += "&title_id="+title_id+"&role_id="+role_id+"&privilege_id="+privilege_id+"&sy="+sy;
	
		
	$.ajax({
		type: 'POST',url: vurl,data: pdata,success:function(){} 
	});				
	
}	/* fxn */





</script>




