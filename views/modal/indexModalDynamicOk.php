
<!-- css -->
<style>

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}


</style>





<!-- html -->
<div class="container">


  <h1>W3Schools Modal</h1>



    <!-- Trigger/Open The Modal -->
    <button onclick="openModal('modalAdd')" >Open Add Modal</button>
    <button onclick="openModal('modalEdit')" >Open Edit Modal</button>

    <!-- Modal Add -->
    <div id="modalAdd" class="modal">
      <div class="modal-content">
          <span onclick="closeModal('modalAdd')" class="close">&times;</span>
          <p>Add Modal here..</p>
      </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit" class="modal">
      <div class="modal-content">
          <span onclick="closeModal('modalEdit')" class="close">&times;</span>
          <p>Edit Modal here..</p>
      </div>
    </div>


</div>



<!-- javascript below -->


<script>


var modal;

function closeModal(modalId){
  modal = document.getElementById(modalId);
  modal.style.display = "none";
}

function openModal(modalId){
  modal = document.getElementById(modalId);
  modal.style.display = "block";
}



// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


</script>

