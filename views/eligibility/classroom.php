<?php 



// pr($profiles[0]);
// pr($profiles);
// pr($_SESSION['q']);

$with_chinese = $_SESSION['settings']['with_chinese'];

// echo "with_chinese: $with_chinese <br />";

?>

<!-- ========================  filter hd =================================-->

<h5>
	Profiling 
	<?php echo $classroom['name']." ($num_profiles)"; ?>
 (<?php echo (isset($_GET['sort']) && $_GET['sort']=='c.position')? 'Position':'Alphabetical'; ?>)	
	| <a href="<?php echo URL.$home; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."profiles/classroom/$crid/$sy"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."profiles/classroom/$crid/$sy?sort=c.position"; ?>' >Position</a> 			
<?php endif; ?>	
	
	| <a href="<?php echo URL.'classlists/classroom/'.$crid; ?>">Classlist</a>		
	<?php if($_SESSION['srid']!=RTEAC): ?>
		| <a href="<?php echo URL.'students/sectioner'; ?>">Sectioner</a>		
	<?php endif; ?>
	<span class="u" onclick="ilabas('clipboard')" >|Smartboard</span>
	
</h5>



<?php if($_SESSION['srid']!=RTEAC): ?>
<table class='gis-table-bordered table-fx'>
	<tr><th>Classroom</th><td class="vc300" ><?php echo $classroom['level'].' - '.$classroom['section']; ?></td></tr>
	<tr><th>Adviser ID</th><td><?php echo $classroom['login']; ?></td></tr>
	<tr><th>Adviser</th><td><?php echo $classroom['adviser']; ?></td></tr>
</table>
<?php endif; ?>

<br />



<!-- listStudents -->

<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th>#</th>
	<th>Save</th>
	<th>PCID</th>
	<th>ID Number</th>
	<?php if($_SESSION['settings']['editable_code']==1): ?>
		<th>New ID</th>
	<?php endif; ?>
	<th class="" >Full Name (SURNAME,FIRST MI) </th>
	<?php if($with_chinese): ?>
		<th>Chinese <br /> Name</th>	
	<?php endif; ?>
	<th>LRN</th>	
	<th class="vc70" >Birthdate <br /><span style="font-weight:normal;font-size:0.8em;" >YYYY-MM-DD</span></th>
	<th class="vc150" >Address</th>
	<th class="vc50" >
		<select id="imale" class='vc70'>	
			<option value="1" > Male </option>
			<option value="0" > Female </option>
		</select>					
		<br />	
		<input type="button" value="All" onclick="populateColumn('male');" >						
	</th>

	<th class="vc150" >
		<input class="pdl05 vc70" type="text" id="irmks" placeholder="Remarks" /><br />	
		<input type="button" value="All" onclick="populateColumn('rmks');" >						
	</th>
	
	<th>GRP<br />
		<input class="pdl05 vc50" id="igrp" /><br />	
		<input type="button" value="All" onclick="populateColumn('grp');" >							
	</th>
	
	<th>POS<br />
		<input class="pdl05 vc50" id="ipos" /><br />	
		<input type="button" value="All" onclick="populateColumn('pos');" >							
	</th>
	<th class="vc50" >Save</th>
</tr>

<form method='post' > <!-- for batch edit/delete -->

<!------------------- data ------------------------------------------------------->

<?php for($i=0;$i<$num_profiles;$i++): ?>

<tr rel="<?php echo $profiles[$i]['scid']; ?>" class="<?php echo (even($i))? 'even':'odd'?>" >
	<td><?php echo $i+1; ?></td>
<td> <button id="csb<?php echo $i; ?>" onclick="xeditProfiling(<?php echo $i.','.$profiles[$i]['scid']; ?>);return false;" >Save</button>  </td>
	
	<td><?php echo $profiles[$i]['pcid']; ?></td>	
	<td>
		<a href="<?php echo URL.'contacts/ucis/'.$profiles[$i]['scid']; ?>"><?php echo $profiles[$i]['student_code']; ?></a> 
	</td>	

<?php if($_SESSION['settings']['editable_code']==1): ?>	
	<td><input class="vc100 pdl05" id="code<?php echo $i; ?>" type="text" name="profiles[<?php echo $i; ?>][code]" 
		tabindex="10" value="<?php echo $profiles[$i]['student_code']; ?>" ></td>	
<?php else: ?>
	<input id="code<?php echo $i; ?>" type="hidden" name="profiles[<?php echo $i; ?>][code]" tabindex="10" 
		value="<?php echo $profiles[$i]['student_code']; ?>" >
<?php endif; ?>
	
	<td><input class="vc300 pdl05" id="fullname<?php echo $i; ?>" type="text" name="profiles[<?php echo $i; ?>][fullname]" 
		tabindex="20" value="<?php echo $profiles[$i]['fullname']; ?>" ></td>

