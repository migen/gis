<h5>
	Randomizer
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="randomize('grade');" >Randomize</span>
	| <span class="u" onclick="randomizeLetter('dg');" >Randomize DG</span>
	
</h5>




<?php 


$min=isset($_GET['min'])? $_GET['min']:70;
$max=isset($_GET['max'])? $_GET['max']:99;
$count=isset($_GET['count'])? $_GET['count']:2;




?>

<table class="gis-table-bordered" >
<tr><th>#</th><th>Num</th><th>DG</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>	
	<td><input id="grade<?php echo $i; ?>" class="vc50 center" /></td>
	<td><input id="dg<?php echo $i; ?>" class="vc50 center" /></td>
</tr>
<?php endfor; ?>
</table>







<script>
var gurl="http://<?php echo GURL; ?>";
// var min=70; var max=99; 
// var min=<?php echo $min; ?>;


var min=<?php echo isset($_GET['min'])? $_GET['min']:70; ?>;
var max=<?php echo isset($_GET['max'])? $_GET['max']:99; ?>;
var count=<?php echo isset($count)? $count:10; ?>;

$(function(){

})

		// document.getElementById(aim+i).value=x;				
		// document.getElementById(aim+i).value=x;						
		
function randomize(aim){ for(var i=0;i<count;i++){ var x=getRandomInt(min,max);document.getElementById(aim+i).value=x; }	}	/* fxn */
function getRandomInt(min,max) { return Math.floor(Math.random()*(max-min+1))+min; }


// var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";		
function randomizeLetter(aim){ 
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";var len=possible.length;
	for(var i=0;i<count;i++){ var x=possible.charAt(Math.floor(Math.random()*len));document.getElementById(aim+i).value=x; }	
}	


</script>
