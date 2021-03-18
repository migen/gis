


<br />
<br />
<br />


Src: <input id="src" value=100 > <br />
One: <input id="one" value=0 onkeypress="alert(this.value)" > <br />
<input type="submit" vale="Copy" onclick="copyToOne();return false;" > <br />
Two: <input id="two" value=0 > <br />



<script>


function copyToOne(){
	var src = $('#src').val();
	$('#one').val(src);
	copyToTwo();
	
}


function copyToTwo(){
	var one = $('#one').val();
	$('#two').val(one);
	
	
}



</script>