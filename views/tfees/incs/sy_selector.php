<?php 

// pr($data);

$sy=$data['sy'];
$repage=$data['repage'];

?>

&nbsp;
| SY <select onchange="redirPsy();" id="psy" >
	
<?php $sy1=DBYR-1;if($sy1>=$_SESSION['settings']['sy_beg']): ?>
	<option value="<?php echo $sy1; ?>" <?php echo ($sy==$sy1)? 'selected':NULL; ?> ><?php echo $sy1 ; ?></option>
<?php endif; ?>
	<option value="<?php echo DBYR; ?>" <?php echo ($sy==DBYR)? 'selected':NULL; ?> ><?php echo DBYR; ?></option>	
<?php $sy2=DBYR+1;if($sy2<=$_SESSION['settings']['sy_end']): ?>
	<option value="<?php echo $sy2; ?>" <?php echo ($sy==$sy2)? 'selected':NULL; ?> ><?php echo $sy2 ; ?></option>
<?php endif; ?>	
</select>	



<script>

var gurl="http://<?php echo GURL; ?>";
var repage="<?php echo $repage; ?>";
var num="<?php echo $num; ?>";


function redirPsy(){
	var psy=$('#psy').val();
	var url=gurl+'/'+repage+'/'+psy+'?num='+num;	
	// alert(url);
	window.location=url;		
}

</script>