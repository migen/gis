<?php

// pr($data);
// pr($students[0]);
pr($_SESSION['q']);



?>


<h5>
	Class Pool <?php $classroom['name']; ?> | 
	<?php 	$controller = 'mis'; $this->shovel('homelinks',$controller); ?>
	| <a href="<?php echo URL.'mis/subjects'; ?>">Subjects</a> 
		
</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>

<!---------------------------------------------------------------------------->

<table class="gis-table-bordered table-fx table-altrow" >
	<tr><th class="headrow white" >Level</th><td><?php echo $classroom['level']; ?></td></tr>
	<tr><th class="headrow white" >Section</th><td><?php echo $classroom['section']; ?></td></tr>
	<tr><th class="headrow white" >Classroom</th><td><?php echo $classroom['name']; ?></td></tr>
	<tr><th class="headrow white" >Adviser</th><td><?php echo $classroom['adviser']; ?></td></tr>
	<tr><th class="headrow white" >Adviser Code</th><td><?php echo $classroom['acid'].' - '.$classroom['adviser_code']; ?></td></tr>
	<tr>
		<th class="headrow white" > Go </th> 
		<td>	
		<select class="vc300" onchange="redirCls(this.value);" >
			<option value="0">Classroom Students</option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select> 
		</td>
		
	</tr>	
</table> 

<!----------------------------------------------------------------------------> 

<p>
<table> 

</table>
</p>

<!-------------------------------------------------------------------------------------->

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>ID Number</th>
	<th>Student</th>
	<th class="center" >SCID</th>
	<th>
		<input class="pdl05 vc70" type="text" id="isy" placeholder="SY" /><br />	
		<input type="button" value="All" onclick="populateColumn('sy');" >			
	</th>
	<th class="hd" >
		<input class="pdl05 vc70" type="text" id="isxnd" placeholder="Sxnd" /><br />	
		<input type="button" value="All" onclick="populateColumn('sxnd');" >					
	</th>
	<th>
		<select id="ipcr" class='vc120'>	
			<option> Previous </option>
			<?php foreach($data['classrooms'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> From <input type="button" value="All" onclick="populateColumn('pcr');" >		
	</th>
	<th>
		<select id="icr" class='vc120'>	
			<option> Select classroom </option>
			<?php foreach($data['classrooms'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> To <input type="button" value="All" onclick="clsAdvi(<?php echo $sy; ?>);" >	
	</th>
	<th class="center" >Manage </th>
	<th>Advi</th>
</tr>

<!------------------------ data below ----------------------------------------------------------->

<form method="POST" >
<?php for($i=0;$i<$num_students;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['student_code']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<td><input class="right pdr05 vc50" type="text" name="students[<?php echo $i; ?>][scid]" value="<?php echo $students[$i]['scid']; ?>"   readonly /></td>
	<td><input id="sy<?php echo $i; ?>" class="sy right pdr05 vc70" name="students[<?php echo $i; ?>][sy]" type="number" value="<?php echo $students[$i]['sy']; ?>"  ></td>
	<td class="hd" >
		<select id="sxnd<?php echo $i; ?>"  class="sxnd right pdr05 vc50" name="students[<?php echo $i; ?>][is_sectioned]"   >
			<option value="1" <?php echo ($students[$i]['is_sectioned']==1)? 'selected':NULL; ?>  >1</option>
			<option value="0" <?php echo ($students[$i]['is_sectioned']!=1)? 'selected':NULL; ?>  >0</option>
		</select>
	</td>
	<td>
		<select id="pcr<?php echo $i; ?>" class="vc120 pcr" name="students[<?php echo $i; ?>][prevcrid]"  >
			<option> Prev </option>
			<?php foreach($data['classrooms'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  <?php if($sel['id']==$students[$i]['prevcrid']){ echo 'selected'; }   ?>  > <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>
	</td>
	
	<td>
		<select id="<?php echo $i; ?>" onchange="thisAdvi(this.id,this.value,<?php echo $sy; ?>);"  class="vc120 cr" name="students[<?php echo $i; ?>][crid]"  >
			<option> New  </option>
			<?php foreach($data['classrooms'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$students[$i]['crid'])? 'selected':null; ?>  > <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>
	</td>
	<td> 
		<button class="vc80" id="scb<?php echo $i; ?>" onclick="xeditStudCls(<?php echo $i.','.$students[$i]['scid']; ?>);return false;" > Save </button>  
		<button class="vc80" ><a class="no-underline" href="<?php echo URL.'mis/editContact/'.$students[$i]['scid']; ?>" > Edit </a> </button>		
	</td>	
	<td>
		<input name="students[<?php echo $i; ?>][acid]" id="advi<?php echo $i; ?>" class="vc50 advi right pdr05" type="text" name="students[<?php echo $i; ?>][acid]" value="<?php echo $classroom['acid']; ?>"  readonly />
	</td>	
</tr>

<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save All"  /></p>

</form>

<!---------------------------------------------------------------------------->

<script>

var gurl 	= 'http://<?php echo GURL; ?>';
var hdpass 	= '<?php echo HDPASS; ?>';
var sy 		= '<?php echo $sy; ?>';

$(function(){
	hd();
	$('#hdpdiv').hide();
	// initClsAdvi();

})


function xeditStudCls(i,scid){
	$('#scb'+i).hide();
	
	var studsy 		= $('#sy'+i).val();
	// var cr 		= $('#cr'+i).val();
	var cr 		= $('.cr#'+i).val();

	var pcr 	= $('#pcr'+i).val();
	var acid 	= $('#advi'+i).val();
	var sxnd 	= $('#sxnd'+i).val();
	
	var vurl = gurl + '/mis/xeditStudCls/'+scid+'/'+sy;	
	// alert(vurl+',scid: '+scid+',sy: '+sy+',cr: '+cr+',pcr: '+pcr+',acid: '+acid);
	
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: "studsy="+studsy+"&cr="+cr+"&pcr="+pcr+"&acid="+acid+"&sxnd="+sxnd,	  	  			  
	  success:function(){} 
   });				

	
}	


function initClsAdvi(){
	var crid = $("#crid").text();
	
	var vurl 	= gurl + '/registrars/clsAdvi/'+sy;	
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'crid='+crid,				
		async: true,
		success: function(s) { 
			$('.advi').val(s.acid);							
		}		  
    });				
	
}	


function redirCls(crid){
	var rurl 	= gurl + '/mis/classpool/'+crid+'/'+sy;			
	window.location = rurl;		
}

</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/promotions.js"></script>
