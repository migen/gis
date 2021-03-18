<!DOCTYPE html>



<html lang="en" >
<head>

<!-- 
	<meta http-equiv="refresh" content="3"/>
-->

	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0 " />
	<meta http-equiv="X-UA-Compatible" content="id=edge" />
	<title>Coding - Fetch Data API</title>
</head>
<body>

	<img id="rainbow" src="" />

	<script>
		var gurl="http://<?php echo GURL; ?>";
		var filename=gurl+"/views/bots/rainbow.jpg";
		console.log('fetching: '+filename);

		catchRainbow();
			
		async function catchRainbow(){
			const response = await fetch(filename);
			const blob = await response.blob();
			document.getElementById('rainbow').src=URL.createObjectURL(blob);
		
		}	<!-- fxn -->
		
		
	
	</script>

</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.0.0/lib/p5.js"></script>