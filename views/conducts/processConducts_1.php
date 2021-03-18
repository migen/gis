
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



$cutoff_adee=$_SESSION['settings']['cutoff_conduct_awardee'];

// pr($cutoff_adee);

?>



<h5>
	Adjusted Conducts Process 
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="pclass('scid');" >Scid</span>
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy?simple"; ?>' >Classlist</a>
	| <a href='<?php echo URL."conducts/records/$crs/$sy"; ?>' >Records</a>	
	<?php if(isset($_GET['print'])): ?>
		| <a class="u" id="btnExport" >Excel</a> 
	<?php endif; ?>
	<?php if(!isset($_GET['edit'])): ?>
		| <a href='<?php echo URL."conducts/process/$crid/$sy/$qtr?edit"; ?>' >Edit</a>
	<?php else: ?>
		| <a href='<?php echo URL."conducts/process/$crid/$sy/$qtr"; ?>' >Cancel</a>
	<?php endif; ?>
	<?php $attd=($_SESSION['settings']['attd_qtr']==1)? 'quarterly':'monthly'; ?>
	| <a href='<?php echo URL."attendance/$attd/$crid/$sy/$qtr"; ?>' >Attendance</a>
	| <a href="<?php echo URL.'offenses/records/'.$crid; ?>" >Offenses</a>
	| <a href='<?php echo URL."conducts/sync/$crid"; ?>' >Sync</a>	
	
</h5>

<p>
	<table class="gis-table-bordered" >
		<tr>
			<th><?php echo '#'.$course['crid'].'-'.$course['classroom'].' &nbsp; #'.$course['acid'].'-'.$course['adviser']; ?></th>
			<th>Conduct Crs<?php echo '#'.$course['course_id'].'-'.$course['name']; ?></th>
			<th>Days Total</th><td><?php echo $attmo['q'.$qtr.'_days_total']; ?></td></tr>
	</table>
</p>




<?php 

$order=(isset($_GET['order']))? $_GET['order']:$_SESSION['settings']['classlist_order'];

$q="
	SELECT g.id AS gid,c.name AS student,summ.scid,c.code AS studcode,
		g.q{$qtr} AS conduct,g.rq{$qtr} AS raw,
		a.q{$qtr}_days_tardy AS `tardy`,a.q{$qtr}_days_present AS `present`,
		o.q{$qtr}_major_a AS `major_a`,o.q{$qtr}_major_b AS `major_b`,o.q{$qtr}_minor AS minor,
		summ.conduct_q{$qtr} AS summ_conduct,aw.`is_conduct_awardee_q{$qtr}` AS `is_awardee`
	FROM {$dbo}.`00_contacts` AS c 
	LEFT JOIN {$dbg}.`05_summaries` AS summ ON c.id = summ.scid
	LEFT JOIN {$dbg}.`50_grades` AS g ON c.id = g.scid		
	LEFT JOIN {$dbg}.`05_attendance` AS a ON c.id = a.scid		
	LEFT JOIN {$dbg}.`05_awardees` AS aw ON c.id = aw.scid		
	LEFT JOIN {$dbg}.`50_offenses_".VCFOLDER."` AS o ON c.id = o.scid		
	WHERE g.course_id='$crs' ORDER BY $order;
";
// pr($q);
debug($q);
$sth=$db->querysoc($q);
$rows = $sth->fetchAll();
$count=count($rows);






