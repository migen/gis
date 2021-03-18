<?php 

pr($_SESSION['q']);

?>

<style>

/* colors */
.dark-blue{ color:blue; }
.red{ color:red; }
.headcolor > th { background-color:blue; color:#fff; }
.bg-yellow { background-color:#ffff4e; } 
.violet { color:#ee82ee; } 
.bg-violet { background-color:#ee82ee; } 
.bg-green { background-color:#66ff66; } 
.bg-pink { background-color:pink; } 
/* colors */

.catwrapper{ width: 1000px;border:1px solid blue;height:180px;padding:6px;}
.catbox{ width: 200px;height:50px;border:1px solid black;float:left;margin:4px; }


</style>

<html>
<head>
<title>Drag</title>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<script src="<?php echo URL.'views/js/jquery.js'; ?>" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.8.20/jquery-ui.min.js" type="text/javascript"></script>
</head>
<body>

<div class="catwrapper" >
<div class="row" >
	<button class="catbox bg-blue" onclick="menToHundred();return false;" >Test</button>
</div>

<?php foreach($rows AS $row): ?>
<?php 
	$id=$row['id'];$position=$row['position'];$color=$row['color'];$name=$row['name'];
?>
<div style="margin-right:20px;padding:0;" class="row" id="div<?php echo $id; ?>" 
	ondrop="drop(event)" ondragover="allowDrop(event)" >
	<button class="catbox bg-<?php echo $color; ?>" draggable="true" ondragstart="drag(event)" id="<?php echo $id; ?>" >
		<span>&nbsp;<?php echo $position; ?></span> &nbsp;<?php echo $name; ?>
	</button>		
</div>


<?php endforeach; ?>
</div>
</body>


<script>
	var row = 0;
	var gurl="http://<?php echo GURL; ?>";
	$('#flashMessage').fadeOut(2000);


// draggable

	function getDraggable(){
		vurl = gurl+'/ajax/xdrag.php';
		var task = "xgetPTdraggable";
		$.ajax({
			url: vurl,
			type: "POST",
			async: true,
			data: 'task='+task,
			success: function(data){
				$(".cat-btn").html(data);
				$("#btn-edit").html('<div class="btn btn-success pull-right" onclick="reload();"><span class="fa fa-save"></span></div><div class="btn mr-2 btn-danger pull-right" ondrop="hideProdtype(event)" ondragover="allowDrop(event)" onclick="getDeletedPT()"><span class="fa fa-trash"></span></div>');
			}
		});
	}

	function reload(){
		location.reload()
	}

	function allowDrop(ev) {
    	ev.preventDefault();
	}

	function drag(ev) {
	    ev.dataTransfer.setData("src", ev.target.id);
	}

	function drop(ev) {
	    ev.preventDefault();
	    var src = document.getElementById(ev.dataTransfer.getData("src"));
	    var srcParent = src.parentNode;

	    var tgt = ev.currentTarget.firstElementChild;
	    var tgtFirstChild = tgt.firstElementChild

	    /* Swaps the button */ 
	    ev.currentTarget.replaceChild(src, tgt);
	    srcParent.appendChild(tgt);
	    
	    /* Swaps the position number */
	    tgt.replaceChild(src.firstElementChild, tgt.firstElementChild)
	    src.prepend(tgtFirstChild)

	    var posDrag = parseInt(src.firstElementChild.textContent);
	    var idDrag = parseInt(src.parentNode.firstElementChild.id);
	    updatePosition(posDrag, idDrag);

	    var posDrop = parseInt(tgt.firstElementChild.textContent);
	    var idDrop = parseInt(srcParent.firstElementChild.id);
	    updatePosition(posDrop, idDrop);
	}

	function updatePosition(pos, id){
		vurl = gurl+'/ajax/xdrag.php';
		var task = "xupdatePosition";
		$.ajax({
			url: vurl,
			type: "POST",
			async: true,
			data: 'task='+task+'&id='+id+'&pos='+pos,
			success: function(){}
		});
	}

	function hideProdtype(ev){
		ev.preventDefault();
		var src = document.getElementById(ev.dataTransfer.getData("src"));
		var srcId = parseInt(src.id)

		vurl = gurl+'/ajax/xdrag.php';
		var task = "xhidePt";
		$.ajax({
			url: vurl,
			type: "POST",
			async: true,
			data: 'task='+task+'&id='+srcId,
			success: function(data){
				src.parentNode.remove();
				getDeletedPT(); /* reload the deleted div */
			}
		});
	}

	function displayProdtype(ev){
		ev.preventDefault();
		var src = document.getElementById(ev.dataTransfer.getData("src"));
		var srcId = parseInt(src.id)

		vurl = gurl+'/ajax/xdrag.php';
		var task = "xshowPt";
		$.ajax({
			url: vurl,
			type: "POST",
			async: true,
			data: 'task='+task+'&id='+srcId,
			success: function(data){
				getDraggable(); /* reload the draggable div */
				getDeletedPT(); /* reload the deleted div */
			}
		});
	}

	function getDeletedPT(){
		vurl = gurl+'/ajax/xdrag.php';
		var task = "getDeletedProdtypes";
		$.ajax({
			url: vurl,
			type: "POST",
			async: true,
			data: 'task='+task,
			success: function(data){
				$('#deletedPt').html(data);
			}
		});
	}

	function menToHundred(){
		vurl = gurl+'/ajax/xdrag.php';
		var task = "menToHundred";
		$.ajax({
			url: vurl,type: "POST",async: true,data: 'task='+task,
			success: function(){ }
		});
	}




	</script>
</html>