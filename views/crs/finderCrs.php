<?php 
$dbtable=PDBG.'.`05_courses`';

?>



<h5>
	
	Course Finder
	| <?php $this->shovel('homelinks'); ?>
	
	


</h5>



<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Name</th>
</tr>


<?php $count=isset($_POST['numrows'])? $_POST['numrows']:1; ?>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input class="vc50" id="id-<?php echo $i; ?>" ></td>
	<td>
		<input class="vc100 pdl05" id="part-<?php echo $i; ?>" value="<?php  ?>" />		
		<input type="submit" name="auto" value="Filter" onclick="xgetDataByPartRow(<?php echo $i; ?>);return false;" />	
	</td>
</tr>
<?php endfor; ?>
</table>


<p><?php $this->shovel('numrows'); ?></p>


<div class="hd" id="names" >names</div>



<script>
var gurl = "http://<?php echo GURL; ?>";
var hdpass = "<?php echo HDPASS; ?>";
var dbtable = "<?php echo $dbtable; ?>";

		
$(function(){
	hd();	
	$('#hdpdiv').hide();
	$('html').live('click',function(){
		$('#names').hide();
	});
	
	
})



function redirContact(pcid,rid){	
	$('input[name="posts['+rid+'][tcid]"]').val(pcid);		
}	/* fxn */


function xeditTcid(i,crsid){
	$('#btn'+i).hide();
	var tcid=$('#tcid'+i).val();
	var vurl 	= gurl + '/ajax/xcourses.php';	
	var task	= "xeditTcid";	
	var pdata = "task="+task+"&crsid="+crsid+"&tcid="+tcid;		
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,
	  success:function(){} 
   });				
	
}	/* fxn */


function xgetTeacher(i){
	var code = $('#tcode'+i).val();
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";			
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&code='+code,async: true,
		success: function(s) { 	$('#tcid'+i).val(s.id); }		  
    });				
		
}	/* fxn */

function sayHi(str){
	// alert("Hi "+escape(str));
	alert(dbtable);
	
}

</script>



<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>






