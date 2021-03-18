<style>

</style>

<?php 
$data['page'].="<br />Date: $date";

// pr($data);
// exit; 

?>

<h5 class="screen" >
	Cash Denominations (POS)
	| <a href="<?php echo URL.$home; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'cash/report'; ?>">Report</a> 

</h5>



<form method="POST" >



<table class="screen gis-table-bordered" >
<tr>
	<th>Terminal</th>
	<td><input class="vc50 center" type="number" name="terminal" id="terminal"
		value="<?php echo (isset($terminal))? $terminal:1; ?>" <?php echo ($admin)? NULL:'readonly'; ?> /></td>
	<th>Ecid</th>
	<td><input <?php echo (!$admin)? "id='ecid'":NULL; ?> <?php echo (!$admin)? "readonly":NULL; ?> 
		class="vc70 center" value="<?php echo (isset($ecid))? $ecid:1; ?>" /></td>		
	<td>
		<select id="paid" >
			<option value="0" >All</option>
			<option value="1" <?php echo (isset($_GET['paid']) && $_GET['paid']==1)? 'selected':NULL; ?> >Paid</option>
		</select>
	</td>				
	<th>Date</th>
	<td><input class="pdl05" type="date" id="date" value="<?php echo (isset($_GET['date']))? $_GET['date']:$today; ?>"  /></td>
		<?php if($admin): ?>		
			<td><select id="ecid" class="vc200"  >
				<?php foreach($cashiers AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" 
						<?php echo (isset($_GET['ecid']) && ($_GET['ecid']==$sel['id']))? 'selected':NULL; ?>
					><?php echo $sel['name'].' #'.$sel['id']; ?></option>
				<?php endforeach; ?>
				<option value=0 <?php echo (isset($_GET['ecid']) && ($_GET['ecid']==0))? 'selected':NULL;  ?> >All</option>
			</select></td>		
		<?php endif; ?>
			<td><a class="txt-blue u" onclick="redirCash();" >Go</a></td>			
</tr>
</table>


<div class="center clear" >
<?php $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
</div>

<div><?php  include_once('incs/cash_denominations.php');  ?></div>

<div id="signature" class="ht100" >
<br />
Prepared by: 

<br />
<br />
<br />
_________________________<br />
Manager

</div>


</form>

<!-------------------------------------------->
<script>

	var gurl  = 'http://<?php echo GURL; ?>';	
	var home  = '<?php echo $home; ?>';


$(function(){
	shd();
	nextViaEnter();
	selectFocused();

})	/* fxn */


function redirCash(){
	var ecid = $('#ecid').val();
	var udate = $('#date').val();
	var trml = $('#terminal').val();
	var paid = $('#paid').val();
	var url = gurl+'/cash/denominations?date='+udate+'&terminal='+trml+'&ecid='+ecid+'&paid='+paid;
	window.location=url;
}	/* fxn */


	
	

</script>