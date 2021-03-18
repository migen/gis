
<style>

th.left,td.left{ text-align:left;}

	
</style>



<?php 


// pr($data);
$ec=$course['is_free'];

if($ec){ require('processConducts_EC.php'); exit; }


$edit=isset($_GET['edit'])? true:false;
$deciconducts=$_SESSION['settings']['deciconducts'];

function xb($conduct,$txt,$b=null){ echo "$txt conduct $conduct $b <br />"; }



$cutoff_adee_hs=$_SESSION['settings']['cutoff_conduct_awardee_hs'];
$cutoff_adee_gs=$_SESSION['settings']['cutoff_conduct_awardee_gs'];
$cutoff_adee = $lvl>9 ? $cutoff_adee_hs : $cutoff_adee_gs;



// pr($cutoff_adee);

?>






<?php 

$order=(isset($_GET['order']))? $_GET['order']:$_SESSION['settings']['classlist_order'];

$q="
	SELECT g.id AS gid,c.name AS student,summ.scid,c.code AS studcode,
		g.q{$qtr} AS conduct,g.rq{$qtr} AS raw,
		a.q{$qtr}_days_tardy AS `tardy`,a.q{$qtr}_days_present AS `present`,
		o.q{$qtr}_major_a AS `major_a`,o.q{$qtr}_major_b AS `major_b`,o.q{$qtr}_minor AS minor,
		summ.conduct_q{$qtr} AS summ_conduct,aw.`is_conduct_awardee_q{$qtr}` AS `is_awardee`,
		sumx.scid AS sumxscid,sumx.skip_q{$qtr} AS skip
	FROM {$dbo}.`00_contacts` AS c 
	LEFT JOIN {$dbg}.`05_summaries` AS summ ON c.id = summ.scid
	LEFT JOIN {$dbg}.`05_summext` AS sumx ON c.id = sumx.scid
	LEFT JOIN {$dbg}.`50_grades` AS g ON c.id = g.scid		
	LEFT JOIN {$dbg}.`05_attendance` AS a ON c.id = a.scid		
	LEFT JOIN {$dbg}.`05_awardees` AS aw ON c.id = aw.scid		
	LEFT JOIN {$dbg}.`50_offenses_".VCFOLDER."` AS o ON c.id = o.scid		
	WHERE summ.crid=$crid AND g.course_id='$crs' ORDER BY $order;
";
	// WHERE g.course_id='$crs' ORDER BY $order;
// pr($q);
debug($q);
$sth=$db->querysoc($q);
$rows = $sth->fetchAll();
$count = $sth->rowCount();

$br=buildArray($rows,'scid');
// $count=count($rows);

function syncClasslistWithConducts($db,$dbo,$dbg,$crid,$crs,$br,$order){
	$q="SELECT summ.scid FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbo}.00_contacts AS c ON summ.scid=c.id 
		WHERE summ.crid=$crid AND c.is_active ORDER BY $order ;";
	$sth=$db->querysoc($q);
	$a=$sth->fetchAll();
	$ar=buildArray($a,'scid');
	$ix=array_diff($ar,$br);	
	return $ix;
		
}	/* fxn */


$addscids=syncClasslistWithConducts($db,$dbo,$dbg,$crid,$crs,$br,$order);

/* sync */
foreach($addscids AS $scid){
	$q="INSERT INTO {$dbg}.50_grades(scid,course_id,crstype_id)VALUES 
		($scid,$crs,".CTYPECONDUCT.")";
	pr($q);
	$sth=$db->query($q);
	echo ($sth)? "Success":"Fail";	
}	/* fxn */



