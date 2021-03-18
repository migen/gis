
<h5>
	Transmutation
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'lookups/descriptions?ctype='.$ctype; ?>" />Descriptions</a>  	
</h5>

<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?>
<script>
	
function redirCtype(){
	var vurl = gurl+"/lookups/equivalents?ctype="+$('#ctype').val()+"&dept="+$('#dept').val();
	window.location = vurl;		
}	/* fxn */
	
</script>


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="" >
	<th style="width:50px;" >#</th>
	<th style="width:80px;" class="" >Floor</th>
	<th style="width:80px;" class="" >Ceiling</th>
	<th style="width:80px;" class="" >Transmuted<br />Grade</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="" ><?php echo $equivalents[$i]['floor']; ?></td>
	<td class="" ><?php echo $equivalents[$i]['ceiling']; ?></td>
	<td class="" ><?php echo $equivalents[$i]['equivalent']; ?></td>
</tr>
<?php endfor; ?>
</table>



<script>
var gurl 	= 'http://<?php echo GURL; ?>';



</script>
