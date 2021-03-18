<?php 
// $this->shovel('border');

?>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<!--
ranking - mcs
anne	- 92	- 1.5
beth	- 92	- 1.5
cath	- 91	- 3


path: views/registrars/QLR.php

-->

<?php 

// pr($students[20]);

// pr($continuous);
// echo "continous: $continuous <br />";
// pr($students[1]);

$decigrades = $_SESSION['settings']['decigrades'];
$decigenave = $_SESSION['settings']['decigenave'];
$deciranks  = $_SESSION['settings']['deciranks'];


$is_name = ($get_name=='c.name')? true:false;
$sqtr = $_SESSION['qtr'];
// pr($data);

// echo "num-open $num_open <br />";

?>


<h5 class="screen" >
	<span class="" ><?php echo $level['level']; ?> Batch Ranking TIE - <?php echo ucfirst($qf); ?></span>	
	(<?php echo $num_students; ?>)
	| <a href="<?php echo URL; ?>registrars">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	<?php if($qf=='q4'): ?>
		| <a href="<?php echo URL.'registrars/qlra/'.$level_id.DS.$sy.'/5'; ?>">Final</a>	
	<?php else: ?>
		| <a href="<?php echo URL.'registrars/qlra/'.$level_id.DS.$sy.'/'.$sqtr; ?>"><?php echo 'Q'.$sqtr; ?></a>			
	<?php endif; ?>
	| <a class="u" id="btnExport" >Excel</a> 	
	
	| <a href="<?php echo URL.'registrars/qlr/'.$level_id.DS.$sy.DS.$qtr; ?>">Honors Ranking</a>		
	| <?php $this->shovel('orderjs'); ?>		

	<?php if($split): ?>
		| <a href='<?php echo URL."registrars/qlra/$level_id/$sy/$qtr"; ?>'  >Tie</a>
	<?php else: ?>
		| <a href='<?php echo URL."registrars/qlra/$level_id/$sy/$qtr&split"; ?>'  >Split</a>
	<?php endif; ?>	

	| <a href="<?php echo URL.'ranks/level/'.$level_id.DS.$sy.DS.$qtr; ?>" >Ranks</a>	

	<?php if($level['subdepartment_id']==4): ?>
		| <a href='<?php echo URL."shs/genaveQ7/$level_id"; ?>'  >Update Final Genave</a>		
		| <a href='<?php echo URL."registrars/qlra/$level_id/$sy/7"; ?>'  >Tie SHS Final</a>		
	<?php endif; ?>
	
	<?php if($continuous): ?>
		| <a href='<?php echo URL."registrars/qlra/$level_id/$sy/$qtr"; ?>'  >Tie</a>
	<?php else: ?>
		| <a href='<?php echo URL."registrars/qlra/$level_id/$sy/$qtr&continuous"; ?>'  >Continuous</a>
	<?php endif; ?>

		| <a href='<?php echo URL.VCFOLDER."/levelRanks/$level_id/$sy/$qtr"; ?>'  >Customs</a>

	<span class="sort"  > | 123 Editable (Sum.Rank_Level_Ave) </span>
		
</h5>



<p><?php $this->shovel('hdpdiv'); ?></p>


<?php 

$aveq = 'ave_q'.$qtr;	
$is_tied 	= false;
$dqval	  	= '0';


	
?>


<form method="POST" >

<!-- ============================= HONORS  ==================================================================== -->


<h5 class="screen" >  
	<?php echo ($is_name)? 'By Name':'By GenAve'; ?>
	| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>
</h5>


<p class="screen" >
	<button id="sortBtn" onclick="editRanks();return false;">Sort On</button>
	<input class="sort" type="submit" name="submit" value="Update On"  >
</p>

<h4><?php echo 'Batch Rank - '.$level['name'].' | SY'.$sy.' - Q'.$qtr;  ?></h4>

<div style="float:left;width:80%;"  >
<table id="tblExport" class='gis-table-bordered table-fx'>
<thead>
	<!-- row 1 data subjects iterator -->
	<tr class='bg-blue2'>
	<th class="vc30" >#</th>
	<th class="" >SCID</th>
	<th>Code</th>
	<th><a href="<?php echo URL.'registrars/qlra/'.$level['id'].DS.$sy.DS.$qtr.'?sortby=c.name'; ?>" >Student</a></th>
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

		<tr>
			<td><?php echo $t; ?></td>
			<td><?php echo $students[$s]['scid']; ?></td>
			<td class="vc80" ><?php echo $students[$s]['student_code']; ?></td>
			<td class="vc300" ><?php echo $students[$s]['student']; ?></td>			
			<td><?php echo $students[$s]['classroom']; ?></td>			

						
			<!-- db summaries ave_qqtr -->		
			<td class="center" ><?php echo number_format($students[$s][$aveq],$decigenave); ?></td>	

			<!-- rank -->
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

			<?php 
				
				
				$t = $s+1;
				$same = $students[$s]['ave_'.$qf]==@$students[$t]['ave_'.$qf];					
				if($continuous){
					$rank++;				
				} else {
					if(!$same){ $rank++; }				
				}
				
					
			?>				
		
			<td class="<?php echo ($same)? 'red':NULL; ?>" ><?php echo ($same)? 'Tie':NULL; ?>
				<?php // pr($students[$s]['rank_level_ave_'.$qf]);  ?>
			</td>			
			<td class="hd" ><?php echo $students[$s]['scid']; ?></td>
			<td class="hd" > <?php echo number_format($students[$s]['rank_classroom_'.$qf],$deciranks); ?> </td>
		</tr>

<?php endfor; ?>

</tbody>
</table>

<div class="clear" ></div>


<!-- for non final qtr -->



<!-- ============================= SUBMIT ==================================================================== -->
<div class="ht100" ><br />
<span class="screen" >
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
</span>	<!-- screen buttons -->
	
</div>	
	
</form>

</div>

<div class="clipboard" > 
	<button onclick="pasteFromExcel('srcbox','aim');return false;">Paste Values</button>
	<br /><br />
	<textarea id="srcbox" rows="20" cols="8"  ></textarea>

</div>	<!-- valuesFromExcel -->




<!--------->



<!---->

<script>
var hdpass = '<?php echo HDPASS; ?>';

	$(function(){		
		hd();
		excel();
		columnHighlighting();			
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