if($lvl>12){	/* shs */
	function adjustConduct($conduct,$tardy,$minor,$major_a,$major_b,$cutoff_adee){
		/* 1 is_conduct_awardee */
		$is_awardee=0;
		if($conduct>=$cutoff_adee && $tardy<2 && $minor==0 && $major_a==0 && $major_b==0){ $is_awardee=1; }
		/* 2 tardy */
		switch($tardy){
			case $tardy>5: $conduct=($conduct>80)? 80:$conduct;break;
			case $tardy==5: $conduct=($conduct>85)? 85:$conduct;break;
			case $tardy==4: $conduct-=3;break;
			case $tardy==3: $conduct-=1;break;
			default: break;
		}
		/* 3 minor */
		if($minor>4){ $conduct=($conduct>80)? 80:$conduct; }
		elseif($minor>3){ $conduct=($conduct>85)? 85:$conduct; }
		elseif($minor==3){ $conduct-=3; }
		
		/* 4 major_a */
		if($major_a>0){ $conduct=($conduct>75)? 75:$conduct; }
		// elseif($major_a==1){ $conduct=($conduct>80)? 80:$conduct; }

		/* 4 major_b */
		if($major_b>0){ $conduct=($conduct>80)? 80:$conduct; }
		// elseif($major_b==1){ $conduct=($conduct>80)? 80:$conduct; }			
		$res=array('conduct'=>$conduct,'is_awardee'=>$is_awardee);
		return $res;		
	}	/* fxn */
	
} elseif($lvl>9){	/* g7-g10 */
	function adjustConduct($conduct,$tardy,$minor,$major_a,$major_b,$cutoff_adee,$skip=false){
		if($skip){
			$is_awardee=0;			
			$res=array('conduct'=>$conduct,'is_awardee'=>$is_awardee);
			return $res;								
		} else {
			/* 1 is_conduct_awardee */
			$is_awardee=0;
			if($conduct>=$cutoff_adee && $tardy<2 && $minor==0 && $major_a==0 && $major_b==0){ $is_awardee=1; }

			/* 2 tardy */
			switch($tardy){
				case $tardy>5: $conduct=($conduct>75)? 75:$conduct;break;				
				case $tardy==5: $conduct=($conduct>80)? 80:$conduct;break;				
				case $tardy==4: $conduct-=3;break;
				default: break;
			}
			/* 3 minor */
			if($minor>8){ $conduct=($conduct>75)? 75:$conduct; }
			elseif($minor>5){ $conduct=($conduct>75)? 75:$conduct; }
			elseif($minor==5){ $conduct=($conduct>80)? 80:$conduct; }
			elseif($minor==4){ $conduct=($conduct>85)? 85:$conduct; }
			elseif($minor==3){ $conduct-=3; }
			
			/* 4 major_a */
			if($major_a>1){ $conduct=($conduct>75)? 75:$conduct; }
			elseif($major_a==1){ $conduct=($conduct>80)? 80:$conduct; }	
			/* 4 major_b */
			if($major_b>0){ $conduct=($conduct>75)? 75:$conduct; }
					
			$res=array('conduct'=>$conduct,'is_awardee'=>$is_awardee);
			return $res;					
		}	/* skip */
	}	/* fxn */



} elseif($lvl>6){	/* g4-g6 */
	function adjustConduct($conduct,$tardy,$minor,$major_a,$major_b,$cutoff_adee,$skip=false){
		if($skip){
			$is_awardee=0;			
			$res=array('conduct'=>$conduct,'is_awardee'=>$is_awardee);
			return $res;								
		} else {
			/* 1 is_conduct_awardee */
			$is_awardee=0;
			if($conduct>=$cutoff_adee && $tardy<2 && $minor==0 && $major_a==0 && $major_b==0){ $is_awardee=1; }

			/* 2 tardy */
			switch($tardy){
				case $tardy>5: $conduct=($conduct>75)? 75:$conduct;break;				
				case $tardy==5: $conduct=($conduct>80)? 80:$conduct;break;				
				case $tardy==4: $conduct-=2;break;
				default: break;
			}
			/* 3 minor */
			if($minor>8){ $conduct=($conduct>75)? 75:$conduct; }
			elseif($minor>5){ $conduct=($conduct>75)? 75:$conduct; }
			elseif($minor==5){ $conduct=($conduct>80)? 80:$conduct; }
			elseif($minor==4){ $conduct=($conduct>85)? 85:$conduct; }
			elseif($minor==3){ $conduct-=3; }
			
			/* 4 major_a */
			if($major_a>1){ $conduct=($conduct>75)? 75:$conduct; }
			elseif($major_a==1){ $conduct=($conduct>80)? 80:$conduct; }	
			/* 4 major_b */
			if($major_b>0){ $conduct=($conduct>75)? 75:$conduct; }
					
			$res=array('conduct'=>$conduct,'is_awardee'=>$is_awardee);
			return $res;					
		}	/* skip */
	}	/* fxn */


} elseif($lvl>3){	/* g1-g3 */
	function adjustConduct($conduct,$tardy,$minor,$major_a,$major_b,$cutoff_adee,$skip=false){
		if($skip){
			$is_awardee=0;		
			$res=array('conduct'=>$conduct,'is_awardee'=>$is_awardee);
			return $res;								
		} else {
			/* 1 is_conduct_awardee */
			$is_awardee=0;
			if($conduct>=$cutoff_adee && $tardy<2 && $minor==0 && $major_a==0 && $major_b==0){ $is_awardee=1; }

			/* 2 tardy */
			switch($tardy){
				case $tardy>7: $conduct-=3;break;
				case $tardy==7: $conduct-=2;break;
				case $tardy==6: $conduct-=2;break;
				case $tardy==5: $conduct-=1;break;
				default: break;
			}
			/* 3 minor */
			if($minor>8){ $conduct=($conduct>75)? 75:$conduct; }
			elseif($minor>5){ $conduct=($conduct>75)? 75:$conduct; }
			elseif($minor==5){ $conduct=($conduct>80)? 80:$conduct; }
			elseif($minor==4){ $conduct=($conduct>85)? 85:$conduct; }
			elseif($minor==3){ $conduct-=3; }
			/* 4 major_a */
			if($major_a>1){ $conduct=($conduct>75)? 75:$conduct; }
			elseif($major_a==1){ $conduct=($conduct>80)? 80:$conduct; }	
			/* 4 major_b */
			if($major_b>0){ $conduct=($conduct>75)? 75:$conduct; }
					
			$res=array('conduct'=>$conduct,'is_awardee'=>$is_awardee);
			return $res;					
		}	/* skip */
	}	/* fxn */
	
}	/* g1-g3 */
	


