<?php 
// pr($_SESSION['q']);

?>

<h5>
	Code List (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'employees/codelist'; ?>">Edit</a>	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Name</th>
	<th>Username</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['ucid']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>

</tr>
<?php endfor; ?>
</table>

<?php 
$home=$_SESSION['home'];

?>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	nextViaEnter();

	
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


