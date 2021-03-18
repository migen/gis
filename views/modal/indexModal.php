<html>
<head><title>Modal</title>
<script src="<?php echo URL.'views/js/jquery.js'; ?>" ></script>
<style>
#modalBtn{ background:#ccc;display:inline-block;border:1px solid black;padding:3px; }
#simpleModal{
	position:fixed;
	z-index:1;
	left:0;top:0;
	height:100%;width:100%;
	overflow:auto;
	background-color:rgba(0,0,0,0.5); 
	
	
}
#modalContent{
	background:#f4f4f4;
	margin:20% auto;
	padding:20px;
	width:70%;
	min-height:200px;
	box-shadow:0 5px 8px 0 #ccc,0 7px 20px 0 #ccc;
	
	
}



</style>
</head>
<body>
<div id="modalBtn" >Modal Here</div>

<a href="<?php echo 'modal/pages'; ?>" >modal pages</a>



<div id="simpleModal" class="modal" >
	<div id="modalContent" >
		<h5>Modal Title</h5>
		<p>some model text here</p>
	</div>
</div>

<script>

var modalBtn=document.getElementById("modalBtn");

$(function(){
	$("#simpleModal").hide();
	
	
})

modalBtn.addEventListener("click",openModal);

function openModal(){
	$("#simpleModal").show();
	
}





</script>

</body>
</html>