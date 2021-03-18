<?php 
// pr($_SESSION['q']);

// pr($q);

?>


<h5>
	Animal Links 
	| <?php $this->shovel('homelinks'); ?>	
	| <a class="u" onclick="xgetRow();" >xgetRow</a>
	| <a class="u" onclick="xgetCol(<?php echo $id; ?>);" >xgetCol</a>

	
</h5>


<div class="clear" >
<?php 
	$str="";
	foreach($rows AS $row){
		$str.='#'.$row['id'].' - '.$row['name'].', ';
	}
	$str=rtrim($str,", ");
	echo $str;
?>

</div>
<br />

<div class="third bordered" >

<table class="gis-table-bordered" >
<tr>
<th>ID <input class="vc50" id="id" readonly /></th>
<td>
	<input class="pdl05" id="part"   />
	<input type="submit" name="auto" value="Filter" onclick="xgetRowsByPart(limits);return false;" />		
</td>
</tr>

</table>





<div id="names" >names</div>
<?php if($id): ?>

<?php 

// pr($data);
?>

<h4>Animal</h4>
<table class="gis-table-bordered" >
<tr><td><a href="<?php echo URL.'animals/index/'.$id; ?>" >Animal</a></td></tr>
</table>

<?php endif; ?>
</div>

<div class="left vc50 ht100" ></div>

<div class="half bordered ht100" >
<table class="gis-table-bordered " >
<tr><th>#</th><th>ID</th><th>Animal</th></tr>
<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 2; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input class="vc60" id="id-<?php echo $i; ?>" name="posts[<?php echo $i; ?>][animal_id]" value="" ></td>
	<td>
		<input class="vc200 pdl05" id="part-<?php echo $i; ?>" value="<?php  ?>"  />			
		<input type="submit" name="auto" value="Filter" onclick="xfilterByRow(<?php echo $i; ?>);return false;" />
		<button><a class="btn<?php echo $i; ?>" 
			onclick="xsaveRow(<?php echo $i.','.$rows[$i]['id']; ?>);return false;" >Save</a></button>	
	</td>
</tr>
<?php endfor; ?>


</table>


<p><?php $this->shovel('numrows'); ?></p>

</div>



<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='15';
var id="<?php echo $id; ?>";


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/students/links/'+ucid;	
	window.location = url;		
}

function filterAction(id){
	$("#id").val(id);
}


function filterActionByRow(id,rid){
	// alert('id: '+id+', row: '+rid);	
	// $("#id").val(id);
	$('#id-'+rid).val(id);
	
}



function xgetRowsByPart(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xanimals.php';	
	var task = "xgetRowsByPart";	
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) {  
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="filterAction(this.id);return false;" >'+s[i].name+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}		  
    });					
}	/* fxn */


function xfilterByRow(rid,limits=20){
	var part = $('#part-'+rid).val();	
	var vurl = gurl+'/ajax/xanimals.php';	
	var task = "xgetRowsByPart";	
	
	$.ajax({
		url:vurl,dataType:"json",type:'POST',
		data:'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) {
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			console.log(s);
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="filterActionByRow('+s[i].id+','+rid+');return false;" >'+s[i].name+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}





</script>

<?php 
// echo 'URL: '.URL.'<br />'; 
// echo 'GURL: '.GURL; 

?>


<script type="text/javascript" src="<?php echo URL.'views/js/jsAnimals.js'; ?>" ></script>