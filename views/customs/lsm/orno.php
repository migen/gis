<!-- table not div -->

<script>

$(function(){
	itago('ornopage');


})

</script>

<?php 

// pr($_SESSION['tfeeid']); 
$tfeeid=$_SESSION['tfeeid'];


?>



<div id="ornopage" class="ornopage print" >

<style>		

	div#content{ min-width:90%; min-height:100px;margin: 0 auto 0 auto; padding: 4px 20px; }

	
	div{border:1px solid white;}
	@media print{ .screen{display:none;} } 
	#ornopage{ border:1px solid white;width:7in;height:2.8in;}
	#sydate,#customer,#details,#totalempl{ position:relative;font-family:Arial,Helvetica,sans-serif;}

	#sydate{ position:fixed;top:0.6in;float:left;font-size:1.2em;left:4.6in;}				
	#customer{ position:fixed;top:0.8in;left:2.2in;width:50%;font-size:1.1em;border:1px solid white;}
	#details{ position:fixed;top:1.4in;left:1.0in;font-size:1.1em;border:1px solid white;}
	#totalempl{ position:fixed;top:2.7in;font-weight:bold;font-size:1.4em;left:1.6in;}
</style>

<!-- 1 -->
<div id="sydate" >
<table class="nogis-table-bordered-print" >
<tr style="height:24px;" >
<td style="width:1.2in;vertical-align:top;" ><?php echo DBYR.'-'.(DBYR+1); ?><?php echo $tplorno; ?></td>
<td style="vertical-align:bottom;width:1.2in;text-align:center;"><?php echo $rows[0]['date']; ?></td></tr>
</table>
</div>

<!-- 2 -->
<div id="customer" >
<table class="nogis-table-bordered" >
	<tr><td><?php echo $customer['custcode']; ?></td></tr>
	<tr><td><span style="padding-left:30px;"><?php echo $customer['customer']; ?></span></td></tr>
	<tr><td><span style="padding-left:50px;" ><?php echo $customer['level'].' - '.$customer['section']; ?></span></td></tr>
</table>

</div>


<!-- 3 -->
<div id="details" >
	<table class="nogis-table-bordered"   >
		<?php foreach($rows AS $row): ?>
		<tr>
			<td style="text-align:left;width:50px;" >&nbsp;<?php // pr($row); ?></td>
			<td>
			<?php 
				$feetype=$row['feetype'];
				if($row['feetype_id']==$tfeeid){ echo ($row['pointer']<1)? 'Reservation':'Tuition #'.$row['pointer']; 
				} else {
					echo $feetype;
				}
			?>			
			</td>			
			<td><?php echo $row['paytype']; ?></td>
			<td><?php echo $row['reference']; ?></td>
			<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
			<td><?php echo $row['details']; ?></td>
		</tr>
		<?php endforeach; ?>
		</table>
</div>

<div id="totalempl" >
<table class="nogis-table-bordered-print" >
<tr><td style="width:2.0in;padding-left:0.6in;" ><?php echo number_format($ortotal,2); ?></td>
<td style="width:0.2in;" >&nbsp;</td>
<td style="width:1.6in;text-align:right;" ><?php echo strtoupper($_SESSION['user']['code']); ?></td></tr>
</table>
</div>

</div>		<!-- ornopage -->

<script>

$(function(){

	// $('#ornopage').show();
	// itago('std');
	
	
})	/* fxn */


</script>
 