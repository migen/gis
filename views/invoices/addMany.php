<?php 


?>

<h5>
	New Invoice <span class="hd" >HD</span>
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."invoices"; ?>' >Invoices</a>
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	
	
</h5>


<div style="float:left;width:70%;" >	<!-- left -->
	<?php include_once('incs/form_invoice.php'); ?>
	
	<p><?php $this->shovel('numrows'); ?></p>

</div>	<!-- left -->




<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="date" >Date</option>
	<option value="scid" >CustID</option>
	<option value="part" >Guest</option>
	<option value="fee" >Fee</option>
	<option value="tender" >Tender</option>
	<option value="amount" >Amount</option>
	<option value="paid" >Paid</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>


<div class="clear ht100" >&nbsp;</div>




<script>
var gurl = "<?php echo GURL; ?>";

$(function(){
	// hd();
	// shd();
	itago('clipboard');
	$('html').live('click',function(){
		$('#names').hide();
	});


})	/* fxn */


function redirContact(pcid,rid){	
	$('#scid'+rid).val(pcid);
	
}	/* fxn */



</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>