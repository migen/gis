<?php


// echo 'ntc crid: ';pr($ntc['crid']);
// echo 'ctc crid: ';pr($ctc['crid']);

// pr($data['boys'][0]);


$decigenave = $_SESSION['settings']['decigenave'];


$lvl = $data['classroom']['level_id'];

/* =========== DEFINE VARS =========== */
$boys 		= $data['boys'];
$num_boys	= $data['num_boys'];
$girls 		= $data['girls'];
$num_girls	= $data['num_girls'];
$cr 		= $data['classroom'];
$is_prom	= $data['is_prom'];
$sy 		= $data['sy'];
$nsy 		= $data['nsy'];
$yis		= $data['yis'];
$ntc		= $data['ntc'];
$ctc		= $data['ctc'];
$ratings	= $data['ratings'];
$prep_locked = $data['prep_locked'];



/* =========== FUNCTIONS =========== */

// pr($ratings);
$this->shovel('age');
$this->shovel('ratings');

$is_locked = $data['is_locked'];
$readonly = ($is_locked)? 'readonly' : NULL;




?>


<h4>
	<span class="b" > For School Year </span>
	<span><input readonly onchange="yearend(this.value);" class="vc60 center" type="number" value="<?php echo $nsy; ?>"  /> - <span id="yearend" ><?php echo ($nsy+1); ?></span></span>
</h4>



<h2> Profile Boys </h2>

<table class="gis-table-bordered table-fx boys" >
<tr class="headrow" >
	<th class="vc50" >#</th>	
	<th class="hd" >CID</th>
	<th class="vc200" >Student</th>
	<th class="vc50 center" >1:Promoted<br /> 0:Retained<br /> 2:Conditional 
		<br /><input class="vc50 center" id="iiprom" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('iprom');" >							
	</th>				
	<th class="" > Promoted to /<br />Retained in
	<?php if($_SESSION['srid']==RMIS): ?>
		<br /><select id="icr" class='vc120'>	
			<option value="<?php echo $ntc['crid']; ?>" ><?php echo $ntc['classroom'].' #'.$ntc['crid']; ?></option>
			<option value="<?php echo $ctc['crid']; ?>" ><?php echo $ctc['classroom'].' #'.$ctc['crid']; ?></option>		
		</select>				
		<br /> <input type="button" value="All" onclick="clsAdvi(<?php echo $sy; ?>);" >		
	<?php endif; ?>
	
	</th>	
	<th class="vc50" >Inc<br />Units</th>		
	<th class="vc150" >Inc<br />Subjects</th>		
	<th class="vc120" >Elig<br />Date
		<br /><input class="pdl05 vc120" type="date" id="ied" placeholder="Elig Date" 
			value="<?php echo $_SESSION['today']; ?>" /><br />	
		<input type="button" value="All" onclick="populateColumn('ed');" >							
	</th>		
	<th class="vc50" >1:Reg<br />0:Irreg</th>			
	<th class="vc30" >Prom<br />Lvl
	<?php if($_SESSION['srid']==RMIS): ?>
		<input class="pdl05 vc50" type="number" id="ilvl" value="" /><br />	
		<input type="button" value="All" onclick="populateColumn('lvl');" >							
	<?php endif; ?>
	
	</th>				
	<th class="" > Genave </th>	
	<th class="center" > DG </th>	
	<th class="center" >Save</th>	
	<th class="center" >Sxnr</th>	
	
	
		
</tr>

