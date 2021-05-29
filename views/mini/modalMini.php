<?php 

  $dbtable=PDBO.".05_levels";

  $this->shovel('modal');


	// pr($_SESSION['q']);

?>

<!-- html -->
<div class="container">


<h5>
  Custom Modal - CRUD
	| <?php $this->shovel('homelinks'); ?>	
	
</h5>

<div align="left">
	<button type="button" name="add" id="add" data-toggle="modal" data-target="#formModal" 
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
			class="btn btn-xs btn-info edit_data" onclick="openEditModal('modalForm',<?php echo $i.', '.$model_id; ?>);return false;" />

		<input type="button" name="view" value="View" id="<?php echo $row['id']; ?>" 
			class="btn btn-xs btn-info view_data" />
	</td>
</tr>
<?php endforeach; ?>
</table>




<br>
    <!-- Trigger/Open The Modal -->
    <button onclick="openModal('modalForm')" >Open Add Modal</button>
    <button onclick="openModal('modalEdit')" >Open Edit Modal</button>

    <!-- Modal Add -->
    <div id="modalForm" class="modal">
      <div class="modal-content">
      <div class="modal-header">
          <button onclick="closeModal('modalForm')" class="close">&times;</button>
          <h5 class="modal-title" id="formModalLabel">Add Level</h5>
        </div>
        <div class="modal-body">
            <form method="POST" id="insert_form">
              <label for="">Level Code</label>			
              <input type="text" name="name" id="code" class="form-control">		
              <label for="">Level Name</label>		
              <input type="text" name="name" id="name" class="form-control">
              <input type="hidden" name="model_id" id="model_id" >	<!-- after debug hidden -->
              <input onclick="saveForm();" type="submit" name="insert" id="insert" value="Insert" 
                class="btn btn-primary" >
            </form>
        </div>
        <div class="modal-footer">
          <button onclick="closeModal('modalForm')" class="close">Close</button>
        </div>
      </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <span onclick="closeModal('modalEdit')" class="close">&times;</span>
          <h2>Edit Modal Header</h2>
        </div>
        <div class="modal-body">
          <p>Edit Some text in the Modal Body</p>
          <p>Some other text...</p>
        </div>
        <div class="modal-footer">
          <h3>Edit Modal Footer</h3>
        </div>
      </div>
    </div>


</div>





<script>

var gurl="http://<?php echo GURL; ?>";
var dbtable="<?php echo $dbtable; ?>";
var code;
var name;
var modelId;


function openModalReference(modalId){
    modal = document.getElementById(modalId);
    modal.style.display = "block";
}

function openEditModal(modalId,i,model_id){

	var vurl = gurl+'/ajax/xdata.php';	
	var task="xgetRowById";
	var pdata='task='+task+'&id='+model_id+'&dbtable='+dbtable;
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:true,
		success: function(s) { 
      code=s.code;
      name=s.name;
      modelId=model_id;

			$('#code').val(code);
			$('#name').val(name);
			$('#model_id').val(model_id);

			// modal
			$('#insert').val('Update');

      modal = document.getElementById(modalId);
      modal.style.display = "block";

		}		  



});				



}	/* fxn */


function saveForm(){
	code = $('#code').val();
	name = $('#name').val();
	var id = $('#model_id').val();
  
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xeditData";
	var pdata="task="+task+"&dbtable="+dbtable+"&code="+code+"&name="+name+"&id="+id;
	// alert(pdata);

	$.ajax({type: 'POST',url: vurl,data: pdata,success:function(){  }  });						  


}	/* fxn */



</script>