// pr($rows[2]);
// pr($course);
	
?>


<h5>
	Conducts Process (<?php echo $count; ?>)
	| <?php echo ($is_locked)? 'Locked':'Open'; ?>
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="pclass('scid');" >Scid</span>
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy?simple"; ?>' >Classlist</a>
	| <a href='<?php echo URL."conducts/records/$crs/$sy"; ?>' >Records</a>	
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a>	
	| <a href='<?php echo URL."honors/records/$crid/$sy/$qtr"; ?>' >Honors</a>	
	<?php if(isset($_GET['print'])): ?>
		| <a class="u" id="btnExport" >Excel</a> 
	<?php endif; ?>
	<?php if(!isset($_GET['edit'])): ?>
		<?php if(!$is_locked || $is_admin): ?>
			| <a href='<?php echo URL."conducts/process/$crid/$sy/$qtr?edit"; ?>' >Edit</a>		
		<?php endif; ?>
	<?php else: ?>
		| <a href='<?php echo URL."conducts/process/$crid/$sy/$qtr"; ?>' >Cancel</a>
	<?php endif; ?>
	<?php $attd=($_SESSION['settings']['attd_qtr']==1)? 'quarterly':'monthly'; ?>
	| <a href='<?php echo URL."attendance/$attd/$crid/$sy/$qtr"; ?>' >Attendance</a>
	| <a href="<?php echo URL.'offenses/records/'.$crid; ?>" >Offenses</a>
	| <a href='<?php echo URL."conducts/sync/$crid"; ?>' >Sync</a>	
	| <a href='<?php echo URL."certificates/conductsByClassroom/$crid/$sy/$qtr"; ?>' >Certificates</a>	
	