<?php for($i=0;$i<$num_boys;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $boys[$i]['scid']; ?></td>
	<td class="vc200" ><?php echo $boys[$i]['student'].'<br />'.$boys[$i]['student_code']; ?></td>
	<input type="hidden" class="std mle" name="data[promotions][<?php echo $i; ?>][is_male]" value="1"  />
		
	<?php $prep_locked = $data['prep_locked']; ?>
	<td>
		<input id="prom-<?php echo $i; ?>" class="iprob iprom oprob oprom vc50 center" 
		name="data[promotions][<?php echo $i; ?>][is_promoted]" type="number"
		value="<?php echo isset($boys[$i]['is_promoted'])? $boys[$i]['is_promoted']:'1'; ?>" ></td>		
	<td>
		<select id="<?php echo $i; ?>" onchange="thisAdviPromote(this.id,this.value,<?php echo $lvl; ?>);" class='vc100 cr'  name="data[promotions][<?php echo $i; ?>][crid]" >	
			<option value="<?php echo $ntc['crid']; ?>"
				<?php echo ((isset($boys[$i]['promcrid'])) && ($boys[$i]['promcrid']==$ntc['crid']))? 'selected':NULL; ?> 
			><?php echo $ntc['classroom']; ?></option>			
			<option value="<?php echo $ctc['crid']; ?>"
				<?php echo ((isset($boys[$i]['promcrid'])) && ($boys[$i]['promcrid']==$ctc['crid']))? 'selected':NULL; ?> 
			><?php echo $ctc['classroom']; ?></option>						
		</select>				
	</td>				
	
	<td><input type="text" id="incunits-<?php echo $i; ?>" class="pdl05 full" 
		name="data[promotions][<?php echo $i; ?>][incunits]" value="<?php echo $boys[$i]['incunits']; ?>" ></td>			
	
	<td><input type="text" id="incsubj-<?php echo $i; ?>" class="pdl05 full" name="data[promotions][<?php echo $i; ?>][incsubj]" value="<?php echo $boys[$i]['incsubj']; ?>" ></td>		
	
	<td><input type="date" id="eligdate-<?php echo $i; ?>" class="pdl05 full ed" name="data[promotions][<?php echo $i; ?>][eligdate]" value="<?php echo $boys[$i]['eligdate']; ?>" ></td>		
	
	<td><input id="reg-<?php echo $i; ?>" class="iregb ireg vc50 center" type="text" name="data[promotions][<?php echo $i; ?>][is_regular]" value="<?php echo $boys[$i]['is_regular']; ?>"   /></td>

	<td class="" >	
		<input class="hd" id="advi<?php echo $i; ?>" class="vc50 advi" type="text" name="data[promotions][<?php echo $i; ?>][acid]" value="<?php echo $ntc['acid']; ?>" readonly />
		<input class="vc30 center lvl" id="lvl<?php echo $i; ?>" type="text" name="data[promotions][<?php echo $i; ?>][promlvl]" value="<?php echo isset($boys[$i]['promlvl'])? $boys[$i]['promlvl']:$ntc['lvl']; ?>" readonly />
	</td>
	
	<td><?php $fgave = number_format($boys[$i]['ave_q5'],$decigenave); echo $fgave ; ?></td>
	<td class="dgb" ><?php $dg = rating($fgave,$ratings); echo $dg; ?></td>
	<td><button id="btn<?php echo $i; ?>" onclick="xpromote(<?php echo $i; ?>);return false;" >Save</button></td>
	<td><a href="<?php echo URL.'students/sectioner/'.$boys[$i]['scid'].DS.$sy; ?>" >Sxnr</a></td>
		
	<!-- hidden scid -->
	<input type="hidden" name="data[promotions][<?php echo $i; ?>][scid]" value="<?php  echo $boys[$i]['scid']; ?>" >
</tr>
<?php endfor; ?>
</table>

<br /><hr /><br />
<!-- ================================================================================ -->



<h2> Girls </h2>

<table class="gis-table-bordered table-fx boys" >
<tr class="headrow" >
	<th class="vc50" >#</th>
	<th class="hd" >CID</th>
	<th class="vc200" >Student</th>
	<th class="vc50 center" >1:Promoted<br /> 0:Retained</th>				
	<th class="center" > Promoted to / <br />Retained in </th>	
	<th class="vc50" >Inc<br />Units</th>		
	<th class="vc150" >Inc<br />Subjects</th>		
	<th class="vc150" >Elig<br />Date</th>		
	<th class="vc50" >1:Reg<br />0:Irreg</th>			
	<th class="vc30" >Prom<br />Lvl</th>				
	<th class="center" > Genave </th>	
	<th class="center" > DG </th>	
	<th class="center" >Save</th>	
	<th class="center" >Sxnr</th>	

</tr>


<?php $j = $num_boys; ?>
<?php for($i=0;$i<$num_girls;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $girls[$i]['scid']; ?></td>
	<td class="vc200" ><?php echo $girls[$i]['student'].'<br />'.$girls[$i]['student_code']; ?></td>
	<input type="hidden" class="std grl" name="data[promotions][<?php echo $j; ?>][is_male]" value="0"  />		

	<td>
		<input id="prom-<?php echo $j; ?>" class="iprog iprom oprog oprom vc50 center" 
		name="data[promotions][<?php echo $j; ?>][is_promoted]" 
		value="<?php echo isset($girls[$i]['is_promoted'])? $girls[$i]['is_promoted']:'1'; ?>" readonly ></td>	

	<td>
		<select id="<?php echo $j; ?>" onchange="thisAdviPromote(this.id,this.value,<?php echo $lvl; ?>);" class='vc100 cr'  name="data[promotions][<?php echo $j; ?>][crid]" >	
			<option value="<?php echo $ntc['crid']; ?>"
				<?php echo ((isset($girls[$i]['promcrid'])) && ($girls[$i]['promcrid']==$ntc['crid']))? 'selected':NULL; ?> 
			><?php echo $ntc['classroom']; ?></option>			
			<option value="<?php echo $ctc['crid']; ?>"
				<?php echo ((isset($girls[$i]['promcrid'])) && ($girls[$i]['promcrid']==$ctc['crid']))? 'selected':NULL; ?> 
			><?php echo $ctc['classroom']; ?></option>						
		</select>				
	</td>				
			
	<td><input id="incunits-<?php echo $j; ?>" class="pdl05 full" type="text" name="data[promotions][<?php echo $j; ?>][incunits]" value="<?php echo $girls[$i]['incunits']; ?>"  ></td>			
	
	<td><input id="incsubj-<?php echo $j; ?>" class="pdl05 full" type="text" name="data[promotions][<?php echo $j; ?>][incsubj]" value="<?php echo $girls[$i]['incsubj']; ?>"  ></td>		
	
	<td><input id="eligdate-<?php echo $j; ?>" class="pdl05 full ed" type="date" name="data[promotions][<?php echo $j; ?>][eligdate]" value="<?php echo $girls[$i]['eligdate']; ?>"  ></td>			
	
	<td><input id="reg-<?php echo $j; ?>" class="iregg ireg vc50 center" type="text" name="data[promotions][<?php echo $j; ?>][is_regular]" value="<?php echo $girls[$i]['is_regular']; ?>"  /></td>
	
	<td class="" >
		<input class="hd" id="advi<?php echo $j; ?>" class="vc50 advi" type="text" name="data[promotions][<?php echo $j; ?>][acid]" value="<?php echo $ntc['acid']; ?>" readonly />
		<input class="vc30 center lvl" id="lvl<?php echo $j; ?>"  type="text" name="data[promotions][<?php echo $j; ?>][level_id]" value="<?php echo $ntc['lvl']; ?>" readonly />
	</td>
	
	<td><?php $fgave = number_format($girls[$i]['ave_q5'],$decigenave); echo $fgave ; ?></td>	
	<td class="dgg" ><?php $dg = rating($fgave,$ratings); echo $dg; ?></td>

	<td><button id="btn<?php echo $i; ?>" onclick="xpromote(<?php echo $j; ?>);return false;" >Save</button></td>
	<td><a href="<?php echo URL.'students/sectioner/'.$girls[$i]['scid'].DS.$sy; ?>" >Sxnr</a></td>
	
		
	<!-- hidden scid -->
	<input type="hidden" name="data[promotions][<?php echo $j; ?>][scid]" value="<?php  echo $girls[$i]['scid']; ?>" >
</tr>
<?php $j++; ?>
<?php endfor; ?>
</table>

<br /><hr /><br />





<!-- ================================================================================ -->

<script>

var sy="<?php echo $sy; ?>";

function xpromote(i){
	$('#btn'+i).hide();
	var scid = $('input[name="data[promotions]['+i+'][scid]"]').val();	
	var promcrid=$('#'+i).val();
	var promlvl = $('input[name="data[promotions]['+i+'][promlvl]"]').val();	
	var isprom = $('input[name="data[promotions]['+i+'][is_promoted]"]').val();	
	var incunits = $('input[name="data[promotions]['+i+'][incunits]"]').val();	
	var incsubj = $('input[name="data[promotions]['+i+'][incsubj]"]').val();	

	var vurl 	= gurl + '/ajax/xpromotions.php';	
	var task	= "xpromk12";		
	var pdata='task='+task+'&scid='+scid+'&is_promoted='+isprom+'&promcrid='+promcrid+'&promlvl='+promlvl+'&incunits='+incunits+'&incsubj='+incsubj+'&sy='+sy;

	$.ajax({
		url: vurl,type: 'POST',async: true,
		data: pdata,						
		success: function() { }		  
    });					

	
}


</script>

