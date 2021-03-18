<?php 

	// pr($data);


?>


<h5>
	Sections (<?php echo $num_sections; ?>) | 
	<a href="<?php echo URL.$home; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a class="u" onclick="ilabas('addrows')" >Add</a>		
	| <a href="<?php echo URL.'classrooms/level/4'; ?>" /> Classrooms </a>  
	| <a href="<?php echo URL.'sections/set?order=id'; ?>" />By ID</a>  
		
</h5>

<h5 class="brown" >*IMPT #ID: 1-TMP | 2-OUT</h5>


<div class="addrows" style="width:600px;float:left;"  >
<form method="POST" >	<!-- form add -->

<h5> 
	Add Section 
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
</h5>
<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th class="vc100" >Code</th>
	<th class="vc200" >Name</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="sxncode<?php echo $i; ?>" class="full" type="text" name="sections[<?php echo $i; ?>][code]" maxlength="10" /></td>		
	<td><input id="sxn<?php echo $i; ?>" class="full" type="text" name="sections[<?php echo $i; ?>][name]" /></td>
		
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->

<p><?php $this->shovel('numrows'); ?></p>
</div>

<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>#</th>
	<th>SxnID</th>
	<th class="vc100" >Code</th>	
	<th class="vc200" >Name</th>
	<th class="vc50" >Pos</th>
	<th>Manage</th>

</tr>
<tbody>
<?php for($i=0;$i<$num_sections;$i++): ?>
	<tr rel="<?php echo $i; ?>" >
		<td><?php echo $i+1; ?></td>
		<td id="rid<?php echo $i; ?>" ><?php echo $sections[$i]['id']; ?></td>
		<td id="code<?php echo $i; ?>" ><?php echo $sections[$i]['code']; ?></td>
		<td id="name<?php echo $i; ?>" ><?php echo $sections[$i]['name']; ?></td>		
		<td id="pos<?php echo $i; ?>" ><?php echo $sections[$i]['position']; ?></td>		
		<td>
			<!-- if !$is_finalized_criteria -->
			<a href="<?php echo URL.'sections/edit/'.$sections[$i]['id']; ?>" >Edit</a>
		</td>
	</tr>	
<?php endfor; ?>

</tbody>
</table>
<br />

<!------------------------------------------------------------------------->






<!------------------------------------------------------------------------>

<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="sxncode" >Code</option>
	<option value="sxn" >Name</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<div class="clear ht100" >&nbsp;</div>


<!------------------------------------------------------------------------->
<script>
var gurl = "http://<?php echo GURL; ?>";
var sy 	 = '<?php echo $sy; ?>';

$(function(){
	hd();
	nextViaEnter();
	itago('addrows');
	itago('clipboard');
	
});


function xedit(i){
	var row = $('tr[rel="'+i+'"]');	
	var rid  = $('#rid'+i+'').html();
	var code = $('#code'+i+'').html();
	var name = $('#name'+i+'').html();
	var pos = $('#pos'+i+'').html();
		
	row.html('<td id="rid'+i+'">'+rid+'</td><td><input id="code'+i+'" type="text" value="'+code+'"></td><td><input id="name'+i+'" value="'+name+'"></td><td><input class="vc50" id="pos'+i+'" value="'+pos+'"></td><td><input type="button" class="update" id="'+i+'" value="Update" onclick="xupdate(this.id);"><input type="button" value="Cancel" onclick="location.reload();"></td>');
};


function xupdate(i){
	// var vurl 	= gurl + '/mis/xeditSection/'+sy;	
	var vurl  = gurl + '/ajax/xsections.php';	
	var task = 'xeditSection';	
	var row = $('tr[rel="'+i+'"]');	
	
	var rid 	   = $('#rid'+i+'').html();
	var code   = $('#code'+i+'').val();
	var name   = $('#name'+i+'').val();
	var pos   = $('#pos'+i+'').val();
	var pdata = "code="+code+"&name="+name+"&position="+pos+"&id="+rid+"&task="+task+"&sy="+sy;
		
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,async: true,
      success: function(){ 
		row.html('<td id="rid'+i+'">'+rid+'</td><td>'+code+'</td><td>'+name+'</td><td>'+pos+'</td><td></td>'); 
	  } 	    
	});	
	  
};	/* fxn */



function xupdateNOK(i){
	var vurl 	= gurl + '/ajax/xclassrooms.php';	
	var task	= "xeditSection";
	var row = $('tr[rel="'+i+'"]');	
	var rid 	   = $('#rid'+i+'').html();
	var code   = $('#code'+i+'').val();
	var name   = $('#name'+i+'').val();
	var pos   = $('#pos'+i+'').val();
		
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: "code="+code+"&name="+name+"&position="+pos+"&id="+rid,	  	  
	  async: true,
      success: function(){ 
		  row.html('<td id="rid'+i+'">'+rid+'</td><td>'+code+'</td><td>'+name+'</td><td>'+pos+'</td><td></td>'); 
	  } 	  

	  
	});	
	  
};	/* fxn */
	


</script>