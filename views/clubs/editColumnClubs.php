<?php 

// pr($data); 
// exit;

// pr($rows[0]);
$wt=$crirow['weight'];

?>

<h5>
	Edit Column Clubs (<?php echo $crirow['name']; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/scores/'.$club_id; ?>" >Cancel</a>
	| <span class="u" onclick="traceshd();" >SHD</span>	
	
	
	
</h5>

<?php 
	$srid=$_SESSION['srid'];
	$min=isset($_GET['min'])? $_GET['min']:0;
	$max=isset($_GET['max'])? $_GET['max']:$wt;
?>


<h4 class="<?php echo ($srid!=RMIS)? 'shd':NULL; ?>" >
<table class="gis-table-bordered" >
<tr>
<td>Min<input id="min" class="vc50" value="<?php echo (isset($_GET['min']))? $_GET['min']:$min; ?>" ></td>
<td>Max<input id="max" class="vc50" value="<?php echo (isset($_GET['max']))? $_GET['max']:$max; ?>" ></td>
<td><span class="u" onclick="randomize('grades');" >Randomize</span></td>
<td><span class="u" onclick="gotoUrl();" >RandomizeUrl</span></td>
</tr>
</table>
</h4>


<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="scid" >Scid</th>
	<th>ID No</th>
	<th>Student</th>
	<th>Score<br /><?php echo '('.$crirow['weight'].')'; ?>
		<br /><input id="iscore" class="vc50" />
		
		<br /><button onclick="populateColumn('score');return false;" >All</button>
	</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student_code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td>
		<input id="grades<?php echo $i; ?>" name="posts[<?php echo $i; ?>][score]" value="<?php echo $rows[$i]['cri'.$cri]; ?>" class="vc50 score"  />
		<input name="posts[<?php echo $i; ?>][score_id]" value="<?php echo $rows[$i]['score_id']; ?>" type="hidden"  />
	
	</td>
</tr>
<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save" /></p>

</form>



<script>

var gurl="http://<?php echo GURL; ?>";
var club_id="<?php echo $club_id; ?>";
var cri="<?php echo $cri; ?>";
var min=<?php echo isset($_GET['min'])? $_GET['min']:$min; ?>;
var max=<?php echo isset($_GET['max'])? $_GET['max']:$wt; ?>;
var count=<?php echo isset($count)? $count:10; ?>;


$(function(){
	shd();
	nextViaEnter();
	selectFocused();
	
})

function randomize(aim){ 
	for(var i=0;i<count;i++){ var x=getRandomInt(min,max);document.getElementById(aim+i).value=x; }	
}	/* fxn */

function getRandomInt(min,max) { return Math.floor(Math.random()*(max-min+1))+min; }


function gotoUrl(){
	var min=$('#min').val();var max=$('#max').val();
	var url=gurl+"/clubs/editColumn/"+club_id+"/"+cri+"?min="+min+"&max="+max;
	window.location=url;
}	/* fxn */


</script>
