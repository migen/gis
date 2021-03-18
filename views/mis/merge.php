<h5>
	Merge
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href="<?php echo URL.'mis/user'; ?>" />User</a>  


</h5>


<table class="screen gis-table-bordered table-fx" >	
<tr>
	<td class="vc200" ><input name="name" id="part" class="pdl05 full" placeholder="Name" autofocus /></td>
	<td class="vc100" ><input type="submit" name="find" class="full" onclick="xgetContactsByPart();return false;" value="Filter" /></td>
</tr>	

</table><br />

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>

<p>PTR - Purge transfer records.</p>

<?php if($data): ?>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>&nbsp;</th>
	<th>UCID</th>
	<th>PCID</th>
	<th>Name</th>
	<th>Login</th>
	<th>Pass</th>
	<th>T</th>
	<th>R</th>
	<th>P</th>
	<th>Actv</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr rel="<?php echo $row['id']; ?>" class="<?php echo (even($i))? 'even':'odd'?>" >
	<td><input type="checkbox" name="rows[<?php echo $row['id'];?>]" value="<?php echo $row['id']; ?>" /></td>
	<td><?php echo $users[$i]['ucid']; ?></td>
	<td><?php echo $users[$i]['parent_id']; ?></td>
	<td><?php echo $users[$i]['person']; ?></td>
	<td><?php echo $users[$i]['account']; ?></td>
	<td><?php echo $users[$i]['ctp']; ?></td>
	<td><?php echo $users[$i]['title_id']; ?></td>
	<td><?php echo $users[$i]['role_id']; ?></td>
	<td><?php echo $users[$i]['privilege_id']; ?></td>
	<td><?php echo ($users[$i]['is_active']==1)?'Y':'-'; ?></td>
	<td>
		<input class="vc50" />
		<button>PTR</button>
	</td>
</tr>
<?php endfor; ?>
</table>
</form>
<?php endif; ?>	<!-- with data -->


<div class="hd" id="names" > </div>



<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */

var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	hd();
	$('#hdpdiv').hide();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	





function redirContact(ucid){
	var url 		= gurl + '/mis/merge/' + ucid;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
