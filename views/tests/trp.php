<h5>
	TRP
	
</h5>


<table class="gis-table-bordered" >
<?php $i=0; ?>
<tr>
	<td>
	<select class="title" onchange="xgetPriv(this.value,this.id)" id="<?php echo $i; ?>" name="contacts[<?php echo $i; ?>][tid]" >
			<option>Choose One</option>
			<?php foreach($titles AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>	
	
	<td class="" ><input id="tid<?php echo $i; ?>" class="pdl05 vc25" type="text" 
		name="contacts[<?php echo $i; ?>][title]" readonly /></td>
	<td class="" ><input id="role<?php echo $i; ?>" class="pdl05 vc25" type="text" 
		name="contacts[<?php echo $i; ?>][role]" readonly /></td>
	<td class="" ><input id="priv<?php echo $i; ?>" class="pdl05 vc25" type="text" 
		name="contacts[<?php echo $i; ?>][priv]" readonly /></td>	
</tr>


</table>





<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	hd();

	
})






function xgetPriv(tid,i){
	var vurl 	= gurl + '/ajax/xcontacts.php';	
	var task	= "xgetPriv";	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&tid='+tid,				
		async: true,
		success: function(s) { 	
			console.log(s);
			$('#tid'+i).val(s.tid);
			$('#role'+i).val(s.roleid);
			$('#priv'+i).val(s.privid);
		}		  
    });				

	
}	/* fxn */




</script>


