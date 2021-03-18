


<?php 

// pr($data);
$dbtable=$data['dbtable'];
// pr($dbtable);

?>
<table class="table-bordered" >
<tr><th>Code <input id="code" class="vc150" ></th><th>Name <input id="name" class="vc300" ></th>
	<td><input type="submit" value="Add" onclick='xaddCodename("<?php echo $dbtable; ?>");' ></td></tr>
</table>

