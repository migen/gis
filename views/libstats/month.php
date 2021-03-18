

<style>


</style>

<h5 class="screen" >
	<?php // pr($_SESSION['months']); ?>

	Libstats
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				

	| <select id="dif" >
		<option value="2" <?php echo ($dif==2)? 'selected':NULL; ?> >GS</option>
		<option value="3" <?php echo ($dif==3)? 'selected':NULL; ?> >HS</option>
		<option value="4" <?php echo ($dif==4)? 'selected':NULL; ?> >SHS</option>
	</select>
	
	<select id="moid" >
		<?php foreach($_SESSION['months'] AS $sel): ?>
			<option value="<?php echo $sel['index']?>" 
				<?php echo ($sel['index']==str_pad($moid,2,'0',STR_PAD_LEFT))? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
		
	</select>
	
	
	<button onclick="goto();" >Go</button>
	
	| <a class="u" id="btnExport" >Excel</a> 

</h5>


<table id="tblExport" class="gis-table-bordered table-center" >

<tr><th class="center" colspan="33" ><?php echo $dcf; ?> Library Statistics for <?php echo $morow['name'].' '.$year; ?> </th></tr>
<tr><td rowspan="2" class="left" >Patrons</td><td class="center" colspan="31" >Days</td><td rowspan="2" >Total</td></tr>
<tr>
<?php for($i=1;$i<32;$i++): ?>
	<td><?php echo $i; ?></td>
<?php endfor; ?>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="left" ><?php echo $rows[$i]['level']; ?></td>
	<?php $rowtotal=0; ?>
	<?php for($j=1;$j<32;$j++): ?>
		<?php $rowtotal+=$rows[$i][$j]; ?>
		<td><?php echo $rows[$i][$j]; ?></td>
	<?php endfor; ?>
	<td><?php echo $rowtotal; ?></td>
</tr>
<?php endfor; ?>

<tr>
	<?php $sumtotal=0; ?>
	<th>Total</th>
	<?php for($j=1;$j<32;$j++): ?>
		<?php 
			$coltotal=0;
			for($i=0;$i<$count;$i++){
				$coltotal+=$rows[$i][$j];
			}

		?>
		<td><?php echo $coltotal; ?></td>
		<?php $sumtotal+=$coltotal; ?>
	<?php endfor; ?>
	<td><?php echo $sumtotal; ?></td>
</tr>

</table>



<!------------------------------------------------------->

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>

var gurl  = "http://<?php echo GURL; ?>";

$(function(){
	excel();


})

function goto(){
	var dif=$('#dif').val();
	var moid=$('#moid').val();	
	var url=gurl+'/libstats/month/'+dif+'/'+moid;
	window.location=url;
	
}





</script>


