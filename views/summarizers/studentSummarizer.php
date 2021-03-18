<?php 
	$dbo=PDBO;
	$dbcontacts="{$dbo}.00_contacts";
	
	

?>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID / Name</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Filter" onclick='getDataByTable(dbcontacts,30);return false;' />		
	</td></tr>
	
</table></p>

<div id="names" >names</div>


<?php if($scid): ?>	
	
<h5>
	General Average SY<?php echo $sy; ?><?php echo ($sem>0)? "Sem#$sem":NULL; ?>
	| <a href="<?php echo URL; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."registrars/editStudentGrades/$scid/$sy/$qtr"; ?>' >Edit</a>	
	| <a href='<?php echo URL."summarizers/student/$scid/$sy/$qtr"; ?>' >Annual</a>		
	| <a href='<?php echo URL."summarizers/student/$scid/$sy/$qtr?sem=".$derivsem; ?>' >Sem 
		<?php echo ($derivsem==1)? '1':'2'; ?></a>
	| <a href='<?php echo URL."conducts/editOne/$scid/$sy/$qtr"; ?>' >Conduct</a>	
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a>	
<?php if($_SESSION['srid']==RMIS): ?>
	| <a href='<?php echo URL."registrars/editStudentGrades/$scid/$sy"; ?>' >Grades</a>	
	| <a href='<?php echo URL."gtools/msg/$scid/$sy/$qtr"; ?>' >MSG</a>	
<?php endif; ?>	
		

</h5>

<p><?php $this->shovel('hdpdiv'); ?></p>


<?php 
	
	$deciave=($classroom['department_id']==3)? $_SESSION['settings']['deciave_hs']:$_SESSION['settings']['deciave_gs'];
	$deciave=isset($_GET['deciave'])? $_GET['deciave']:$deciave;

	$decicard 	= $_SESSION['settings']['decicard'];
	$decifg 	= $_SESSION['settings']['decifg'];
	$decigrades = $_SESSION['settings']['decigrades'];
	$decigenave = $_SESSION['settings']['decigenave'];
	$decifgenave = $_SESSION['settings']['decifgenave'];



	
$pcid = $_SESSION['user']['parent_id'];


?>


<table class='gis-table-bordered table-fx'>
	<tr>
		<td><?php echo '#'.$crid.' - '.$cr['level'].' - '.$cr['section']; ?></td>
		<td><?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td>
	</tr> 
</table>



<br />

<form method="POST" >

<table class='gis-table-bordered table-fx'>
<!-- row 1 data subjects iterator -->
<tr class='bg-blue2'>
		<th>#</th>
		<th>Code</th>
		<th>Student</th>
		<th>Qtr</th>
	<!-- iterate subjects for headrow subject columns -->
	<?php foreach($data['subjects'] AS $row): ?>
		<th class="center" >
			<?php if(($row['tcid'] == $pcid) || $user['role_id']==RREG || $user['role_id']==RMIS): ?> 
				<a href="<?php echo URL.'averages/course/'.$row['course_id'].DS.$sy.DS.$qtr; ?>" ><?php echo $row['course_code']; ?></a>
	<br /><span onclick="alert(this.id);" id="<?php echo $row['label']; ?>" class="u" >Labl</span>				
			<?php else: ?>
				<span onclick="alert(this.id);" id="<?php echo $row['label']; ?>" ><?php echo $row['course_code']; ?></span>
			<?php endif; ?>
			<span class="hd"><br /> <?php echo $row['course_id']; ?> </span>
		</th>	
	<?php endforeach; ?>
	<th class="center" >AG</th>
	<th class="center" >TG</th>
	<th class="hd" >SCID</th>
	<th class="hd center" >Sumid</th>
</tr>


<!-- ========================= grades iterator ================================= -->

<?php $num_diff = 0; ?>
<?php $g = 0; ?>
<?php foreach($data['grades'] AS $row): ?>




<?php 
	$q1t = 0; $q2t = 0; $q3t = 0; 
	$q4t = 0; 
	$q5t = 0; 
	$q6t = 0; 
	$ftg = 0; 
