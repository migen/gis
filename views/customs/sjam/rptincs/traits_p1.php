<?php 


$divlimits=4;
$divnum=ceil($numtraits/$divlimits);

// echo "divlimits: $divlimits <br />";
// echo "divnum: $divnum <br />";
// echo "numtraits: $numtraits <br />";

?>

<style>



</style>

<table class="" style="width:<?php echo $tbl_width; ?>;" >
<tr><th class="center" colspan=3>TRAITS</th></tr>
</table>


<?php // $di=0; ?>

<table class="gis-table-bordered"  >
<tr><th colspan=3 ><?php echo $conducts[0]['critype']; ?></th></tr>
<?php for($ic=0;$ic<$numtraits;$ic++): ?>
<?php $id=$ic+1; ?>
<tr>
	<td><?php echo $conducts[$ic]['trait']; ?></td>
	<td style="width:30px;" ><?php echo $conducts[$ic]['dg1']; ?></td>
	<td style="width:30px;" ><?php echo $conducts[$ic]['dg2']; ?></td>
</tr>
<?php if((isset($conducts[$id]['critype_id'])) && ($conducts[$ic]['critype_id']!=$conducts[$id]['critype_id'])): ?>
	<tr><th colspan=3 ><?php echo $conducts[$id]['critype']; ?></th></tr>
<?php endif; ?>
<?php endfor; ?>
</table>