<?php if($with_chinese): ?>
	<td><input class="vc50 center" id="cname<?php echo $i; ?>" type="text" name="profiles[<?php echo $i; ?>][cname]" 
		tabindex="30" value="<?php echo $profiles[$i]['cname']; ?>" readonly >
		<br />
		<a href="<?php echo URL.'alien/cnname/'.$profiles[$i]['scid']; ?>" >Edit</a>
		</td>		
<?php else: ?>
	<input id="cname<?php echo $i; ?>" type="hidden" name="profiles[<?php echo $i; ?>][cname]" 
		tabindex="40" value="<?php echo $profiles[$i]['cname']; ?>" >			
<?php endif; ?>
	<td><input class="vc120 pdr05" id="lrn<?php echo $i; ?>" type="text" name="profiles[<?php echo $i; ?>][lrn]" 
		tabindex="50" value="<?php echo $profiles[$i]['lrn']; ?>" ></td>		
	<td><input id="birthdate<?php echo $i; ?>" class="right pdr05 vc100" tabindex="60" 
		name="profiles[<?php echo $i; ?>][birthdate]" value="<?php echo $profiles[$i]['birthdate']; ?>"  ></td>	
	
	<td><input id="address<?php echo $i; ?>" class="left pdl05 vc500" maxlength="100" tabindex="70" 
		name="profiles[<?php echo $i; ?>][address]" value="<?php echo $profiles[$i]['address']; ?>"  ></td>

	<td>
		<select id="is_male<?php echo $i; ?>" class="right pdr05 vc50 male" name="profiles[<?php echo $i; ?>][is_male]" 
			tabindex="90"  >
			<option value="1" <?php echo ($profiles[$i]['is_male'])? 'selected':NULL; ?>  >Y</option>
			<option value="0" <?php echo (!$profiles[$i]['is_male'])? 'selected':NULL; ?>  >N</option>
		</select>	
	</td>	
		
	<td>
		<input id="remarks<?php echo $i; ?>" class="left pdl05 full rmks" maxlength="100" 
			name="profiles[<?php echo $i; ?>][remarks]" tabindex="100" 
			value="<?php echo $profiles[$i]['remarks']; ?>"  /></td>

	<td>
		<input id="grp<?php echo $i; ?>" class="left pdl05 full grp" 
			name="profiles[<?php echo $i; ?>][grp]" tabindex="105" 
			value="<?php echo $profiles[$i]['grp']; ?>"  /></td>
			
	<td>
		<?php // $tab = 1000+$i; ?>
		<input id="posi<?php echo $i; ?>" class="left pdl05 vc50 pos" 
			name="profiles[<?php echo $i; ?>][position]"  tabIndex="110" 
			value="<?php echo $profiles[$i]['position']; ?>" /></td>	
			
<td> <button id="csb<?php echo $i; ?>" onclick="xeditProfiling(<?php echo $i.','.$profiles[$i]['scid']; ?>);return false;" >Save</button>  </td>
		
	<input type="hidden" id="cid<?php echo $i; ?>" class="right pdr05 vc70" name="profiles[<?php echo $i; ?>][cid]" value="<?php echo $profiles[$i]['scid']; ?>"  >
	
</tr>

<?php endfor; ?>
</table>


<p>
<input type="submit" name="save" value="Save All" onclick="return confirm('Sure?');" />
</p>

</form> <!-- for batch -->



<div style="width:50px;float:left;height:100px;" ></div>

<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="lrn" >LRN</option>
	<option value="code" >New ID</option>
	<option value="is_male" >Male</option>
	<option value="address" >Address</option>
	<option value="posi" >Position</option>
	<option value="birthdate" >Birthdate</option>
	<option value="remarks" >Remarks</option>

</select>
</p>
<?php $d['width'] = '40'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<!-- ------------------------------------------------------------------------------------------------------  -->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo $home; ?>';
var sy 	 = '<?php echo $sy; ?>';

$(function(){
	nextViaEnter();
	itago('clipboard');

})




function xeditProfiling(i,cid){

	$('#csb'+i).hide();	
	
	var posi = $('#posi'+i).val();
	var lrn 		= $('#lrn'+i).val();
	var code 		= $('#code'+i).val();
	var fullname 	= $('#fullname'+i).val();
	var cname 		= $('#cname'+i).val();
	var birthdate	= $('#birthdate'+i).val();
	var address		= $('#address'+i).val();
	var is_male		= $('#is_male'+i).val();
	var remarks		= $('#remarks'+i).val();
	var grp		= $('#grp'+i).val();
		
	var vurl 	= gurl + '/ajax/xprofiling.php';	
	var task	= "xeditProfiling";	
	var pdata = "task="+task+"&cid="+cid+"&code="+code+"&fullname="+fullname+"&cname="+cname+"&birthdate="+birthdate;
	pdata += "&address="+address+"&is_male="+is_male+"&remarks="+remarks+"&lrn="+lrn+"&posi="+posi+"&grp="+grp;

	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,
	  success:function(){} 
   });				
	
}	/* fxn */




</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/promotions.js"></script>
