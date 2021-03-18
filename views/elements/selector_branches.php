<?php 

$branches=$data['branches'];
$brid=$data['brid'];

// pr("brid at selector: ".$brid);

?>


<select id="brid" name="brid" onchange="resessionizeBrid(this.value);" >
	<option >Choose One</option>
	<?php foreach($branches AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($brid==$sel['id'])? 'selected':NULL; ?> >
			<?php echo $sel['name']." #".$sel['id']; ?></option>
	<?php endforeach; ?>
</select>



<script>

var purl="http://<?php echo GURL; ?>";


function resessionizeBrid(brid){
	var vurl=purl+"/ajax/xbrid.php";
	var task="resessionizeBrid";
	$.ajax({
		url:vurl,type:"POST",data:"task="+task+"&brid="+brid,
		success:(function(){ alert("Branch ID / Brid changed to "+brid+"!"); })		
	})	/* ajax */
}	/* fxn */


</script>