?>
		
	<?php for($j=1;$j<=$iqtr;$j++): ?>
	<?php // for($j=1;$j<=$qtr;$j++): ?>
	<?php $qqtr = 'q'.$j; ?>
		<tr>
			<?php if($j==1): ?>
				<td> <?php echo $g+1; ?> </td>
				<td> <?php echo $student['student_code']; ?> </td>
				<td> <?php echo $student['student']; ?> </td>
			<?php else: ?>
				<td>&nbsp;</td> <td>&nbsp;</td><td>&nbsp;</td>
			<?php endif; ?>
			
			
			<td  class='colshading' >Q<?php echo $j; ?></td>
		<?php for($i=0;$i<$num_subjects;$i++): ?>		<!-- subject iterator per row -->
				<td  class='colshading' ><?php 
							$score  = (isset($row[$i][$qqtr]))? $row[$i][$qqtr] : 0;
							echo number_format($score,$decicard); 	
							$uscore = number_format($score,$decicard)*$row[$i]['units'] ;
							${'q'.$j.'t'} += $uscore;							
					?>
				</td>								
		<?php endfor; ?>
			<?php 
			
			?>

			<!-- db.05_summaries.ave_q$qtr-->
			<td class="fg"> 
				
				<?php $dbgenave=number_format($student['ave_q'.$j],$decigenave); echo $dbgenave; ?> 
				<?php if($cr['is_k12']): ?>
					| <?php echo $student['ave_dg'.$j]; ?>
				<?php endif; ?>			
			</td>

		
			<!-- TG tally grades / q$jt or qtr$j  -->				
			
			<?php ${'q'.$j.'t'} = ${'q'.$j.'t'}/$total_units; $tg = number_format(${'q'.$j.'t'},$decigenave);  ?>
				
			<td class="final <?php echo ($dbgenave!=$tg)? 'bg-salmon':null; ?>">
				<input class="vc50 center" name="sum[<?php echo $g; ?>][ave_q<?php echo $j; ?>]" type="text" value="<?php echo $tg; ?>"  />
				<!-- add q1t to fgt -->
				<?php $ftg += ${'q'.$j.'t'}; ?>				
				<?php if($cr['is_k12']): ?>
				<?php ${'rq'.$j.'t'} = ($is_k12)? round(${'q'.$j.'t'}) : ${'q'.$j.'t'}; ${'rq'.$j.'t'} = rating(${'rq'.$j.'t'},$ratings); ?>
				<?php $intype = ($is_k12)? 'text' : 'hidden'; ?>
				<input class="vc25 center" type="<?php echo $intype; ?>" name="sum[<?php echo $g; ?>][ave_dg<?php echo $j; ?>]"  value="<?php echo ${'rq'.$j.'t'}; ?>" />			
				<?php endif; ?>					
			</td>								
		
			<td class="hd" > <?php echo $scid; ?> </td>
			<td class="hd vc50 center"> <?php echo $student['sumid']; ?> </td>
			
	<td class="hd vc50 center"> <a href='<?php echo URL."$home/deleteSummaryScid/$scid"; ?>' >Delete <?php echo $scid; ?></a> </td>
					

			
		</tr>
	<?php endfor; ?>	<!-- end for qtr iterator per row -->


<!-- ============================== for FG ROW not column ============================== -->
		<tr class="<?php echo ($fgrow==5)? 'bg-gray3':null; ?>" >
			<!-- no colspan for columnHighlighting td column index -->
			<td> &nbsp; </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
			<td class='colshading' >FG</td>
	<?php $total_fg = 0; ?>
	<?php $ftg	 	= 0; ?>
			
	<?php for($i=0;$i<$num_subjects;$i++): ?> <!-- subject iterator -->		
			<?php $total_fg+=number_format($row[$i]['q'.$intfqtr],$deciave); ?>	
			<td class='colshading' > <?php echo (isset($row[$i]['q'.$intfqtr]))? number_format($row[$i]['q'.$intfqtr],$deciave) : 0; ?> </td>
	<?php endfor; ?>		<!-- subject iterator -->


			<!-- db.05_summaries.ave_q1-->
			<td> 
				<?php echo $student['ave_q'.$intfqtr]; ?> 
				<?php if($cr['is_k12']): ?>
					| <?php echo $student['ave_dg'.$intfqtr]; ?>				
				<?php endif; ?>
			</td>				
	
			<?php 
				$ftg = number_format($total_fg/$num_subjects,$decifgenave);  
				$same=(number_format($student['ave_q'.$intfqtr],$decifgenave)==number_format($ftg,$decifgenave))? true:false;
			
			?>
	
			<td class="<?php echo ($same)? NULL:'bg-red'; ?>" > 			
				<?php 
								
				?>
				<input class="vc50 center  " name="sum[<?php echo $g; ?>][ave]" value="<?php echo $ftg;  ?>"   />
				<?php if($cr['is_k12']): ?>
					<?php $rftg = ($is_k12)? round($ftg) : $ftg; $rftg = rating($rftg,$ratings); ?>
					<input class="vc25 center" type="<?php echo $intype; ?>" name="sum[<?php echo $g; ?>][ave_dg]"  
						value="<?php echo $rftg; ?>" />			
				<?php endif; ?>		
				
			<td class="hd" > <?php echo $student['scid']; ?> </td>			
			<td class="hd vc50 center vcenter"> <?php echo $student['sumid']; ?> </td>
			
			
			<!-- hidden,for summaries need 2 params,1) scid,2) sy - no need to post  -->
		<td class="hd" ><input type="" class="vc50" name="sum[<?php echo $g; ?>][sumid]" value="<?php echo $student['sumid']; ?>" ></td>
		</tr>	
		
		
<?php $g++; ?>
<?php endforeach; ?>	<!-- end of grades iterator -->

</table> <br />

<input type="hidden" name="isk12" value="<?php echo $classroom['is_k12']; ?>"  />

	<p>
		<input type="submit" name="submit" value="Summarize"  /> 
		&nbsp; 
		<button><a class='no-underline' href='<?php echo URL."qcr/qcr/".$cr['id']."/$sy/$qtr"; ?>' >Ranking</a></button> 	
	
	</p>





</form>


<?php endif; ?>		<!-- scid -->

<!---------------------------------------------------------------------------------------------->

<script>
	var gurl = "http://<?php echo GURL; ?>";
	var hdpass = '<?php echo HDPASS; ?>';
	var dbcontacts = "<?php echo $dbcontacts; ?>";
	var sy = "<?php echo $sy; ?>";
	var qtr = "<?php echo $qtr; ?>";


	$(function(){		
		$('#hdpdiv').hide();
		columnHighlighting();			
		hd();
		$('html').live('click',function(){ $('#names').hide(); });
		$('#names').hide();		
	}) 

	
	function axnFilter(id){
		var url=gurl+"/summarizers/student/"+id+"/"+sy+"/"+qtr;
		window.location=url;
	}



	
	
</script>


<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

<!---------------------------------------------------------------------------------------------->


