<?php 


$this->shovel('modal');

?>

<!-- html -->
<div class="container">


  <h1>W3Schools Modal</h1>



    <!-- Trigger/Open The Modal -->
    <button onclick="openModal('modalAdd')" >Open Add Modal</button>
    <button onclick="openModal('modalEdit')" >Open Edit Modal</button>

    <!-- Modal Add -->
    <div id="modalAdd" class="modal">
      <div class="modal-content">
      <div class="modal-header">
          <span onclick="closeModal('modalAdd')" class="close">&times;</span>
          <h2>Add Modal Header</h2>
        </div>
        <div class="modal-body">
          <p>Add Some text in the Modal Body</p>
          <p>Some other text...</p>
        </div>
        <div class="modal-footer">
          <h3>Add Modal Footer</h3>
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



