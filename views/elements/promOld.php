<?php

// pr($_SESSION['settings']);

$decigenave = $_SESSION['settings']['decigenave'];


$lvl = $data['classroom']['level_id'];

/* =========== DEFINE VARS =========== */
$sy			= $data['sy'];
$nsy		= $data['nsy'];
$boys 		= $data['boys'];
$num_boys	= $data['num_boys'];
$girls 		= $data['girls'];
$num_girls	= $data['num_girls'];
$cr 		= $data['classroom'];
$is_prom	= $data['is_prom'];
$yis		= $data['yis'];
$ntc		= $data['ntc'];
$ctc		= $data['ctc'];
$prep_locked = $data['prep_locked'];
$ratings 	= $data['ratings'];


/* =========== FUNCTIONS =========== */

$this->shovel('age');
$this->shovel('ratings');


?>


<h4>
	<span class="b" > For School Year </span>
	<span><input readonly onchange="yearend(this.value);" class="vc60 center" type="number" name="promotions[yearend]" value="<?php echo $nsy; ?>"  /> ~ <span id="yearend" ><?php echo ($nsy+1); ?></span></span>
</h4>


<h2> Profile Boys </h2>

<table class="gis-table-bordered table-fx boys" >
<tr class="headrow" >
	<th>#</th>
	<th class="hd" >CID</th>
	<th class="vc200" >Student</th>
	<th class="vc150" > Birthdate </th>
	<th class="center vc50" > Age </th>
	
	<th class="vc50" >1:Pass<br /> 0:Fail </th>					
	<th class="center" > 
		Promoted to<br />

	</th>			
	<th class="vc30" > &nbsp; </th>	<!-- lvl -->
	<th class="" > GenAve </th>	
	<th class="" > DG </th>	
	<th class="vc50" >Yrs in<br />Sch 
		<input class="vc50" type="text" id="iyis" value="" >
		<input type="button" value="All" onclick="populateColumn('yis');" >		
	</th>					
	<th class="vc50" > Units <br /> Prev 
		<input class="vc50" type="text" id="iuprev" value="" >
		<input type="button" value="All" onclick="populateColumn('uprev');" >		
	</th>							
	<th class="vc50" > Units <br /> Curr
		<input class="vc50" type="text" id="iucurr" value="" >
		<input type="button" value="All" onclick="populateColumn('ucurr');" >		
	</th>							
	<th class="vc50" > Units <br /> Total
		<input class="vc50" type="text" id="iutotal" value="" >
		<input type="button" value="All" onclick="populateColumn('utotal');" >		
	</th>									
		
</tr>

<?php for($i=0;$i<$num_boys;$i++): ?>
<input type="hidden" class="stud" value="1"  />
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $boys[$i]['scid']; ?></td>
	<td class="vc200" ><?php echo $boys[$i]['student'].'<br />'.$boys[$i]['student_code']; ?></td>
	<input type="hidden" class="mle" name="data[promotions][<?php echo $i; ?>][is_male]" value="1"  />
	
	<td><input class="center vc150 bbdy " type="date" name="data[promotions][<?php echo $i; ?>][birthdate]" 
		value="<?php $birthdate = $boys[$i]['birthdate']; echo $birthdate; ?>" readonly /></td>
	
	<?php 
		$birthmonth = $boys[$i]['birthmonth'];
		$birthyear  = $boys[$i]['birthyear'];
	?>
	
	<td><input id="bage-<?php echo $i; ?>" class="center vc50 age bage pbage pmage" type="text" name="data[promotions][<?php echo $i; ?>][age]" value="<?php $age = getAge($birthmonth,$birthyear,$sy); echo $age; ?>"  readonly /></td>

	
	<td><input id="prom-<?php echo $i; ?>" class="iprob iprom oprob vc50 center" name="data[promotions][<?php echo $i; ?>][is_promoted]" 
		value="<?php echo ($prep_locked)? $boys[$i]['is_promoted']:'1'; ?>"  readonly  ></td>		
	<td>
		<select id="<?php echo $i; ?>" onchange="thisAdviPromote(this.id,this.value,<?php echo $lvl; ?>);" class='full cr' 
			name='data[promotions][<?php echo $i; ?>][crid]'  >	
			<option value="<?php echo $ntc['crid']; ?>"><?php echo $ntc['classroom']; ?></option>
			<option value="<?php echo $ctc['crid']; ?>"><?php echo $ctc['classroom']; ?></option>
		</select>				
	</td>
	
	
	<td class="" >
		<input id="lvl<?php echo $i; ?>" class="vc30 lvl" type="text" name="data[promotions][<?php echo $i; ?>][level_id]" 
			value="<?php echo $ntc['lvl']; ?>" />
	</td>

	<td><?php $fgave = number_format($boys[$i]['ave_q5'],$decigenave); echo $fgave ; ?></td>	
	<td class="dgb" ><?php $dg = rating($fgave,$ratings); echo $dg; ?></td>
	
	<td><input class="yis vc50 center" type="text" name="data[promotions][<?php echo $i; ?>][years_in_school]" 
		value="<?php echo $boys[$i]['years_in_school']; ?>"  /></td>
	
	<td><input onchange="tallyUnitsTotal(<?php echo $i; ?>)" id="unitsprev-<?php echo $i; ?>" class="uprev vc50 center" 
		name="data[promotions][<?php echo $i; ?>][units_previous]" value="<?php echo $boys[$i]['units_previous']; ?>" ></td>
	<td><input onchange="tallyUnitsTotal(<?php echo $i; ?>)" id="unitscurr-<?php echo $i; ?>" class="ucurr vc50 center" 
		name="data[promotions][<?php echo $i; ?>][units_current]" value="<?php echo $boys[$i]['units_current']; ?>" ></td>
	<td><input id="unitstotal-<?php echo $i; ?>" class="utotal vc50 center" name="data[promotions][<?php echo $i; ?>][units_total]" 
		value="<?php echo $boys[$i]['units_total']; ?>" ></td>
				
	
	<!-- hidden scid -->
	<input type="hidden" name="data[promotions][<?php echo $i; ?>][scid]" value="<?php  echo $boys[$i]['scid']; ?>" >
