
<?php 

// pr($scid);

/* 
	1) $fpaid (tfees paid), 2) $apaid (auxes paid), 3) $tpaid (totalpaid=fpaid_apaid)
	4) $atotal (auxes total), 5) rcoll (running collectibles), 6) overpayment added to $atotal (if tpaid > $total_fees) 
	
div{border:1px solid black;}
#soafooter{ color:red; position: fixed;bottom:120px;width: 100%; }
		
 */

$ppr=isset($_GET['ppr'])? $_GET['ppr']:$ldm;
 
// pr($_SESSION['q']);
 
?>


<style>

</style>

<script>

var gurl = "http://<?php echo GURL; ?>";
var home = '<?php echo 'fees'; ?>';
var sy	 = '<?php echo $sy; ?>';
var page = 'soas/soa';
var limits = '20';


$(function(){

})

function ovrefund(i,scid,amt){
	$('#ovrbtn'+i).hide();
	var vurl=gurl+'/ajax/xrefund.php';
	var task='ovrefund';
	$.ajax({
		url:vurl,type:'POST',
		data:'task='+task+'&scid='+scid+'&amt='+amt,
	})
	
	
}	/* fxn */


function gotoPage(){
	
	var code = $('#code').val();		
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";
	var due = $('#due').val();
			
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&code='+code,				
		async: true,
		success: function(s) { 	
			if(s){
				var rurl = gurl+'/'+page+'/'+s.id+'/'+sy+'?due='+due;
				window.location = rurl;
			} else {
				alert('No record found.');
			}
			
		}		  
    });				
	
}	



function redirSoa(){
	var due = $('#due').val();
	var mode = $('#mode').val();
	var mcond = (mode>0)? "&mode="+mode:"";	
	var lvl = $('#lvl').val();
	var crid = $('#crid').val();
	var psy = $('#psy').val();
	var ppr = $('#ppr').val();	/* payment period */
	var url = gurl+'/soas/soa?lvl='+lvl+'&crid='+crid+mcond+'&due='+due+'&psy='+psy+'&ppr='+ppr;	
	window.location = url;		

}	/* fxn */

function xsaveTsumRemarks(remarks,scid){
	var vurl 	= gurl + '/ajax/xsoa.php';	
	var task	= "xsaveTsumRemarks";	
	$.ajax({
		url: vurl,
		type: 'POST',
		data: 'task='+task+'&remarks='+remarks+'&scid='+scid,				
		async: true,
		success: function() { }		  
    });				
	
}	/* fxn */

function redirContact(ucid){
	var due = $('#due').val();	
	var url = gurl+'/soas/soa/'+ucid+'&due='+due;	
	window.location = url;		
}	/* fxn */



</script>


<?php 

include(SITE.'views/ledgers/incs/soa_functions.php'); 



?>

<?php

/* $i for students, $j for auxes, $k for payments */
$get=($scid)? $scid:sages($_GET);

?>




<h5 class="screen" >

<?php 
?>

<span >
	<span class="u" ondblclick="tracehd();" >Statement of Accounts (<?php echo $num_students; ?>)</span>
	<?php if(isset($_GET['all'])): ?>
		| <a href="<?php echo URL.'soas/soa?lvl='.$lvl; ?>" >Actives</a>
	<?php else: ?>
		| <a href="<?php echo URL.'soas/soa?lvl='.$lvl; ?>&all" >All</a>	
	<?php endif; ?>	
		| <a href="<?php echo URL.'balances/level/'.$lvl; ?>" >Balances</a>	
<?php if(isset($_GET['reminders'])): ?>		
	<?php $get=str_replace("reminders","",$get); ?>
	| <a href="<?php echo URL.'soas/soa/'.$get; ?>" >No Reminders</a>
<?php else: ?>
	| <a href="<?php echo URL.'soas/soa/'.$get.'&reminders'; ?>" >Reminders</a>
<?php endif; ?>	
</span>

<?php if(isset($_GET['lvl'])): ?>
	<?php foreach($paymodes AS $sel): ?>
		| <a href="<?php echo URL.'soas/soa?lvl='.$lvl.'&mode='.$sel['id']; ?>" ><?php echo strtoupper($sel['code']); ?></a>
	<?php endforeach; ?>	
<?php endif; ?>

<?php 
if($scid){
	$d['sy']=$sy;$d['repage']="soas/soa/$scid";
	$this->shovel('sy_selector',$d); 
}

?>	

</h5>


<?php if(isset($_GET['debug'])){ pr($q); }  ?>




<div class="screen" style="width:30%;float:left;" >
<table class="gis-table-bordered" >
<tr><td>Due</td><td><input id="due" class="vc150 pdl05" type="date" value="<?php echo $ldm; ?>" />
<input class="vc70 center" id="psy" type="number" value="<?php echo $sy; ?>" />
</td></td>
<tr><td>Mode</td><td>
<select id="mode" class="vc150" >
	<option value="0" >All</option>
	<?php foreach($paymodes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo ((isset($_GET['mode'])) && ($sel['id']==$_GET['mode']))? 'selected':NULL; ?>		
		><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr>
<td>Payment Period</td>
<td><input class="vc150 pdl05" id="ppr" value="<?php echo $ppr; ?>" /></td>
</tr>


<tr><td>Level</td>
<td> 
	<select class="vc150" id="lvl" >
		<option value="0">Choose</option>
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>"  
			<?php echo ((isset($_GET['lvl'])) && ($sel['id']==$_GET['lvl']))? 'selected':NULL; ?>								
			><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>
<tr><td>Classroom</td>
<td>
	<select class="vc150" id="crid" >
		<option value="0">Choose</option>
		<?php foreach($classrooms AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>"
			<?php echo ((isset($_GET['crid'])) && ($sel['id']==$_GET['crid']))? 'selected':NULL; ?>					
			><?php echo $sel['name']; echo (isset($_GET['debug']))? ' #'.$sel['id']:NULL; ?></option>
		<?php endforeach; ?>
	</select>
	<input type="submit" onclick="redirSoa();" />	
</td>
</tr>
</table>
</div>

<div class="screen" style="width:32%;float:left;"  >
	<?php  include_once(SITE.'views/elements/filter_idname.php'); ?>
</div>


<div style="float:left;width:20%;" class="screen" id="names" > </div>



<?php 
	
if(($scid==0) && (!$lvl) && (!$crid)){ exit; }
$como=date('m',strtotime($cutoff));
// echo "como $como ";
	
?>


<!-- students loop -->
<?php 
for($i=0;$i<$num_students;$i++): 	
	$student = $students[$i];
	ob_start();	

?>

<!-------------------------- page starts -------------------------->


<?php include(SITE.'views/customs/'.VCFOLDER.'/incs/soa_page.php'); ?>


<!-------------------------- page ends -------------------------->



<p class='pagebreak'>&nbsp; </p>
<?php 	
	$ob = "ob$i";
	$$ob = ob_get_clean();
	ob_flush();

endfor; ?>	
<!-- students loop -->


<?php
 

for($j=0;$j<$num_students;$j++){
	$ob = "ob$j";
	echo $$ob;

}	

 
?>
