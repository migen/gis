<?php 


$decigrades = $_SESSION['settings']['decigrades'];
$decigenave = $_SESSION['settings']['decigenave'];
// pr($decigenave);
// pr($classroom);	

?>


<h5>
	<?php echo $classroom['name']; ?> QCR  (<?=$count;?>)
	
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
	<?php echo ($is_locked)? 'Locked':'Open'; ?>
</span>	
	
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."qcr/qcrall/$crid/$sy/$qtr?split"; ?>'>Split</a>		
	| <a href='<?php echo URL."qcr/qcrdomino/$crid/$sy/$qtr"; ?>'>Domino</a>				
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
<table class="gis-table-bordered table-fx"  >
<tr class="headrow" >
	<th>#</th>
	<th>Student</th>
	<th>Sem1</th>
	<th>Sem2</th>
	<th>OAve</th>
	<th>Rank</th>	
	<th>Sort</th>	
	<th>Tie</th>	
	<th class="hd" >SCID</th>
	<th class="hd" >Sumid</th>

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
	<td><?php echo $row['student']; ?></td>
	<td><?php echo number_format($row['ave_q5'],$decigenave); ?></td>
	<td><?php echo number_format($row['ave_q6'],$decigenave); ?></td>
	<td><?php echo number_format($row['ave'],$decigenave); ?></td>
	<td><?php echo $row['rank']; ?></td>
	<td><input class="sort center vc50" name="rank[<?php echo $i?>][rank]" value='<?php echo $rank; ?>' ></td>		
	<?php 
		$rank = (!$tie)? $rank+1:$rank;							
	?>

	<td class="<?php echo ($tie)?'red':NULL; ?>" ><?php echo ($tie)?'Tie':NULL; ?></td>
	<td class="hd" ><?php echo $row['scid']; ?></td>
	<td class="hd" ><?php echo $row['sumid']; ?></td>
	
	<input type="hidden" name="rank[<?php echo $i?>][sumid]" value='<?php echo $row['sumid']; ?>' >
</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>

<?php if(!$is_locked): ?>	
	<p>
		<button id="sortBtn" onclick="editRanks();return false;">Sort</button>	
		<input class="sort" type="submit" onclick="return confirm('Proceed?');" name="submit" value="Update"  />
	</p>
<?php else: ?>	
	<p class="hd" >
		<button id="sortBtn" onclick="editRanks();return false;">Sort On</button>	
		<input class="sort" type="submit" onclick="return confirm('Proceed?');" name="submit" value="Update On"  />
	</p>
<?php endif; ?>	

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
		$('.sort').hide();
		$('#cancelBtn').hide();	
		
		
	});

	function editRanks(){
		$('#sortBtn').toggle();	
		$('#cancelBtn').toggle();	
		$('.sort').toggle();	
	}
	
	
</script>