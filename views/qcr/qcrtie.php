<?php 

if($qtr==7){include_once('qcrtie_oave.php');exit;}

$decigrades = $_SESSION['settings']['decigrades'];
$decigenave = $_SESSION['settings']['decigenave'];
// pr($grades[0]);


?>




<h5>
	<?php echo $classroom['name']; ?> QCR (<?=$count;?>)
	
<span class="hd" >
	<?php if($is_locked): ?>
		| <a href='<?php echo URL."finalizers/openClassroom/$crid/$sy/$qtr"; ?>' >Unlock</a>
	<?php else: ?>
		| <a href='<?php echo URL."finalizers/closeClassroom/$crid/$sy/$qtr"; ?>' >Lock</a>
	<?php endif; ?>				
</span>


<span class="brown u" ondblclick="tracepass();" >	
	<?php echo ($qtr>4)? 'Final':"Q$qtr"; ?> 
	<?php echo ($qtr==6)? ':2nd Sem':NULL; ?> 	
	<?php if($qtr<5){ echo ($is_locked)? 'Locked':'Open'; } ?>
	
</span>		
	| <?php $this->shovel('homelinks'); ?>	
	| <a href='<?php echo URL."sir/classroom/$crid/$sy/$qtr"; ?>'>SIR</a>		
	| <a href='<?php echo URL."qcr/qcrall/$crid/$sy/$qtr?split"; ?>'>Split</a>		
	| <a href='<?php echo URL."qcr/qcrdomino/$crid/$sy/$qtr"; ?>'>Domino</a>				
	| <span class="u" onclick="pclass('idno');" >ID No.</span>
	| <a href='<?php echo URL."summext/syncCrid/$crid"; ?>'>Sync SX</a>		
	<?php if($qtr==7): ?>
		| <a href="<?php echo URL.'qcr/retallyQ7/'.$classroom['id']; ?>">Retally Oave</a>
	<?php endif; ?>
	
	<?php if($is_sem && $derivsem==2): ?>
		<?php if($qtr<5): ?>
			| <a href='<?php echo URL."qcr/qcrall/$crid/$sy/6"; ?>'>Sem 2 FG</a>		
		<?php else: ?>
			| <a href='<?php echo URL."qcr/qcrall/$crid/$sy/$sqtr"; ?>'>QCR</a>				
		<?php endif; ?>		
	<?php else: ?>
		| <a href='<?php echo URL."qcr/qcrall/$crid/$sy/5"; ?>'>FG</a>		
	<?php endif; ?>
	
	<?php if($is_sem && $derivsem==2): ?>
		| <a href='<?php echo URL."qcr/qcrall/$crid/$sy/7"; ?>'>Oave</a>		
	<?php endif; ?>	
	
	<?php // echo ($classroom['is_sem'])? 'sem':'annual'; ?>
	
</h5>

<h4>
	<?php 
		$d['crid'] 	= $crid;
		$d['sy'] 	= $sy;
		$d['qtr'] 	= $qtr;
		$d['sem'] 	= isset($sem)? $sem:0;
		$d['admin'] = isset($admin)? $admin:false;
		$this->shovel('cir',$d); 
	?>
</h4>


<p><?php $this->shovel('hdpdiv'); ?></p>


<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th class="idno" >Scid</th>
	<th class="idno" >ID No.</th>
	<th>Student</th>
	<th>Gen<br />Ave</th>
	<th>Rank</th>	
	<th>Sort</th>	
	<th>Tie</th>	

</tr>

<?php $i=1; ?>
<?php $rank=1; ?>
<?php foreach($grades AS $row): ?>
<?php 
	$s = $i-1;
	$t = $i;
	$mine = $grades[$s]['ave'];
	$next = @$grades[$t]['ave'];
	$tie = ($mine==$next)? true:false;
?>
<tr>
	<td><?php echo $i; ?></td>
	<td class="idno" ><?php echo $row['scid']; ?></td>
	<td class="idno" ><?php echo $row['studcode']; ?></td>
	<td><?php echo $row['student']; ?></td>
	<td><?php echo number_format($row['ave'],$decigenave); ?></td>
	<td class="center" ><?php echo $row['rank']+0; ?></td>
	<td>
		<?php if($row['rank']!=$rank): ?>		
			<input class="sort center vc50" name="rank[<?php echo $i?>][rank]" value='<?php echo $rank; ?>' >		
			<input type="hidden" name="rank[<?php echo $i?>][scid]" value='<?php echo $row['scid']; ?>' >	
		<?php endif; ?>	<!-- not equal ranks -->
	</td>		
	<?php 
		$rank = (!$tie)? $rank+1:$rank;							
	?>

	<td class="<?php echo ($tie)?'red':NULL; ?>" ><?php echo ($tie)?'Tie':NULL; ?></td>	
</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>

<br />

<p>
	<button id="sortBtn" onclick="editRanks();return false;">Sort</button>	
	<input class="sort" type="submit" onclick="return confirm('Proceed?');" name="submit" value="Update"  />
</p>

<?php if($_SESSION['user']['privilege_id']==0): ?>
	<p class="" >
		<button id="sortBtn" onclick="editRanks();return false;">Sort On</button>	
		<input class="sort" type="submit" onclick="return confirm('Proceed?');" name="submit" value="Update On"  />
	</p>
<?php endif; ?>

</form>


<div class="ht100" ></div>


<!------------------------------------------------------------------------------------------------------------------------------->



<script>
	var gurl     = 'http://<?php echo GURL; ?>';
	var hdpass = '<?php echo HDPASS; ?>';
	var qtr = "<?php echo $qtr; ?>";

	$(function(){	
		columnHighlighting();	
		nextViaEnter();	
		selectFocused();
		$('#hdpdiv').hide();
		hd();
		$('.idno').hide();
		$('.sort').hide();
		$('#cancelBtn').hide();	
		
		
	});

	function editRanks(){
		$('#sortBtn').toggle();	
		$('#cancelBtn').toggle();	
		$('.sort').toggle();	
	}
	
	
</script>