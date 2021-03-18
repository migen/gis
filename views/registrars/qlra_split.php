



<?php 


// $this->shovel('border');

$decigrades = $_SESSION['settings']['decigrades'];
$decigenave = $_SESSION['settings']['decigenave'];
$deciranks  = $_SESSION['settings']['deciranks'];


$is_name = ($get_name=='c.name')? true:false;
$sqtr = $_SESSION['qtr'];


?>
<!---------------------------------------------------------------------------------------------------------------------------------->


<h5>
	<span class="" ><?php echo $level['level']; ?> Batch Ranking SPLIT - <?php echo ucfirst($qf); ?></span>	
	| <a href="<?php echo URL; ?>registrars">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	<?php if($qf=='q4'): ?>
		| <a href="<?php echo URL.'registrars/qlra/'.$level_id.DS.$sy.'/5'; ?>">Final</a>	
	<?php else: ?>
		| <a href="<?php echo URL.'registrars/qlra/'.$level_id.DS.$sy.'/'.$sqtr; ?>"><?php echo 'Q'.$sqtr; ?></a>			
	<?php endif; ?>
	| <a href="<?php echo URL.'registrars/qlr/'.$level_id.DS.$sy.DS.$qtr; ?>">Honors Ranking</a>		
	| <?php $this->shovel('orderjs'); ?>		
	
	<?php if($split): ?>
		| <a href='<?php echo URL."registrars/qlra/$level_id/$sy/$qtr"; ?>'  >Tie</a>
	<?php else: ?>
		| <a href='<?php echo URL."registrars/qlra/$level_id/$sy/$qtr&split"; ?>'  >Split</a>
	<?php endif; ?>	
	
	<?php if($continuous): ?>
		| <a href='<?php echo URL."registrars/qlra/$level_id/$sy/$qtr"; ?>'  >Tie</a>
	<?php else: ?>
		| <a href='<?php echo URL."registrars/qlra/$level_id/$sy/$qtr&continuous"; ?>'  >Continuous</a>
	<?php endif; ?>
	
	<span class="sort"  > | 123 Editable (Sum.Rank_Level_Ave) </span>
	
	
</h5>



<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>


<?php 



$aveq 		= 'ave_q'.$qtr;
$is_tied 	= false;
$dqval	  	= '0';


	
?>


<form method="POST" >

<!-- ============================= HONORS  ==================================================================== -->

<div style="witdh:70%;float:left;" >	<!-- left -->
<h5>  
	<?php echo ($is_name)? 'By Name':'By GenAve'; ?>
	| <span class="blue u" onclick="ilabas('clipboard');" >Paste</span>
	| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>	
</h5>

<p>
	<button id="sortBtn" onclick="editRanks();return false;">Sort On</button>
	<input class="sort" type="submit" name="submit" value="Update On"  >
</p>

<div class="half" >
<table class='gis-table-bordered table-fx'>
<thead>
	<!-- row 1 data subjects iterator -->
	<tr class='bg-blue2'>
	<th class="vc30" >#</th>
	<th class="" >SCID</th>
	<th class="vc120" >Code</th>
	<th class="vc400" ><a href="<?php echo URL.'registrars/qlra/'.$level['id'].DS.$sy.DS.$qtr.'?sortby=c.name'; ?>" >Student</a></th>
	<th class="vc100 center" >Classroom</th>
	<th><a href="<?php echo URL.'registrars/qlra/'.$level['id'].DS.$sy.DS.$qtr.'?sortby=sum.'.$aveq; ?>" ><?php echo ucfirst($aveq); ?></a></th>
	
	<th class="vc50 center" >Rank</th>
	<th class="vc50 sort center" >Sort</th>
	<th class="vc50" >Tie</th>
	<th class="hd" >SCID</th>
	<th class="hd" >CrR</th>
	</tr>
</thead>

<tbody>

<!-- row 1 grades iterator,$s for students,$g for grades -->

<?php $rank = 1; ?>
<?php for($s=0;$s<$num_students;$s++): ?>

