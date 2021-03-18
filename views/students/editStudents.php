<h5>
	Edit Student
	| <a href="<?php echo URL.$home; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'students/links/'.$scid; ?>" >Links</a>
	
	
	
</h5>


<?php // pr($_SESSION['q']); ?>

<table class="gis-table-bordered table-fx" >

<tr><th>Name</th><td><input id="name" value="<?php echo $row['name']; ?>" /></td></tr>
<tr><th>ID No</th><td><input id="code" value="<?php echo $row['code']; ?>" /></td></tr>
<tr><th>LRN</th><td><input id="lrn" value="<?php echo $row['lrn']; ?>" /></td></tr>
<tr><th>Is Male</th><td><input id="is_male" value="<?php echo $row['is_male']; ?>" type="number" min=0 max=1 /></td></tr>
<tr><th>CSY</th><td><input id="csy" value="<?php echo $row['csy']; ?>" type="number" /></td></tr>
<tr><td colspan="2" ><input type="submit" onclick="xeditContact();" /></td></tr>
</table>


<div id="names" >names</div>

<script>
var gurl = "http://<?php echo GURL; ?>";
var hdpass = "<?php echo HDPASS; ?>";
var scid = "<?php echo $scid; ?>";
			
			
$(function(){
	$('#names').hide();
	$('html').live('click',function(){
		$('#names').hide();
	});


})	/* fxn */




function xeditContact(){
	$('#btn').hide();
	/* m for main */
	
if (confirm('Dangerous! Sure?')){
	var name = $('#name').val();
	var code = $('#code').val();
	var lrn = $('#lrn').val();
	var csy = $('#csy').val();
	var is_male = $('#is_male').val();	
	
	var vurl = gurl+'/ajax/xstudents.php';		
	var task = "xeditContact";			
	var pdata  = "task="+task+"&name="+name+"&code="+code+"&account="+code+"&sy="+csy+"&lrn="+lrn;
	pdata += "&is_male="+is_male+"&scid="+scid;	
	$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){ location.reload(); }  });				

}	/* if */
	
	
}	/* fxn */



function redirLookup(ucid){
	var url = gurl + '/products/view/' + ucid;		
	window.location = url;			
}



</script>