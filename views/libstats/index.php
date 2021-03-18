<?php

?>


<h5 class="screen" >
	Libstats
	| <a href="<?php echo URL.'librarians'; ?>">Librarians</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href='<?php echo URL."libstats/month/".$_SESSION['moid']; ?>'>Month</a>		


</h5>

<p><?php $this->shovel('hdpdiv'); ?></p>

<table class="gis-table-bordered table-altrow table-fx" >

<tr>
<th class="" >Month</th>
<th></th>
<th class="hd" ></th>
</tr>


<?php foreach($_SESSION['months'] AS $sel): ?>
<tr>
	<td><?php echo $sel['name']; ?></td>
	<td>
		<?php for($i=1;$i<32;$i++): ?>
			<a href="<?php echo URL.'libstats/tally/'.$i.'/'.$sel['index']; ?>" >
				<?php echo str_pad($i,2,'0',STR_PAD_LEFT); ?></a> | 
		<?php endfor; ?>
	</td>
	<td class="hd" ><a href="<?php echo URL.'libstats/tallyMonth/'.$sel['index']; ?>" >Tally</a></td>
</tr>
<?php endforeach; ?>



</table>

<script>

var hdpass 	= '<?php echo HDPASS; ?>';

$(function(){	
	hd();
	$('#hdpdiv').hide();
	
});


</script>	

