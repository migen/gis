<h5>
	Filter Contact Redirect | <?php $this->shovel('homelinks'); ?>
	
	
	
</h5>

<?php

// pr($data);


?>


<form method="POST" >
<table class="gis-table-bordered" >
	<tr>
		<th>ID No. | Name</th>
		<td>
			<input class="pdl05" id="part" autofocus  />
			<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
			<input name="ucid" id="ucid" readonly class="vc50" />
		</td>
	</tr>	
</table>
<br />

<div id="names">names</div>

<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';
var rurl="<?php echo $rurl; ?>";


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });	
	
})

function redirContact(ucid){	
	var url=gurl+'/'+rurl+'/'+ucid;
	window.location=url;

}	/* fxn */





</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