</h5>

<table class="gis-table-bordered" style="margin-bottom:10px;" >
	<tr>
		<th><?php echo "SY{$sy} | Q{$qtr}"; ?>
			| <?php echo ($is_locked)? 'Locked':'Open'; ?>
		</th>
	<?php if(!$is_locked): ?>
		<th>
			<a href="<?php echo URL.'finalizers/closeConduct/'.$crid.DS.$sy.DS.$qtr; ?>" >Finalize</a>
		</th>		
	<?php endif; ?>	
	
	<?php if($is_locked && $is_admin): ?>	
		<th>
			<a href="<?php echo URL.'finalizers/openConduct/'.$crid.DS.$sy.DS.$qtr; ?>" >Open On</a>
		</th>		
	<?php endif; ?>	
	
		<th><?php echo '#'.$course['crid'].'-'.$course['classroom'].' &nbsp; #'.$course['acid'].'-'.$course['adviser']; ?></th>
		<th>Conduct Crs<?php echo '#'.$course['course_id'].'-'.$course['name']; ?></th>
		<th>Days Total</th><td><?php echo $attmo['q'.$qtr.'_days_total']; ?></td></tr>
</table>



<form method="POST" >
<table class="gis-table-bordered" id="tblExport" >
<tr class="headrow center" >
	<th>#</th>
	<th class="scid" >Gid</th>
	<th class="" >Scid</th>
	<th class="scid" >Stud No.</th>
	<th style="text-align:left;" >Student</th>
	<th>Attd<br />Pres<br />
		<?php 
			echo $attmo['q'.$qtr.'_days_total'];
		?>
	
	</th>
	<th>Attd<br />Tard</th>
	<th>Minor</th>
	<th>Major<br />A</th>
	<th>Major<br />B</th>
	<th class="scid" >Summ<br />Cndk</th>
	<th>Q<?php echo $qtr; ?><br />Ave</th>
	<th>Adj</th>
	<th>Is<br />Adee</th>	
	<th>Skip</th>	

</tr>
<?php if($edit && (!$is_locked || $is_admin)): ?>
	<?php for($i=0;$i<$count;$i++): ?>
		<?php $skip=$rows[$i]['skip']; ?>
	<tr class="center" >
		<td><?php echo $i+1; ?></td>
		<td class="scid" ><?php echo $rows[$i]['gid']; ?></td>
		<td class="" ><?php echo $rows[$i]['scid']; ?></td>
		<td class="scid" ><?php echo $rows[$i]['studcode']; ?></td>
		<td style="text-align:left;" ><?php echo $rows[$i]['student']; ?></td>
		<td><?php echo $rows[$i]['present']; ?></td>
		<td><?php echo $rows[$i]['tardy']; ?></td>
		<td><?php echo $rows[$i]['minor']; ?></td>
		<td><?php echo $rows[$i]['major_a']; ?></td>
		<td><?php echo $rows[$i]['major_b']; ?></td>
		<td class="scid" ><?php echo $rows[$i]['summ_conduct']; ?></td>
		<td><?php echo $rows[$i]['conduct']; ?></td>		
<td>
		<?php 
			$res=adjustConduct($rows[$i]['conduct'],$rows[$i]['tardy'],$rows[$i]['minor'],$rows[$i]['major_a'],$rows[$i]['major_b'], $cutoff_adee,$skip);
			// pr($res);
			$adjusted=number_format($res['conduct'],$deciconducts);
			$is_awardee=$res['is_awardee'];
			$scid=$rows[$i]['scid'];
			$gid=$rows[$i]['gid'];			
		?>