if($lvl>9){	/* gr7-g12 */
	function adjustConduct($conduct,$tardy,$minor,$major_a,$major_b,$cutoff_adee){
		/* 1 is_conduct_awardee */
		$is_awardee=0;
		if($conduct>=$cutoff_adee && $tardy<2 && $minor==0 && $major_a==0 && $major_b==0){ $is_awardee=1; }
		/* 2 tardy */
		switch($tardy){
			case $tardy>5: $conduct=($conduct>80)? 80:$conduct;break;
			case $tardy==5: $conduct=($conduct>85)? 85:$conduct;break;
			case $tardy==4: $conduct-=3;break;
			default: break;
		}
		/* 3 minor */
		if($minor>5){ $conduct=($conduct>80)? 80:$conduct; }
		elseif($minor>4){ $conduct=($conduct>85)? 85:$conduct; }
		elseif($minor==4){ $conduct-=3; }
		
		/* 4 major_a */
		if($major_a>1){ $conduct=($conduct>75)? 75:$conduct; }
		elseif($major_a==1){ $conduct=($conduct>80)? 80:$conduct; }	
		/* 4 major_b */
		if($major_b>1){ $conduct=($conduct>75)? 75:$conduct; }
		elseif($major_b==1){ $conduct=($conduct>80)? 80:$conduct; }			
		$res=array('conduct'=>$conduct,'is_awardee'=>$is_awardee);
		return $res;		
	}	/* fxn */
	
} elseif($lvl>6){	/* g4-g6 */
	function adjustConduct($conduct,$tardy,$minor,$major_a,$major_b,$cutoff_adee){
		/* 1 is_conduct_awardee */
		$is_awardee=0;
		// pr($cutoff_adee);
		// pr($cutoff_adee);
		// echo ('cond: '.$conduct.', cond_adee: '.$cutoff_adee);
		if($conduct>=$cutoff_adee && $tardy==2 && $minor==0 && $major_a==0 && $major_b==0){ $is_awardee=1; }
		/* 2 tardy */
		switch($tardy){
			case $tardy>5: $conduct=75;break;
			case $tardy>4: $conduct=80;break;
			case $tardy>3: $conduct-=2;break;
			default: break;
		}
		
		/* 3 minor */
		if($minor>7){ $conduct=75; }
		elseif($minor>5){ $conduct=($conduct>80)? 80:$conduct; }
		elseif($minor>3){ $conduct=($conduct>85)? 85:$conduct; }
		/* 4 major_a */
		if($major_a>2){ $conduct=75; }
		elseif($major_a==2){ $conduct=($conduct>80)? 80:$conduct; }
		elseif($major_a==1){ $conduct=($conduct>85)? 85:$conduct; }	
		/* 4 major_b */
		if($major_b>2){ $conduct=70; }
		elseif($major_b==2){ $conduct=($conduct>75)? 75:$conduct; }

		$res=array('conduct'=>$conduct,'is_awardee'=>$is_awardee);
		return $res;		
	}	/* fxn */

} elseif($lvl>3){	/* g1-g3 */
	function adjustConduct($conduct,$tardy,$minor,$major_a,$major_b,$cutoff_adee){
		/* 1 is_conduct_awardee */
		$is_awardee=0;
		if($conduct>=$cutoff_adee && $tardy==1 && $minor==0 && $major_a==0 && $major_b==0){ $is_awardee=1; }
		/* 2 tardy */
		if($tardy>5){ $conduct-=2; }
		elseif($tardy==5){ $conduct-=1; }
		
		/* 3 minor */
		if($minor>8){ $conduct=($conduct>75)? 75:$conduct; }
		elseif($minor>6){ $conduct=($conduct>80)? 80:$conduct; }
		elseif($minor>4){ $conduct=($conduct>85)? 85:$conduct; }
		/* 4 major_a */
		if($major_a>2){ $conduct=($conduct>83)? 83:$conduct; }
		elseif($major_a==2){ $conduct=($conduct>85)? 85:$conduct; }
		elseif($major_a==1){ $conduct=($conduct>87)? 87:$conduct; }	
		/* 4 major_b */
		if($major_b>2){ $conduct=($conduct>75)? 75:$conduct; }
		elseif($major_b==2){ $conduct=($conduct>80)? 80:$conduct; }
		elseif($major_b==1){ $conduct=($conduct>85)? 85:$conduct; }	
				
		$res=array('conduct'=>$conduct,'is_awardee'=>$is_awardee);
		return $res;		
	}	/* fxn */
	
}	/* g1-g3 */
	

	
?>



<form method="POST" >
<table class="gis-table-bordered" id="tblExport" >
<tr class="headrow center" >
	<th>#</th>
	<th class="scid" >Gid</th>
	<th class="scid" >Scid</th>
	<th class="scid" >Stud No.</th>
	<th style="text-align:left;" >Student</th>
	<th>Attd<br />Pres</th>
	<th>Attd<br />Tard</th>
	<th>Minor</th>
	<th>Major<br />A</th>
	<th>Major<br />B</th>
	<th class="scid" >Summ<br />Cndk</th>
	<th>Q<?php echo $qtr; ?><br />Ave</th>
	<th>Adj</th>
	<th>Is<br />Adee</th>	
</tr>
<?php if($edit): ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr class="center" >
		<td><?php echo $i+1; ?></td>
		<td class="scid" ><?php echo $rows[$i]['gid']; ?></td>
		<td class="scid" ><?php echo $rows[$i]['scid']; ?></td>
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
			$res=adjustConduct($rows[$i]['conduct'],$rows[$i]['tardy'],$rows[$i]['minor'],$rows[$i]['major_a'],$rows[$i]['major_b'],$cutoff_adee);
			// pr($res);
			$adjusted=number_format($res['conduct'],$deciconducts);
			$is_awardee=$res['is_awardee'];
			$scid=$rows[$i]['scid'];
			$gid=$rows[$i]['gid'];			
		?>
<input class="vc50 center" tabIndex=2 name="posts[<?php echo $i; ?>][adjusted]" value="<?php echo $adjusted; ?>"  />
<td><input class="vc50 center" tabIndex=4 name="posts[<?php echo $i; ?>][is_awardee]" 
		value="<?php echo $is_awardee; ?>" />
	<input type="hidden" name="posts[<?php echo $i; ?>][gid]" value="<?php echo $gid; ?>"  />
	<input type="hidden" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $scid; ?>"  />	
</td>
</td>
		
	</tr>
	<?php endfor; ?>
<?php else: ?>	
	<?php for($i=0;$i<$count;$i++): ?>
	<tr class="center" >
		<td><?php echo $i+1; ?></td>
		<td class="scid" ><?php echo $rows[$i]['gid']; ?></td>
		<td class="scid" ><?php echo $rows[$i]['scid']; ?></td>
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

	</tr>
	<?php endfor; ?>
<?php endif; ?>	
	
</table>

<?php if($edit): ?>
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
<tr>
<td>*Settings: "cutoff_conduct_awardee" is "greated than or equal to".</td>
</tr>



</table>

</p>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>

var gurl     = "http://<?php echo GURL; ?>";


$(function(){
	excel();
	$('.scid').hide();
	
})

</script>


