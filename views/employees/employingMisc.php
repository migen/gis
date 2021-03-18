<?php 

// pr($_SESSION['q']);
// pr($employees[0]);

// pr($titles);
// pr($data);
// pr($employees);

?>

<?php 
	$readonly = isset($_SESSION['readonly'])? $_SESSION['readonly'] : true;

	
?>

<!-------------------------------------------------------------------->

<h5> 
	<span class="u" ondblclick="traceshd();" >Employing</span> 	
	<span class="hd" >HD</span>
	| <a href="<?php echo URL.$home; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
<?php if($_SESSION['srid']==RMIS): ?>		
		| <a href="<?php echo URL.'mis/employer'; ?>" >Employer</a> 	
<?php endif; ?>
	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>	
	
	
</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>

	
<?php if($_SESSION['srid']==RMIS): ?>
<table>
<tr><th class="white bg-blue2" >Role</th>
	<td>
		<select class="vc200" onchange="redirectRole('employing',this.value);" >
			<option>Choose One</option>
			<option value="0">All with Teachers</option>
			<option value="1">All Non-Teachers</option>
			<?php foreach($roles AS $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php endforeach; ?>
		</select>
	</td>
</tr>
</table>
<?php endif; ?>

<p>*Ajax UpdateRow, Attschema</p>

<!-------------------------------------------------------------------->


<form method="POST" >


<table class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
	<th>#</th>
	<th>U|P</th>
	<th>ID<br />Number</th>
	<th>Name</th>
	
	<th colspan="" class="center" > 
		<select id="ititle" class='vc120'>	
			<option>Title</option>
			<?php foreach($titles as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /><input type="button" value="All" onclick="populateTitle('title');" >			
	</th>	
	<th class="" >T</th>
	<th class="" >R</th>
	<th class="" >P</th>
	

<!-- contacts -->	
	<th class="hd" >
		<input class="pdl05 vc50" type="number" min=0 max=1 id="imale" placeholder="Male" /><br />	
		<input type="button" value="All" onclick="populateColumn('male');" >					
	</th>	
	<th class="hd" >
		<input class="center vc50" type="number" min=0 max=1 id="iactv" placeholder="Actv" /><br />	
		<input type="button" value="All" onclick="populateColumn('actv');" >					
	</th>
	<th class="hd" >
		<input class="center vc50" type="number" min=0 max=1 id="iclrd" placeholder="Clrd" /><br />	
		<input type="button" value="All" onclick="populateColumn('clrd');" >						
	</th>
	<th class="hd" >
		<input class="center vc50" type="number" min=0 max=1 id="iisprnt" placeholder="isprnt" /><br />	
		<input type="button" value="All" onclick="populateColumn('isprnt');" >						
	</th>

<!-- init: empl,ctp,prof,photo -->	
	<th class="hd" >Ctp<br />(U)</th>
	<th class="hd" >Empl<br />(P)</th>
	<th class="hd" >Prof<br />(P)</th>
	<th class="hd" >Photo<br />(P)</th>	
<!-- init -->	
	
	<th class="hd" >Action</th>
</tr>

<?php 
	$num_sum=0;
?>


<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>	
<td>
	<?php echo $employees[$i]['ucid']; ?>		
	<?php if($employees[$i]['ucid']!=$employees[$i]['pcid']){ echo "|".$employees[$i]['pcid']; } ?>				
</td>	
	
	<td class="u" id="<?php echo $employees[$i]['ctp']; ?>" ondblclick="alert(this.id);" ><?php echo $employees[$i]['code']; ?></td>
	<td><?php echo $employees[$i]['employee']; ?></td>
				
	<td>
		<select id="<?php echo $i; ?>" name='employees[<?php echo $i; ?>][title_id]' 
			class="title vc120" onchange="xgetPriv(this.value,this.id)"   >
		<?php foreach($titles AS $sel): ?>
			
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$employees[$i]['title_id'])? 'selected':null; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>		
		</select>	
	</td>	

	<td class="" >	
		<input name="employees[<?php echo $i; ?>][title_id]" id="tid<?php echo $i; ?>" class="vc30 tid right pdr05" type="text" 
				ondblclick="xname('dbo','titles',this.value);" value="<?php echo $employees[$i]['title_id']; ?>" readonly />
	</td>		
	
	<td class="" >	
		<input name="employees[<?php echo $i; ?>][role_id]" id="role<?php echo $i; ?>" class="vc30 role right pdr05" type="text" 
				ondblclick="xname('dbo','roles',this.value);" value="<?php echo $employees[$i]['role_id']; ?>"  readonly />
	</td>		
	
	<td class="" >	
		<input name="employees[<?php echo $i; ?>][privilege_id]" id="priv<?php echo $i; ?>" class="vc30 privilege right pdr05" 
			type="text" value="<?php echo $employees[$i]['privilege_id']; ?>"  readonly />
	</td>		
	
<!-- edit: contacts -->	
	<td class="hd" ><input class="center vc50 male"  name="employees[<?php echo $i; ?>][is_male]" type="number" min=0 max=1
		value="<?php echo $employees[$i]['is_male']; ?>" /></td>

	<td class="hd" ><input class="center vc50 actv"  name="employees[<?php echo $i; ?>][is_active]" type="number" min=0 max=1
		value="<?php echo $employees[$i]['is_active']; ?>" /></td>

	<td class="hd" ><input class="center vc50 clrd"  name="employees[<?php echo $i; ?>][is_cleared]" type="number" min=0 max=1
		value="<?php echo $employees[$i]['is_cleared']; ?>" /></td>

		
	
<!-- init: ,empl,ctp,prof,photo -->	
	<td class="hd" ><?php echo $employees[$i]['ctpucid']; ?></td>
	<td class="hd" ><?php echo $employees[$i]['emplecid']; ?></td>
	<td class="hd" ><?php echo $employees[$i]['profecid']; ?></td>
	<td class="hd" ><?php echo $employees[$i]['photoecid']; ?></td>
<!-- init -->	

	<td class="hd" >
		<a href='<?php echo URL."mis/employer/".$employees[$i]['ucid']; ?>' class="txt-blue underline" >View</a>
		| <a href='<?php echo URL."mis/editCode/".$employees[$i]['ucid']; ?>' class="txt-blue underline" >Acct</a>
		| <a href='<?php echo URL."mgt/pass/".$employees[$i]['ucid']; ?>' class="txt-blue underline" >Pass</a>
	</td>
	<input type="hidden" name="employees[<?php echo $i; ?>][ecid]"  value="<?php echo $employees[$i]['ecid']; ?>"  >

</tr>
<?php endfor; ?>
</table>

<?php if($_SESSION['srid']==RMIS): ?>
	<p>For mis/employing use only.</p>
	<p><input onclick="return confirm('Proceed?');" type="submit" name="submit" value="Save All"   /></p>
<?php endif; ?>
</form>



<div class="shd" >
<?php pr($_SESSION['q']); ?>
</div>


<!------------------------------------------------------------------------------------------------------------->


<script>
var gurl = 'http://<?php echo HOST.'/'.DOMAIN; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = 'mis';
var ctlr = 'mis';
var hdpass 	= '<?php echo HDPASS; ?>';


$(function(){
	hd();
	shd();
	$('#hdpdiv').hide();

})



function xgetPriv(tid,i){
	
	var vurl 	= gurl + '/ajax/xcontacts.php';	
	var task	= "xgetPriv";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&tid='+tid,				
		async: true,
		success: function(s) { 			
			$('#tid'+i).val(s.tid);
			$('#role'+i).val(s.roleid);
			$('#priv'+i).val(s.privid);
		}		  
    });				

	
}	/* fxn */



function redirectRole(axn,role_id){
	var rurl 	= gurl + '/'+ctlr+'/'+axn+'/'+role_id;		
	window.location = rurl;		
}


function populateTitle(){
	populateColumn('title');
	setTitle();

}	/* fxn */


function setTitle(){	
	$('.title').each(function(){
		xgetPriv(this.value,this.id);
	})

}	/* fxn */



</script>



<script type='text/javascript' src="<?php echo URL; ?>views/js/promotions.js"></script>












