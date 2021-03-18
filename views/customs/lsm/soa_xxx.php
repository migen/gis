
<script>

var gurl = "http://<?php echo GURL; ?>";
var home = '<?php echo 'fees'; ?>';
var sy	 = '<?php echo $sy; ?>';
var page = 'soas/soa';
var limits = '20';


$(function(){

})



function gotoPage(){
	var code = $('#code').val();		
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";
			
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&code='+code,				
		async: true,
		success: function(s) { 	
			if(s){
				var rurl = gurl+'/'+page+'/'+s.id;
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
	var url = gurl+'/soas/soa?lvl='+lvl+'&crid='+crid+mcond+'&due='+due;	
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


function redirectLevel(axn,lvl){
	var due = $('#due').val();
	var mode = $('#mode').val();
	var mcond = (mode>0)? "&mode="+mode:"";	
	var rurl = gurl+'/'+home+'/'+axn+'?lvl='+lvl+mcond+'&due='+due;		
	window.location = rurl;			
}	/* fxn */


</script>


<?php 


$assessed=round($assessed,2);	
include(SITE.'views/ledgers/incs/soa_functions.php'); 




/* $i for students, $j for auxes, $k for payments */


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
	
</span>
<?php if(isset($_GET['lvl'])): ?>
	<?php foreach($paymodes AS $sel): ?>
		| <a href="<?php echo URL.'soas/soa?lvl='.$lvl.'&mode='.$sel['id']; ?>" ><?php echo strtoupper($sel['code']); ?></a>
	<?php endforeach; ?>
<?php endif; ?>
</h5>



<div class="screen" style="width:30%;float:left;" >
<table class="gis-table-bordered" >
<tr><td>Due</td><td><input id="due" class="vc150 pdl05" type="date" value="<?php echo $ldm; ?>" /></td></td>
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
			><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
	<input type="submit" onclick="redirSoa();" />	
</td>
</tr>
</table>
</div>

<div class="screen" style="width:32%;float:left;"  >
	<?php  
		include_once(SITE.'views/elements/filter_idname.php');
	
	?>
</div>


<div style="float:left;width:20%;" class="screen" id="names" > </div>



<?php 
	
	if(($scid==0) && (!$lvl)){ exit; }

?>


<!-- students loop -->
<?php 
for($i=0;$i<$num_students;$i++): 	
	$student = $students[$i];
	ob_start();	

?>

<!---------------------- page starts ---------------------------->
	<?php include('incs/soa_page.php'); ?>
<!---------------------- page ends ------------------------------>



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
