
<h5>
	Std Custom Classlist	
	| <?php $this->shovel('homelinks'); ?>

</h5>

<?php 



$order=$_SESSION['settings']['classlist_order'];
$q="
	SELECT
		c.id,c.name,c.code,c.lrn,c.position,summ.scid,c.is_male,c.is_active,sumx.*	
	FROM {$dbg}.05_summaries AS summ
	LEFT JOIN {$dbg}.05_summext AS sumx ON sumx.scid=summ.scid
	LEFT JOIN {$dbo}.00_contacts AS c ON c.id=summ.scid
	WHERE summ.crid=$crid ORDER BY $order;
";

debug($q);
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
$count=$sth->rowCount();



// prx(123);

	$colspan=11;
	$boys=array();
	$girls=array();
	
	foreach($rows AS $row){
		if($row['is_male']==1){
			$boys[]=$row;
		} else {
			$girls[]=$row;
		}
	}
	$num_boys=count($boys);
	$num_girls=count($girls);
	$dept=$cr['department_id'];



	// pr($boys[0]);



	
?>




<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="scid" >Scid</th>
	<th>Male</th>
	<th>Code</th>
	<th>LRN</th>
	<th>Pos</th>
	<th>Student</th>
	<th class="center" >HNR<br>Q1</th>
	<th class="center" >HNR<br>Q2</th>
	<th class="center" >HNR<br>Q3</th>
	<th class="center" >HNR<br>Q4</th>
	
	<th colspan=3 class="hd" ></th>
</tr>
<tr><th colspan="<?php echo $colspan; ?>" >Boys</th><th colspan=3 class="hd" ></th></tr>
<?php for($i=0;$i<$num_boys;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $boys[$i]['scid']; ?></td>
	<td><?php echo $boys[$i]['is_male']; ?></td>
	<td><?php echo $boys[$i]['code']; ?></td>
	<td><?php echo $boys[$i]['lrn']; ?></td>
	<td><?php echo $boys[$i]['position']; ?></td>
	<td><?php echo $boys[$i]['name']; ?></td>

	<?php for($q=1;$q<5;$q++): ?>
		<td class="center" >
			<?php if($boys[$i]['honor_q'.$q]>0): ?>	
				<a href="<?php echo URL.'certificates/studentHonors/'.$boys[$i]['scid'].DS.$sy.'/'.$q; ?>" >
					<?php echo $boys[$i]['honor_q'.$q]+0; ?>
				</a>
			<?php endif; ?>
		</td>	
	<?php endfor; ?>
	

	<td class="hd" ><a href='<?php echo URL."contacts/ucis/".$boys[$i]['scid']; ?>' >Ucis</a></td>		
	<td class="hd" ><a href='<?php echo URL."profiles/student/".$boys[$i]['scid']; ?>' >Profile</a></td>		
	<?php if($_SESSION['settings']['rcard_adviser']==1): ?>
		<td class="hd" ><a href='<?php echo URL."rcards/scid/".$boys[$i]['scid']."/$sy/$qtr/0?tpl=".$dept; ?>' >
			Report Card</a></td>		
	<?php endif; ?>

	
</tr>
<?php endfor; ?>
<tr><th colspan="<?php echo $colspan; ?>" >Girls</th><th colspan=3 class="hd" ></th></tr>
<?php for($i=0;$i<$num_girls;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $girls[$i]['scid']; ?></td>
	<td><?php echo $girls[$i]['is_male']; ?></td>
	<td><?php echo $girls[$i]['code']; ?></td>
	<td><?php echo $girls[$i]['lrn']; ?></td>
	<td><?php echo $girls[$i]['position']; ?></td>
	<td><?php echo $girls[$i]['name']; ?></td>
	
	<?php for($q=1;$q<5;$q++): ?>
		<td class="center" >
			<?php if($girls[$i]['honor_q'.$q]>0): ?>	
				<a href="<?php echo URL.'certificates/studentHonors/'.$girls[$i]['scid'].DS.$sy.'/'.$q; ?>" >
					<?php echo $girls[$i]['honor_q'.$q]+0; ?>
				</a>
			<?php endif; ?>
		</td>	
	<?php endfor; ?>

	
	<td class="hd" ><a href='<?php echo URL."contacts/ucis/".$girls[$i]['scid']; ?>' >Ucis</a></td>		
	<td class="hd" ><a href='<?php echo URL."profiles/student/".$girls[$i]['scid']; ?>' >Profile</a></td>		
	<?php if($_SESSION['settings']['rcard_adviser']==1): ?>
		<td class="hd" ><a href='<?php echo URL."rcards/scid/".$girls[$i]['scid']."/$sy/$qtr/0?tpl=".$dept; ?>' >
			Report Card</a></td>		
	<?php endif; ?>
	
</tr>
<?php endfor; ?>


</table>



<div class="ht100" ></div>
