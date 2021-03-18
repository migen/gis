<?php 

// $localIP = getHostByName(getHostName());
// $localIP = getHostName();

// pr($ip);	
// pr($localIP);	
	
?>


<style>
#names{ 
	width:400px;
    position: fixed;
    background-color: white;
    overflow: auto;	
    top: 120px;
    bottom: 20px;

}

</style>

<!-- ------------------------------------------------------------------------------------------------->

<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */

var gurl = 'http://<?php echo GURL; ?>';
var ip   = '<?php echo $ip; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	// alert(gurl+ip+home);
	hd();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	



function xgetContactsByPart(){
	var part = $('#part').val();
	var vurl = gurl+'/'+home+'/xgetContactsByPart';
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'part='+part,				
		async: true,
		success: function(s) { 
			console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			for (var i = 0; i < cs; i++) {			
				content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirPage(this.id);return false;" >'+s[i].code+'</span> - '+s[i].name+'</p>';
			}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}

function xgetContactByCode(){
	var code = $("#code").val();
	var vurl = gurl+'/'+home+'/xgetContactByCode';
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'code='+code,						
		async: true,
		success: function(s) {
			if(s){
				var rurl = gurl+'/'+home+'/reloading/'+s.id;
				window.location = rurl;					
			} else {
				alert('No record found.');
			}
		
		}
	})


}
 
function redirPage(ucid){
	var url 		= gurl + '/accounts/reloading/' + ucid;	
	window.location = url;		
}

function closeFilter(){
	$('#names').hide();
}

function xgetUcidByTerminal(){
	var url  = gurl+'/ajax/xterminals.php';
	var task = "xgetUcidByTerminal";	
	
	$.ajax({
		url: url,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&ip='+ip,				
		async: true,	
		success: function(y) {
			var rurl = gurl+'/'+home+'/reloading/'+y.id;	
			window.location = rurl;		
		}		
	})

}

</script>

<!------------------------------------------------------------------------------------------------->


<h5 class="screen" > Balance Reloading 
	| <a href="<?php echo URL.$home; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	
</h5>


<!-- 

-->
<div class="hd" id="names" > </div>


<table class="screen gis-table-bordered table-fx" >
	<tr>
		<td class="vc200" ><input name="ucid" id="ucid" class="pdl05 full" value="<?php echo $balance['card_acn']; ?>" readonly /></td>
		<td class="f14 vcenter center" > Card ACN </td>
	</tr>

	<tr>
		<td class="vc200" ><input name="ucid" id="ucid" class="pdl05 full" value="<?php echo $ucid; ?>" readonly /></td>
		<td class="vc100" ><input type="submit" name="find" class="full" onclick="xgetUcidByTerminal();return false;"  value="Scan" /></td>
	</tr>
	
	<tr>
		<td class="vc200" ><input name="code" id="code" class="pdl05 full" placeholder="ID Number" /></td>
		<td class="vc100" ><input type="submit" name="find" class="full" onclick="xgetContactByCode();return false;"  value="Find" /></td>
	</tr>
	<tr>
		<td class="vc200" ><input autofocus name="name" id="part" class="pdl05 full" placeholder="Name in part" /></td>
		<td class="vc100" ><input type="submit" name="find" class="full" onclick="xgetContactsByPart();return false;" value="Filter" /></td>
	</tr>
</table>



<?php if(is_null($ucid)){ exit; } ?>

<?php 

// pr($ucis);

?>

<br />
<form method="POST"  >
<table class="gis-table-bordered table-fx table-altrow"  >
<table class="gis-table-bordered table-fx" >
<tr><th >Photo </th>
<td>
	<img src="data:image/jpeg;base64,<?php echo base64_encode($balance['photo']); ?>" width="150" border="0" /></td>
</tr>
<tr><th class="vc100" >ID Number </th><td class="vc300" ><?php echo $balance['code']; ?></td></tr>
<tr><th >DB ACN </th><td><?php echo $balance['db_acn']; ?></td></tr>
<tr><th>Name</th><td><?php echo $balance['name']; ?></td></tr>
<tr><th>Balance</th><td><input class="pdl05" name="balance[balance]" value="<?php echo $balance['balance']; ?>" readonly ></td></tr>
<tr><th>Reload Amount</th><td><input class="pdl05" name="amount" value="0" ></td></tr>


</table>

<?php
	// if($balance['db_acn']!=$balance['card_acn']){ echo "<h5> ACN mismatch! </h5>"; }
?>
	<p>
		<input type="submit" name="submit" value="Reload"  />
		<button >Cancel</button>
	</p>
	
</form>

