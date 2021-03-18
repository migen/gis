<link rel="stylesheet" type="text/css" href="<?php echo URL.'views/css/incs/style_tabs.css'; ?>">

<!-- Tab links -->


<div class="tab">  
  <button class="tablinks" onclick="openTab(event, 'tab1')">Tab 1</button>
  <button class="tablinks" onclick="openTab(event, 'tab2')">Tab 2</button>
  <button class="tablinks" onclick="openTab(event, 'tab3')" id="defaultOpen" >Tab 3</button>  
  
</div>

<!-- Tab content -->
<div id="tab1" class="tabcontent" >
	<h5>London Tab 1</h5>
	<p>London is the capital city of England.</p>
	<span onclick="this.parentElement.style.display='none'">x</span>   
</div>

<div id="tab2" class="tabcontent">
	<h5>Paris Tab 2</h5>
	<p>Paris is the capital of France.</p> 
	<span onclick="this.parentElement.style.display='none'">x</span>   
</div>

<div id="tab3" class="tabcontent" >
	<span onclick="this.parentElement.style.display='none'">x</span>   
	<h5>Shanghai Tab 3</h5>
	<p>Tokyo is the capital of Japan.</p>
</div>


<script>



function openTab(evt, tabName) {
	var i,tabcontent,tablinks;
	tabcontent=document.getElementsByClassName("tabcontent");
	var len=tabcontent.length;	
	for(i=0;i<len;i++) { tabcontent[i].style.display="none"; }
	tablinks=document.getElementsByClassName("tablinks");	
	for(i=0;i<len;i++) { tablinks[i].className=tablinks[i].className.replace(" active",""); }
	document.getElementById(tabName).style.display="block";
	evt.currentTarget.className+=" active";
    
}	/* fxn */


	document.getElementById("defaultOpen").click();



</script>
