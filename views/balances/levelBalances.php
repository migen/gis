<?php 

// pr($rows[0]);
// exit;


// pr($_SERVER);
// $url=URL.str_replace('url=','',$_SERVER['QUERY_STRING']);
// $url=str_replace('url=','',$_SERVER['QUERY_STRING']);
// pr($_SERVER['QUERY_STRING']);

?>

<h5>
	<?php echo $tuition['level']; ?> Tuition Balances (<?php echo (isset($count))? $count:0; ?>)
	<span class="hd">HD</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a class="u" id="btnExport" >Excel</a> 
	<?php if(!isset($_GET['noname'])): ?>
		| <a href="<?php echo URL.'balances/level/'.$level_id.'?noname'; ?>" >No Name</a>
	<?php else: ?>
		| <a href="<?php echo URL.'balances/level/'.$level_id; ?>" >With Name</a>	
	<?php endif; ?>
	| <a href="<?php echo URL.'balances/enrolled/'.$level_id; ?>" >Enrolled</a>	
	| <a href="<?php echo URL.'balances/updateEnrolled/'.$level_id; ?>" >Update Enrolled</a>
	
<?php 
	$d['sy']=$sy;$d['repage']="balances/level/$level_id";
	$this->shovel('sy_selector',$d); 
?>	
	
	
</h5>

<?php isset($_GET['debug'])? pr($q):NULL; ?>

<h4 class="brown" >IMPT* Lock settings ledger setup when done.</h4>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."balances/level/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>

<?php include_once('incs/balances_filter.php'); ?>
<?php 
if($get['paymode']>0){
	$txtdpdue = ($get['paymode']>1)? $dpdue.',':$dpdue;
	echo (isset($paydates))? '<p> Paydates: '.$txtdpdue.$paydates.'</p>':NULL; 
}

	
?>


<div class="clear" >&nbsp;</div>
<!----------------------------------------------------------------------------------------------->
<form method="POST" >

<table id="tblExport" class="gis-table-bordered table-fx table-altrow" style="width:1600px;" >
<tr class="headrow" >
	<th>#</th>
	<th>Scid</th>
	<th>Classroom</th>
	<th>ID Number</th>
	<?php if(!isset($_GET['noname'])): ?>
		<th>Student</th>
	<?php endif; ?>
	<th>Mode</th>
	<th>Assessed</th>
	<th>Total<br />Discounts</th>
	<th>Total<br />Addons</th>
	<th>Addons<br />Balance</th>
	<th class="right" >Total<br />Due</th>
	<th class="right" >Total<br />Paid</th>
	<th class="right" >Total<br />Balance</th>
	<th class="vc200" >Payment Details</th>
	<th class="" >Auxes<br />(A|D)</th>
	<th class="" >Lgr | Soa</th>
	<?php if($get['paymode']>0): ?>
		<th>Current<br /> Due</th>
		<th>Current<br /> Paid</th>
		<th>Current<br />Balance</th>
	<?php endif; ?>
</tr>
<?php 
	$sumdiscs=0; $sumaddons=0; $sumpaid=0; $sumbalance=0; $sumcurrdues=0; $sumcurrbal=0; $sumdues=0; $sumcurrpaid=0;
	$sumapaid=0;
?>

<?php for($i=0;$i<$count;$i++): ?>
<?php 

	$sumdiscs+=round($rows[$i]['discounts'],2);
	$sumaddons+=round($rows[$i]['addons'],2);
	$sumdues+=round($rows[$i]['tdue'],2);
	$sumpaid+=round($rows[$i]['tpaid'],2);
	$sumbalance+=round($rows[$i]['tbalance'],2);
	$tbal=($rows[$i]['paid']-$rows[$i]['assessed']);	
	$overtpay=($tbal>0)? true:false;
	$abal = ($overtpay)? $rows[$i]['addons']-$tbal:round($rows[$i]['addons'],2)-round($rows[$i]['apaid'],2);	
	$sumapaid+=$abal;	
	
?>
<tr id="trow<?php echo $i; ?>"  >
	<td><?php echo $i+1; ?></td>
	<td><?php 
	echo str_pad($rows[$i]['scid'],4,"0",0); ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<?php if(!isset($_GET['noname'])): ?>	
		<td><?php echo $rows[$i]['student']; ?></td>
	<?php endif; ?>
	<td><?php echo $rows[$i]['paymode']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['assessed'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['discounts'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['addons'],2); ?></td>
	<td class="right" ><?php echo number_format($abal,2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['tdue'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['tpaid'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['tbalance'],2); ?></td>	
<td><?php 
$currpaid=0;
foreach($pays[$i] AS $pay){
	$currpaid+=$pay['amount'];
	echo 'P'.number_format($pay['amount'],2).' #'.$pay['orno'].' on '.$pay['date'].'('.$pay['pointer'].') ';
	echo substr($pay['feetype'],0,4).'<br />';
} 
?></td>
<td class="full" ><?php 
foreach($auxes[$i] AS $aux){
	echo 'P'.number_format($aux['amount'],2).' - '.substr($aux['feetype'],0,4).'<br />';
} 
?></td>	

<td>
	<a href="<?php echo URL.'ledgers/pay/'.$rows[$i]['scid']; ?>" >Lgr</a>
	<a href="<?php echo URL.'soas/soa/'.$rows[$i]['scid']; ?>" >Soa</a>
	<a href="<?php echo URL.'clearance/one/'.$rows[$i]['scid']; ?>" >Status</a>
</td>

<?php if($get['paymode']>0): ?>
<td class="right" ><?php $currdue=$dues[$i]; echo number_format($currdue,2); // pr($dues); ?></td>
<td class="right" ><?php $currdue=$dues[$i]; echo number_format($currpaid,2); ?></td>
<td class="right" ><?php $currbal=round($currdue,2)-round($currpaid,2); echo ($currbal>0)? number_format($currbal,2):0; ?></td>
<?php 
	$sumcurrpaid+=$currpaid;
	$sumcurrdues+=$currdue;
	$sumcurrbal+=$currbal;
?>
<?php endif; ?>
</tr>
<?php endfor; ?>

<tr><th>Total</th>
<th colspan="6" ></th>
<th class="right" ><?php echo number_format($sumdiscs,2); ?></th>
<th class="right" ><?php echo number_format($sumaddons,2); ?></th>
<th class="right" ><?php echo number_format($sumapaid,2); ?></th>
<th class="right" ><?php echo number_format($sumdues,2); ?></th>
<th class="right" ><?php echo number_format($sumpaid,2); ?></th>
<th class="right" ><?php echo number_format($sumbalance,2); ?></th>
<th colspan="3" ></th>
<?php if($get['paymode']>0): ?>
	<th class="right" ><?php echo number_format($sumcurrdues,2); ?></th>
	<th class="right" ><?php echo number_format($sumcurrpaid,2); ?></th>
	<th class="right" ><?php echo number_format($sumcurrbal,2); ?></th>
<?php endif; ?>
</tr>


</table>


</form>









<!------------------------------------------------------->


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script>

var gurl = "http://<?php echo GURL; ?>";
var lvl = "<?php echo $level_id; ?>";


$(function(){
	hd();
	excel();	
	itago('clipboard');
		
})





</script>

