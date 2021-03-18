<html>
<head>

<style>

html{
	
}

.left{
	text-align:left;
}

body{
	width:100%;
	background:#ddd;
	margin:0 auto;
	
}

.tblgrades{
	font-size:0.8em;
}

.page{
	background:#eee;
    position:relative;
    width: 816px;
    height: 1056px;	
	border:1px solid black;
}


.tblbordered { border: 1px solid #dddddd; border-left: 0; border-top: 0; }
.tblbordered th, .tblbordered td { 
	border-left: 1px solid #dddddd;  
	border-top: 1px solid #dddddd; 
	padding:1px 2px; }
.tblbordered th {color:#181818; }


.u{
	text-decoration:underline;
}

</style>



</head>
<body>
<div id="container" >


	<?php foreach($classrooms AS $cr): ?>
		<div class="page" >
		
			<h1>Transcript</h1>
			<?php echo $cr['name']; ?>
			<table class="tblbordered tblgrades" style=""  >
				<tr>
					<th class="left" >Subject</th>
					<th class="left" >Grade</th>
				</tr>
				
				<tr>
					<td>Math</td>
					<td>92</td>
				</tr>
				<tr>
					<td>Math</td>
					<td>92</td>
				</tr>
				
				
			</table>
			
			
		
			<p class='pagebreak u'>&nbsp; </p>			
				
		
		</div>	<!-- page -->
	

	<?php endforeach; ?>	<!-- foreach classrooms -->




<?php 

// pr($data1);
// pr($classrooms);

?>







</div>
</body>
</html>