<?php $t = $s+1; ?>
<?php $qualified = true; ?>

		<?php 
							
			$t = $s+1;
			$same = $students[$s]['ave_'.$qf]==@$students[$t]['ave_'.$qf];					
			if($continuous){
				$rank++;				
			} else {
				if(!$same){ $rank++; }				
			}

			$rank = (!$same)? $t:$t+0.5;					
			
				
		?>		


		<tr>
			<td><?php echo $t; ?></td>
			<td><?php echo $students[$s]['scid']; ?></td>
			<td><?php echo $students[$s]['student_code']; ?></td>
			<td><?php echo $students[$s]['student']; ?></td>			
			<td><?php echo $students[$s]['classroom']; ?></td>			

						
			<!-- db summaries ave_qqtr -->		
			<td class="center" ><?php echo number_format($students[$s][$aveq],$decigenave); ?></td>	

			<!-- rank -->
		<?php if($qtr<5): ?>					
			<?php if(!$is_name): ?>
				<td class="right" ><?php echo number_format($students[$s]['rank_level_ave_'.$qf],$deciranks); ?></td>								
				<td class="sort <?php echo ($is_tied)? 'bg-red' : null; ?>" > 
					<input id="aim<?php echo $s; ?>" class="vc50 center <?php echo ($is_tied)? 'red':null; ?>" 
						name="rank[<?php echo $s; ?>][qtr]" value="<?php echo $rank; ?>"  />
					<?php $is_tied = false; ?>
					<input class="vc50 center" type="hidden" name="rank[<?php echo $s; ?>][scid]" 
						value="<?php echo $students[$s]['scid']; ?>"  />											
					
				</td>								
			<?php else: ?>
				<td class="right" ><?php echo number_format($students[$s]['rank_level_ave_'.$qf],$deciranks); ?></td>
			
			<?php endif; ?>
		<?php elseif($qtr==5): ?>
			<?php if(!$is_name): ?>
				<td class="right" ><?php echo $s+1; ?></td>								
				<td class="sort <?php echo ($is_tied)? 'bg-red' : null; ?>" > 
					<input class="vc50 center <?php echo ($is_tied)? 'red':null; ?>" name="rank[<?php echo $s; ?>][qtr]" 
						value="<?php echo $rank; ?>"  />
					<?php $is_tied = false; ?>
					<input class="vc50 center" type="hidden" name="rank[<?php echo $s; ?>][scid]" 
						value="<?php echo number_format($students[$s]['scid'],$deciranks); ?>"  />
				</td>				
			<?php else: ?>
				<td class="right" ><?php echo number_format($students[$s]['rank_level_ave_'.$qf],$deciranks); ?></td>			
			<?php endif; ?>		
		<?php endif; ?>
						
		
			<td class="<?php echo ($same)? 'red':NULL; ?>" ><?php echo ($same)? 'Tie':NULL; ?></td>			
			<td class="hd" ><?php echo $students[$s]['scid']; ?></td>
			<td class="hd" > <?php echo number_format($students[$s]['rank_classroom_'.$qf],$deciranks); ?> </td>
		</tr>

<?php endfor; ?>

</tbody>
</table>

<!-- for non final qtr -->



<!-- ============================= SUBMIT ==================================================================== -->


	
<div class="clear ht50" >
	<br />
	<button id="sortBtn" onclick="editRanks();return false;">Sort On</button>
	<input class="sort" type="submit" name="submit" value="Update On"  >


<?php if($qtr<5 && !$num_open): ?>
	<button id="sortBtn" onclick="editRanks();return false;">Sort</button>
	<input class="sort" type="submit" name="submit" value="Update"  >
	<button id="cancelBtn" onclick="editRanks();return false;">Cancel</button>
<?php endif; ?>

<?php if($qtr==5): ?>
	<button id="sortBtn" onclick="editRanks();return false;">Sort</button>
	<input class="sort" type="submit" name="submit" value="Update"  >
	<button id="cancelBtn" onclick="editRanks();return false;">Cancel</button>
<?php endif; ?>	

</div>	<!-- clear ht50 -->
	
</form>

</div>
</div>	<!-- left -->

<!-------------------------------------------------------------------------------------------------------------->

<div class="clipboard" > 
	<button onclick="pasteFromExcel('srcbox','aim');return false;"> Paste Value </button>
	<br /><br />
	<textarea id="srcbox" rows="20" cols="3"  ></textarea>

</div>	<!-- valuesFromExcel -->


<!---------------------------------------------------------------------------------------------------------------------------------->

<script>
var hdpass = '<?php echo HDPASS; ?>';

	$(function(){		
		columnHighlighting();			
		hd();
		itago('clipboard');		
		$('#hdpdiv').hide();
		nextViaEnter();
		selectFocused();
		$('.sort').hide();
		$('#cancelBtn').hide();	
				
	}) 
	
	function editRanks(){
		$('#sortBtn').toggle();	
		$('#cancelBtn').toggle();	
		$('.sort').toggle();	
	}
	
	
</script>
