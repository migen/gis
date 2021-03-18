<?php 

// pr($size);
// pr($fontwt);
$is_expired=$_SESSION['settings']['is_expired'];

?>

<?php if($is_expired): ?>
<form method="GET" >
<h5 class="screen" >
	Expired Scores - LSM <?php echo ucfirst($algo); ?> (<?=$num_students;?>)
	| <?php echo 'Q'.$qtr.'-'; echo ($is_locked)? 'Closed':'Open'; ?> 	
	| <?php $this->shovel('homelinks'); ?>

</h5>
<?php else: ?>

<h5 class="screen" >
	LSM <?php echo ucfirst($algo); ?> (<?=$num_students;?>)
	| <?php echo 'Q'.$qtr.'-'; echo ($is_locked)? 'Closed':'Open'; ?> 	
	
	| Class Record <?php echo ($_SESSION['settings']['eqvs'])? '(EQ)':NULL; ?>
	<span class="screen" >
	| <?php $this->shovel('homelinks'); ?>
	<span class="hd" ><a href="<?php echo URL.'purge/activitiesScores/'.$course_id.DS.$sy.DS.$qtr; ?>" >
		| PurgeActivitiesScores</a></span>
<?php if($admin && $is_locked): ?>
	| <a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Unlock</a>
<?php elseif($admin && !$is_locked): ?>
	| <a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Lock</a>			
<?php endif; ?>		
		
		| <a href='<?php echo URL."teachers/grades/".$course['id']."/$sy/$qtr";  ?>' >Grades</a>							
		| <a href='<?php echo URL."lookups/equivalents?ctype=$ctype";  ?>' >Equivalents</a>					
		| <a href='<?php echo URL."averages/course/$course_id/$sy/$qtr"; ?>'   >Averages</a> 		
		| <a href='<?php echo URL."grades/dg/$course_id/$sy/$qtr"; ?>'   >DG Only</a> 		

	| <a href='<?php echo URL."classlists/classroom/$crid/$sy?simple"; ?>' >Classlist</a> 			
	| <a href='<?php echo URL."scores/sync/$course_id/$sy/$qtr"; ?>' >Sync</a> 			


<?php if(isset($_GET['printout'])): ?>	
	| <a href='<?php echo URL."teachers/scores/$course_id/$sy/$qtr"; ?>' >Std</a> 		
<?php else: ?>
	| <a href='<?php echo URL."teachers/scores/$course_id/$sy/$qtr?printout"; ?>' >Printout</a> 		
<?php endif; ?>

<?php if(!isset($_GET['hidedg'])): ?>	
	| <a href='<?php echo URL."teachers/scores/$course_id/$sy/$qtr?hidedg"; ?>' >Hide DG</a> 		
<?php endif; ?>

	| <span class="u" id="btnExport"  >Excel</span> 

		
		<?php if($course['is_aggregate']): ?>
		<?php $par_agg = $course['crid'].DS.$course['course_id'].DS.$course['subject_id'].DS.$sy.DS.$qtr; ?>
		| <a href="<?php echo URL.'aggregates/tally/'.$par_agg; ?>" >Aggregate</a>
		<?php endif; ?>		
	</span>

   Size <input class="center vc50" id="size" name="size" value="<?php echo (isset($_GET['size']))? $_GET['size']:1; ?>"  />
   Interval <input class="center vc50" id="interval" name="interval" 
	value="<?php echo (isset($_GET['interval']))? $_GET['interval']:$interval; ?>"  />
		
<input type="submit" name="submit" value="Go" >	
	<br /><span class="brown" >*Behaviors Append &<span class="" > 1) bold, 2) size=n, 3) hidedg, 4) noteless, 5) interval=n </span>

	
	
</h5>
</form>		
<?php endif; ?>
