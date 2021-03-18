
<h5>
	Add Student Fee
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href='<?php echo URL."bills/add"; ?>'>Cashier</a>			
	
</h5>

<?php 


?>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Student</th><td><?php echo ($scid)? $student['name']:NULL; ?>
</td></tr>
<tr><th>Feetype</th><td>
<select name="post[feetype_id]" class="vc200" onchange="auxThis(this.value);return false;" >
	<option>Choose</option>
	<?php foreach($feetypes AS $sel): ?>
		<option class="<?php echo ($sel['is_discount']==1)? 'red':NULL; ?>" 
			value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
<input class="vc30" name="post[num]" value="1" />
</td></tr>

<tr><th>Amount</th><td><input id="auxamt0" name="post[amount]" value="0" class="vc200 pdl05" /></td></tr>

<tr><th colspan="2" ><input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');"  /></th></tr>
</table>
</form>




<script>

var gurl="http://<?php echo GURL; ?>";
var sy="<?php echo $_SESSION['sy']; ?>";
var tuition = "<?php echo isset($tsum['tuition'])? $tsum['tuition']:0; ?>";

$(function(){


})

function xgetAmount(fid){
	var vurl 	= gurl + '/ajax/xfees.php';	
	var task	= "auxThis";
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,data:'task='+task+'&id='+fid+'&sy='+sy,		
		success: function(s) { 		
			$('#amount').val(parseFloat(s.amount).toFixed(2));			
		}		  
	});					
	

}	/* fxn */




</script>

<script type="text/javascript" src='<?php echo URL."views/js/enroll.js"; ?>' ></script>
