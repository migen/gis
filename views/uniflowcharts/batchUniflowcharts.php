<?php 

// pr($_SESSION['q1']);
$dbg=PDBG;
$dbtable="{$dbg}.01_flowcharts";

// pr($majors[0]);

?>

<h5>
	Create College Flowchart
	| <?php $this->shovel('homelinks'); ?>
	| <span class="blue u" onclick="ilabas('smartboard');" >Smartboard</span>	
	| <a href="<?php echo URL.'uniflowcharts/major/'.$major_id; ?>" >Major</a>
	| <a href="<?php echo URL.'unisubjects/create'; ?>" >Add Subjects</a>
	
</h5>

<div style="float:left;width:60%;" >


<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="center" >
		Major<br />
		<select id="imajor" class="vc150" >	
			<option> Choose </option>
			<?php foreach($majors as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name'].' #'.$sel['id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /><input type="button" value="All" onclick="populateColumn('major');" >
	</th>		
	<th class="center" >
		Subject<br />
		<select id="isub" class="vc200" >	
			<option> Choose </option>
			<?php foreach($unisubjects as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name'].' #'.$sel['id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /><input type="button" value="All" onclick="populateColumn('sub');" >
	</th>
	<th>Lvl<br />
		<input class="pdl05 vc50 center" id="ilvl" /><br />	
		<input type="button" value="All" onclick="populateColumn('lvl');" >							
	</th>
	<th>Sem<br />
		<input class="pdl05 vc50 center" id="isem" /><br />	
		<input type="button" value="All" onclick="populateColumn('sem');" >
	</th>	
	<th></th>	
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 2; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr id="trow-<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td>
		<select id="major<?php echo $i; ?>" class="major vc150" name="posts[<?php echo $i; ?>][major_id]" tabindex=2 >
			<option value=0 >Select One</option>
			<?php foreach($majors AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$major_id)? 'selected':NULL; ?> >
					<?php echo $sel['name'].' #'.$sel['id']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>	
	<td>
		<select id="sub<?php echo $i; ?>" class="sub vc200" name="posts[<?php echo $i; ?>][subject_id]" tabindex=4 >
			<option value=0 >Select One</option>
			<?php foreach($unisubjects AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>		
	<td><input id="lvl<?php echo $i; ?>" class="lvl center vc50" name="posts[<?php echo $i; ?>][level_id]" tabIndex=6 /></td>
	<td><input id="sem<?php echo $i; ?>" class="sem center vc50" name="posts[<?php echo $i; ?>][semester]" tabIndex=8 /></td>
	<td><button id="btn-<?php echo $i; ?>" onclick="xsaveData(<?php echo $i; ?>);return false;" >Save</button></td>
</tr>
<?php endfor; ?>

</table>

<p><input type="submit" name="submit" value="Create" /></p>

</form>

<p><?php $this->shovel('numrows'); ?></p>
<div class=" hd vc200" id="names" > </div>
</div>	<!-- main -->


<div class="" style="float:left;width:200px;"  >


<p class="smartboard" >
<select id="classbox" >
	<option value="major" >Major</option>
	<option value="sub" >Subject</option>
	<option value="lvl" >Level</option>
	<option value="sem" >Semester</option>

</select>
</p>
<?php $this->shovel('smartboard'); ?>
</div>



<!-- ------------------- -->


<script>

var gurl = "http://<?php echo GURL; ?>";
var limits='20';
var dbtable="<?php echo $dbtable; ?>";

$(function(){
	itago('smartboard');
	nextViaEnter();
	$('html').live('click',function(){ $('#names').hide(); });

})


function xsaveData(i){
	var major_id=$('select[name="posts['+i+'][major_id]"]').val();
	var sub=$('select[name="posts['+i+'][subject_id]"]').val();
	var lvl=$('input[name="posts['+i+'][level_id]"]').val();
	var sem=$('input[name="posts['+i+'][semester]"]').val();
	var vurl=gurl+'/ajax/xsaveData.php';	
	var task="xsaveData";	
	var pdata="task="+task+"&dbtable="+dbtable+"&major_id="+major_id+"&subject_id="+sub+"&level_id="+lvl+"&semester="+sem;
	
	$.ajax({ url:vurl,type:"POST",data:pdata,success: function() { $('#btn-'+i).hide(); } });				
	
}	/* fxn */





function redirContact(ucid){
	var url 		= gurl + '/students/sectioner/' + ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

