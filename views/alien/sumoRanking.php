<?php 


	// pr($classroom);
	// pr($data);
	// pr($ratings);
	// pr($grades[15]);	
	// pr($course);
	
?>

<h5>

<?php echo "Q$qtr"; ?> Chinese Ranking
| <a href="<?php echo URL.$home; ?>">Home</a>
<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
| <a href='<?php echo URL."aggregates/tally/".$course['crid'].DS.$course['crsid'].DS.$course['subject_id']."/$sy/$qtr"; ?>'>
	Aggregates</a>
| <a href="<?php echo URL."alien/ChineseIndex"; ?>">Chinese Home</a>




<?php if($qtr<5): ?>
	| <a href="<?php echo URL."alien/sumoRanking/$crid/$sy/5"; ?>">FG Ranks</a>
<?php else: ?>	
	| <a href="<?php echo URL."alien/sumoRanking/$crid/$sy/".$_SESSION['qtr']; ?>">Q<?php echo $_SESSION['qtr']; ?> Ranks</a>
<?php endif; ?>	
</h5>

<table class="gis-table-bordered" >
<tr><th class="white bg-blue2" >Classroom</th><td><?php echo $classroom['classroom']; ?></td></tr>
<tr><th class="white bg-blue2" >Chinese Adviser</th><td><?php echo $classroom['chinese_adviser'].' - '.$classroom['chinese_name']; ?></td></tr>
</table>


<p class='brown' >* Subcode is CN2 for Level is semester AND Quarter greater than 2, else CN. </p>

<form method="POST" >
<p>
	<?php echo $grades[0]['student']; ?>
	<input type="hidden" class="vc50" name="one[gid]" value="<?php echo $grades[0]['gid']; ?>" readonly />
	<input type="hidden" class="vc50" name="one[orig]" value="<?php echo $grades[0]['grade']; ?>" readonly />
	<input type="" class="vc50" name="one[grade]" value="<?php echo $grades[0]['grade']; ?>" />
	<span class="hd" ><input onclick="return confirm('Proceed?');" type="submit" name="open" value="open"  /></span>
</p>
</form>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>


<form method="POST"  >
<table class="gis-table-bordered table-fx"  >

<tr class="headrow"  >
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th>Grade</th>
	<th>Rank</th>
</tr>

<?php $processed=true; ?>
<?php $synced=true; ?>
<?php $rank=1; ?>
<?php for($i=0;$i<$count;$i++): ?>

	<?php 
		if(!isset($grades[$i]['sumoscid'])){
			$synced = false;
			break;
		} 
		
		if($grades[$i]['grade']!=$grades[$i]['ave']){
			$processed = false;
		} 
		
	?>
	
	
	<tr class="" >
		<td><?php echo $i+1; ?></td>
		<td><?php echo $grades[$i]['scid']; ?></td>
		<td><?php echo $grades[$i]['student']; ?></td>
		<td><?php echo $grades[$i]['grade']; ?></td>
		<?php // $rank = ($grades[$i]['rank']>0)? $grades[$i]['rank']:$rank; ?>		
		<td><input class="center vc50" name="sumo[<?php echo $i; ?>][rank]" value="<?php echo $rank; ?>"  ></td>
		<?php 
			$j = $i+1;
			$same = $grades[$i]['grade']==@$grades[$j]['grade'];
			if(!$same){ $rank++; }
		?>		
		<td class="<?php echo ($same)? 'red':NULL; ?>" ><?php echo ($same)? 'Tie':NULL; ?></td>
	</tr>
	
	<?php $dg = rating($grades[$i]['grade'],$ratings); ?>	
	<input type="hidden" class="center vc50" name="sumo[<?php echo $i; ?>][dg]" value="<?php echo $dg; ?>"  >	
	<input type="hidden" name="sumo[<?php echo $i; ?>][ave]" value="<?php echo $grades[$i]['grade']; ?>"   />
	<input type="hidden" name="sumo[<?php echo $i; ?>][scid]" value="<?php echo $grades[$i]['scid']; ?>"   />
<?php endfor; ?>

</table>

<div class="hd" >
	<p><button><a class="txt-black no-underline" href='<?php echo URL."alien/delCridSumo/$crid"; ?>' >Delete All</a></button></p>
	<p><button><a class="txt-black no-underline" href='<?php echo URL."alien/syncSumo/$crid"; ?>' >Sync Class On</a></button></p>
	<p><input type="submit" name="submit" value="Rank On"  /></p>
</div>

<?php if(!$synced): ?>
	<p><button><a class="txt-black no-underline" href='<?php echo URL."alien/syncSumo/$crid"; ?>' >Sync Class</a></button></p>
<?php else: ?>


<p><input type="submit" name="submit" value="Rank On"  /></p>	
	<?php if(!$processed): ?>
		<p><input type="submit" name="submit" value="Rank"  /></p>
	<?php else: ?>
		<h2 class="" >Processed!</h2>
	<?php endif; ?>
<?php endif; ?>

</form>



<!------------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	$('#hdpdiv').hide();
	
	
})




</script>




