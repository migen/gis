<?php 
// pr($rows[0]);

$dbtable=PDBO.".05_levels";


?>

<div class="containered" >

<h5>
	Custom Modal - Levels
	| <?php $this->shovel('homelinks'); ?>	
	| <a href="<?php echo URL.'mis/levels'; ?>">*Levels</a> 	
	| <a href="<?php echo URL.'levels/set'; ?>" >Full</a>	
	| <?php $this->shovel('links_gset'); ?>
	
</h5>

<div align="left">
	<button type="button" name="add" id="add" onclick="toggle('#modal');" 
		class="btn btn-primary btn-xs " />Add</button>
</div>
<br>
<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th width="10%" >ID</th>
<th width="20%" >Code</th>
<th width="50%" >Level</th>
</tr>

<?php foreach($rows AS $i => $row): ?>
<?php $model_id = $row['id']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['code']; ?></td>
	<td><?php echo $row['name']; ?></td>
	<td>
		<input type="button" name="edit" value="Edit" id="<?php echo $row['id']; ?>" 
			class="btn btn-xs btn-info edit_data" onclick="openEditModal(<?php echo $i.', '.$model_id; ?>);return false;" />

		<input type="button" name="view" value="View" id="<?php echo $row['id']; ?>" 
			class="btn btn-xs btn-info view_data" />
	</td>
</tr>
<?php endforeach; ?>
</table>


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form method="POST" id="insert_form">
			<label for="">Level Code</label>			
			<input type="text" name="name" id="code" class="form-control">		
			<label for="">Level Name</label>		
			<input type="text" name="name" id="name" class="form-control">
			<input type="text" name="model_id" id="model_id" >	<!-- after debug hidden -->
			<input type="submit" name="insert" id="insert" value="Insert" 
				class="btn btn-primary" >
		</form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



</div>	<!-- container -->

<script>

var gurl="http://<?php echo GURL; ?>";
var dbtable="<?php echo $dbtable; ?>";


$(function(){

    alert(123);

})

function enterStudcode(dbtable){
    $('#part').bind("keydown",function(e) {
        if (e.which == 13) {
            e.preventDefault();
			var part=$('#part').val();
			var vurl = gurl+'/ajax/xdata.php';	
			var task = "xgetIdByCode";
			var pdata='task='+task+'&part='+part+'&dbtable='+dbtable;
			$.ajax({
				url:vurl,dataType:"json",type:"POST",
				data:pdata,async:true,
				success: function(s) {  
					var scid=s.id;
					var url=gurl+"/enrollment/ledger/"+scid+"/"+sy;
					window.location=url;
				}		  
			});												
        }
    });
	
}	/* fxn */


function openEditModal(i,model_id){

	// alert(`row: ${i} | id: ${model_id}`);

	var vurl = gurl+'/ajax/xdata.php';	
	var task="xgetRowById";
	var pdata='task='+task+'&id='+model_id+'&dbtable='+dbtable;
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:true,
		success: function(s) { 
			$('#code').val(s.code);
			$('#name').val(s.name);
			$('#model_id').val(model_id);

			// modal
			$('#insert').val('Update');
			$('#modal').modal('show');
		}		  

    });				




}	/* fxn */




</script>