</tr>
<?php endfor; ?>
</table>

<br /><hr /><br />
<!-- ================================================================================ -->
<h2> Profile Girls </h2>

<table class="gis-table-bordered table-fx boys" >
<tr class="headrow" >
	<th>#</th>
	<th class="hd" >CID</th>
	<th>Student</th>
	<th> Birthdate </th>
	<th class="center" > Age </th>	
	<th class="vc50" >1:Pass<br /> 0:Fail </th>					
	<th class="center vc100" > Promoted to </th>	
	<th class="" > &nbsp; </th>	
	<th class="" > GenAve </th>	
	<th class="" > DG </th>	
	<th class="center vc50" >Yrs in<br />Sch</th>	
	<th class="" > Units <br /> Prev </th>	
	<th class="" > Units <br /> Curr </th>	
	<th class="" > Units <br /> Total </th>	
	
</tr>

<?php $j = $num_boys; ?>
<?php for($i=0;$i<$num_girls;$i++): ?>
<input type="hidden" class="stud" value="1" />
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $girls[$i]['scid']; ?></td>
	<td class="vc200" ><?php echo $girls[$i]['student'].'<br />'.$girls[$i]['student_code']; ?></td>
	<input type="hidden" class="grl" name="data[promotions][<?php echo $j; ?>][is_male]" value="0"  />
	
	<td><input class="gbdy center vc150" type="date" name="data[promotions][<?php echo $j; ?>][birthdate]" 
		value="<?php $birthdate = $girls[$i]['birthdate']; echo $birthdate; ?>" readonly ></td>

	<?php 
		$birthmonth = $girls[$i]['birthmonth'];
		$birthyear  = $girls[$i]['birthyear'];
	?>

	<td><input id="gage-<?php echo $j; ?>" class="gage pgage pmage age vc50 center" type="text" name="data[promotions][<?php echo $j; ?>][age]" 	value="<?php $age = getAge($birthmonth,$birthyear,$sy); echo $age; ?>" readonly ></td>	

	<td><input id="prom-<?php echo $j; ?>" class="iprog iprom oprog oprog vc50 center" name="data[promotions][<?php echo $j; ?>][is_promoted]" 		value="<?php echo ($prep_locked)? $girls[$i]['is_promoted']:'1'; ?>"  readonly  ></td>				
	<td>
		<select id="<?php echo $j; ?>" onchange="thisAdviPromote(this.id,this.value,<?php echo $lvl; ?>);" class='full cr' 
			name='data[promotions][<?php echo $j; ?>][crid]'  >
			<option value="<?php echo $ntc['crid']; ?>"><?php echo $ntc['classroom']; ?></option>
			<option value="<?php echo $ctc['crid']; ?>"><?php echo $ctc['classroom']; ?></option>
		</select>				
	</td>		
	
	<td class="" >
		<input class="vc30 center lvl" id="lvl<?php echo $j; ?>"  type="text" name="data[promotions][<?php echo $j; ?>][level_id]" 
			value="<?php echo $ntc['lvl']; ?>" readonly />
	</td>
		
	<td><?php $fgave = number_format($girls[$i]['ave_q5'],$decigenave); echo $fgave ; ?></td>	
	<td class="dgg" ><?php $dg = rating($fgave,$ratings); echo $dg; ?></td>
	
	<td><input class="yis vc50 center" type="text" name="data[promotions][<?php echo $j; ?>][years_in_school]" 
		value="<?php echo $girls[$i]['years_in_school']; ?>"  /></td>
	
	<td><input onchange="tallyUnitsTotal(<?php echo $j; ?>)" id="unitsprev-<?php echo $j; ?>" class="uprev vc50 center" 
		name="data[promotions][<?php echo $j; ?>][units_previous]" value="<?php echo $girls[$i]['units_previous']; ?>" ></td>
	<td><input onchange="tallyUnitsTotal(<?php echo $j; ?>)" id="unitscurr-<?php echo $j; ?>" class="ucurr vc50 center" 
		name="data[promotions][<?php echo $j; ?>][units_current]" value="<?php echo $girls[$i]['units_current']; ?>" ></td>
	<td><input id="unitstotal-<?php echo $j; ?>" class="utotal vc50 center" name="data[promotions][<?php echo $j; ?>][units_total]" 
		value="<?php echo $girls[$i]['units_total']; ?>" ></td>
		
	<!-- hidden scid -->
	<input type="hidden" name="data[promotions][<?php echo $j; ?>][scid]" value="<?php  echo $girls[$i]['scid']; ?>" >
</tr>
<?php $j++; ?>
<?php endfor; ?>
</table>

<br /><hr /><br />
<!-- ================================================================================ -->

