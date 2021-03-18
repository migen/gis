<?php 


$decigrades = $_SESSION['settings']['decigrades'];
$decigenave = $_SESSION['settings']['decigenave'];

	
?>


<h5>
	<?php echo $classroom['name']; ?> QCR Split
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
	| <a href='<?php echo URL."advisers/classroomsIndex"; ?>'>CIR</a>	
	| <a href='<?php echo URL."qcr/qcrall/$crid/$sy/$qtr"; ?>'>Tie</a>
	| <a href='<?php echo URL."qcr/qcrdomino/$crid/$sy/$qtr"; ?>'>Domino</a>
	| <span class="u" onclick="pclass('idno');" >ID No.</span>
	| <a href='<?php echo URL."summext/syncCrid/$crid"; ?>'>Sync SX</a>		
	
	<?php if($is_sem && $derivsem==2): ?>
		<?php if($qtr<5): ?>
			| <a href='<?php echo URL."qcr/qcrall/$crid/$sy/6?split"; ?>'>Sem 2 FG</a>		
		<?php else: ?>
			| <a href='<?php echo URL."qcr/qcrall/$crid/$sy/$sqtr?split"; ?>'>QCR</a>				
		<?php endif; ?>		
	<?php else: ?>
		| <a href='<?php echo URL."qcr/qcrall/$crid/$sy/5?split"; ?>'>FG</a>		
	<?php endif; ?>
	
	
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


<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>


<form method="POST" >
<table class="gis-table-bordered table-fx"  >
<tr class="headrow" >
	<th>#</th>
	<th class="idno" >Scid</th>
	<th class="idno" >ID No.</th>
	<th>Student</th>
	<th>Gen<br />Ave</th>
	<th>Rank</th>	
	<th>Sort</th>	
	<th>Tie</th>	
	<th class="hd" >SCID</th>

</tr>

<?php $i=1; ?>
<?php $rank=0; ?>
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
	<td><?php echo $row['rank']; ?></td>
	
	<?php 
		$rank = (!$tie)? $i:$i+0.5;					
	?>
	<td>
		<?php if($row['rank']!=$rank): ?>		
			<input class="sort center vc50" name="rank[<?php echo $i?>][rank]" value='<?php echo $rank; ?>' >
			<input type="hidden" name="rank[<?php echo $i?>][scid]" value='<?php echo $row['scid']; ?>' >
		<?php endif; ?>
	</td>	
	<td class="<?php echo ($tie)?'red':NULL; ?>" ><?php echo ($tie)?'Tie':NULL; ?></td>
	<td class="hd" ><?php echo $row['scid']; ?></td>
	
</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>


<p>
	<button id="sortBtn" onclick="editRanks();return false;">Sort</button>	
	<input class="sort" type="submit" onclick="return confirm('Proceed?');" name="submit" value="Update"  />
</p>

</form>



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