<script>

var cbin = "<?php echo JSCBIN; ?>";
// var file=cbin+'subdept.txt';
// var cbin="haha";
// var file="file:///C:/system files/bin/subdept.txt";
var file="C://system files//bin//subdept.txt";

$(function(){
	// alert(cbin);
	// alert(file);
	aaa();
	// bbb();
	
	
	
})




function bbb(){

	document.getElementById("file").onchange = function(){
		var reader = new FileReader();
		reader.onload = function(e) {
			var data = e.target.result;
			
			data = data.replace("data:text/plain;base64,","");

			document.getElementById("data").innerHTML = window.atob(data);
		};
		reader.readAsDataURL(this.files[0]);
	};


}	/* fxn */




</script>

<h5>Mac</h5>

<input type="file" id="file" />


<div id="data" >data</div>
