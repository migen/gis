<h5><span onclick="toggleShd();" class="u" >Accounts</span>
<?php if($_SESSION['srid']==RMIS): ?>
	| <a href='<?php echo URL."mgt/users/".$_SESSION['pcid']; ?>' >Users</a>
<?php endif; ?>
<span class="shd" >| PCID#<?php echo $pcid; ?></span>

</h5>

<?php 
// pr($accounts[0]);
?>


<table class="gis-table-bordered table-fx"  >

<tr class="headrow" >
<th>#</th>
<th>IP</th>
<th>TRP</th>
<th>ROLE</th>
<th>SWITCH</th>
</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
<td><?php echo $accounts[$i]['ucid']; ?></td>
<td><?php echo ($accounts[$i]['id']==$accounts[$i]['parent_id'])? '1':'-'; ?></td>
<td><?php echo $accounts[$i]['title_id'].'-'.$accounts[$i]['role_id'].'-'.$accounts[$i]['privilege_id']; ?></td>
<td><?php echo $accounts[$i]['role']; ?></td>
<td><a href='<?php echo URL."my/switcher/".$accounts[$i]['ucid']; ?>' ><?php echo $accounts[$i]['account']; ?></a></td>
</tr>
<?php endfor; ?>
</table>

<script type="text/javascript">

document.getElementsByClassName('shd')[0].style.visibility='hidden';

function toggleShd(){
	var cls = document.getElementsByClassName('shd')[0];	
	cls.style.visibility = cls.style.visibility == "hidden" ? "visible" : "hidden";		
}


</script>