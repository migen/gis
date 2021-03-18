<?php 
// pr($_SESSION['q']);

?>

<h5>
	Code List (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'employees/codelist?print'; ?>">Print</a>
	| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>

	
	
</h5>

<div class="sixty" >
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Name</th>
	<th>Username</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['ucid']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<input type="hidden" name="posts[<?php echo $i; ?>][ucid]" value="<?php echo $rows[$i]['ucid']; ?>" />
	<td><input class="vc150 codes" value="<?php echo $rows[$i]['code']; ?>" name="posts[<?php echo $i; ?>][code]"
		id="code<?php echo $i; ?>" /></td>
	<td>
		<button onclick="xeditCodename(<?php echo $i.','.$rows[$i]['ucid']; ?>);return false;" 		
			id="csb<?php echo $i; ?>"  >Save</button>	
	</td>
	
</tr>
<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save All" onclick="return confirm('Sure?');"  /></p>
</form>
</div>

<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="code" >Code</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<?php 
$home=$_SESSION['home'];

?>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	nextViaEnter();
	itago('clipboard');

	
})




function xeditCodename(i,ucid){
	$('#csb'+i).hide();		
	var code = $('#code'+i).val();		
	var vurl 	= gurl + '/ajax/xcodename.php';	
	var task	= "xeditCodename";	
	var pdata = "task="+task+"&ucid="+ucid+"&code="+code;
	$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){} });				
	
}	/* fxn */




</script>