<input class="vc50 center" tabIndex=2 name="posts[<?php echo $i; ?>][adjusted]" value="<?php echo $adjusted; ?>"  />
</td>
<td>
	<input class="vc50 center" tabIndex=4 name="posts[<?php echo $i; ?>][is_awardee]" 
		value="<?php echo $is_awardee; ?>" />
	<input type="hidden" name="posts[<?php echo $i; ?>][gid]" value="<?php echo $gid; ?>"  />
	<input type="hidden" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $scid; ?>"  />	
</td>

	<td><?php echo ($rows[$i]['skip']==1)? 'skip':'-'; ?></td>
	<td><a href="<?php echo URL.'conducts/editConductProcessByStudent/'.$rows[$i]['scid']; ?>" >Edit</a></td>
		
	</tr>
	<?php endfor; ?>
<?php else: ?>	
	<?php for($i=0;$i<$count;$i++): ?>
		<?php $skip=$rows[$i]['skip']; ?>	
	<tr class="center" >
		<td><?php echo $i+1; ?></td>
		<td class="scid" ><?php echo $rows[$i]['gid']; ?></td>
		<td class="" ><?php echo $rows[$i]['scid']; ?></td>
		<td class="scid" ><?php echo $rows[$i]['studcode']; ?></td>
		<td style="text-align:left;" ><?php echo $rows[$i]['student']; ?></td>
		<td><?php echo $rows[$i]['present']; ?></td>
		<td><?php echo $rows[$i]['tardy']; ?></td>
		<td><?php echo $rows[$i]['minor']; ?></td>
		<td><?php echo $rows[$i]['major_a']; ?></td>
		<td><?php echo $rows[$i]['major_b']; ?></td>
		<td class="scid" ><?php echo $rows[$i]['summ_conduct']; ?></td>
		<td><?php echo $rows[$i]['conduct']; ?></td>
		<td><?php echo $rows[$i]['conduct']; ?></td>
		<td><?php echo ($rows[$i]['is_awardee']==1)? 'CA':'-'; ?></td>
		<td><?php echo ($rows[$i]['skip']==1)? 'skip':'-'; ?></td>
		
		

	</tr>
	<?php endfor; ?>
<?php endif; ?>	
	
</table>

<br />
<?php if(!$is_locked): ?>
	<button><a href="<?php echo URL.'finalizers/closeConduct/'.$crid.DS.$sy.DS.$qtr; ?>">Lock / Finalize</a></button>
	<br />
<?php endif; ?>

<?php if($is_locked && $is_admin): ?>
	<button><a href="<?php echo URL.'finalizers/openConduct/'.$crid.DS.$sy.DS.$qtr; ?>">Open On</a></button>
	<br />
<?php endif; ?>


<?php if($edit): ?>
<br />
<p><input type="submit" name="submit" value="Save" /></p>
<?php endif; ?>

</form>

<p>
<table class="gis-table-bordered" style="font-size:0.8em;" >
<tr><th colspan=2>Legends:</th></tr>
<tr><td>Attd</td><td>Attendance</td></tr>
<tr><td>Pres</td><td>Present</td></tr>
<tr><td>Tard</td><td>Tardy</td></tr>
<tr><td>Adj</td><td>Adjusted Grade</td></tr>
<tr><td>Adee</td><td>Awardee</td></tr>
</table>
</p>


<p class="screen" >

<table class="gis-table-bordered" >
<tr><td>*Settings: "cutoff_conduct_awardee" is "greated than or equal to".</td></tr>
<tr><td>Locking at advisers-quarters, NOT at courses-quarters</td></tr>



</table>

</p>


<div class="ht100" ></div>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>

var gurl     = "http://<?php echo GURL; ?>";


$(function(){
	excel();
	$('.scid').hide();
	selectFocused();
	nextViaEnter();
	
})

</script>


