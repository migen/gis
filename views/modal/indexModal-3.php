
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

  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  animation-name: animatetop;
  animation-duration: 0.5s

}

/* Add Animation */
@-webkit-keyframes animatetopFail {
  from {top:-300px; opacity:0} 
  to {top:0; opacity:1}
}

@-webkit-keyframes animatetop 
{
    0%   {top:0px;}
    25%  {top:200px;}
    50%  {top:100px;}
    75%  {top:200px;}
    100% {top:0px;}
}

@keyframes animateTop
{
    0%   {top:0px;}
    25%  {top:200px;}
    50%  {top:100px;}
    75%  {top:200px;}
    100% {top:0px;}
}


@keyframes animatetopFail {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
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

.modal-header {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
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

