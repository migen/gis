<style>

.tblrpt { border: 1px solid #dddddd; border-left: 0; border-top: 0; }

.tblrpt th, .tblrpt td, .tdbordered tr td, .tdbordered tr td  
{ border-left: 1px solid #dddddd;  border-top: 1px solid #dddddd; padding:3px 10px; }


</style>

<?php 


$recs=array(array('scid'=>'2652','student'=>'SILVESTRE, Marius Nuriel C.','genave'=>95.57),array('scid'=>'2633','student'=>'ACORDON, Sean Vincent F.','genave'=>95.57),array('scid'=>'2686','student'=>'LAGMAN, James Alexander B.','genave'=>94.71),array('scid'=>'2684','student'=>'CLIMACOSA, Joaquin Miguel A.','genave'=>94.57),array('scid'=>'2669','student'=>'REDONDO, Lance Vincent S.','genave'=>94.00),array('scid'=>'2785','student'=>'CACATIAN, Jacobo R.','genave'=>93.86),array('scid'=>'2380','student'=>'TAN, Ryan Emmanuel Y.','genave'=>93.57),array('scid'=>'2640','student'=>'DELA CUEVA, Iñigo Sebastian Z.','genave'=>93.57),array('scid'=>'2648','student'=>'BERDOS, Caleb Ladd A.','genave'=>93.43),array('scid'=>'2843','student'=>'OCAMPO, Red Karol G.','genave'=>92.29),array('scid'=>'2428','student'=>'ESTRABO, John Carlo B.','genave'=>92.29),array('scid'=>'2802','student'=>'OBLEPIAS, John Austin Kenneth S.','genave'=>91.43),array('scid'=>'2729','student'=>'WATSON, Aston Ryan E.','genave'=>90.86),array('scid'=>'2723','student'=>'MAGHIRANG, Marcus Daniel P.','genave'=>90.86),array('scid'=>'2536','student'=>'CRUZ, Julio Martin M.','genave'=>90.71),array('scid'=>'2564','student'=>'REYLA, Audi B.','genave'=>89.86),array('scid'=>'2795','student'=>'PEDROZO, Perzeus Jacob M.','genave'=>89.57),array('scid'=>'2415','student'=>'MARASIGAN, Matteo Rafael P.','genave'=>89.57),array('scid'=>'2739','student'=>'ENCINA, Gabriel Eros B.','genave'=>89.43),array('scid'=>'2783','student'=>'LINDAYAG, Daniel Ynigo C.','genave'=>89.29),);
// pr($recs);


// dbo.rankstest

$recs=&$rows;
$count=count($recs);

$ranks=&$rows;
$ranks[0]['rank']=1;
// pr($ranks[0]);



?>

<h5>
Ranks

</h5>


<?php 
	// ob_start();	

?>

<table class="tblrpt" >
<tr><th>#</th><th>Scid</th><th>Student</th><th>Genave<br />I</th>
<th>Next<br />J</th>
<th>Rank1</th>
<th>Shld</th>
<th>Sum</th>
<th>Tmp</th>

</tr>
<?php $ct=0; ?>
<?php $r1=1; ?>
<?php $sum=0; ?>
<?php $total=0; ?>
<?php $ctr=0; ?>
<?php $tmp=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $j=$i+1; ?>
<?php $ct++; ?>
<?php $sum+=$ct; ?>

<?php 
	$tmp=&$j;
	

	
?>


<tr>	
	<td><?php echo $ct; ?></td>
	<td><?php echo $recs[$i]['scid']; ?></td>
	<?php // $student=$recs[$i]['student']; ?>
	<td><?php echo $recs[$i]['name']; ?></td>
	<td class="rigth" ><?php echo number_format($recs[$i]['genave'],2); ?></td>
	<td><?php echo @number_format($recs[$j]['genave'],2); ?></td>
	<td><?php echo $r1; ?></td>
	<?php ($recs[$i]['genave']>@$recs[$j]['genave'])? $r1+=1:$r1; ?>
	<td><?php echo $recs[$i]['should']+0; ?></td>
	<td><?php echo $sum; ?></td>
	<td><?php echo $tmp; ?></td>

</tr>
<?php endfor; ?>
</table>


