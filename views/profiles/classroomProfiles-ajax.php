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
	<?php if(isset($_GET['print'])): ?>
		| <a href='<?php echo URL."profiles/classroom/$crid"; ?>'>Edit</a>				
		| <a class="u" id="btnExport" >Excel</a> 	
	<?php else:	?>
		| <a href='<?php echo URL."profiles/classroom/$crid?print"; ?>'>Print</a>			
	<?php endif; ?>
	
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

<table id="tblExport" class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th>#</th>
	<th>PCID</th>
	<th>ID No.</th>
	<?php if(!isset($_GET['print'])): ?>	
		<?php if($_SESSION['settings']['editable_code']==1): ?>
			<th>New ID</th>
		<?php endif; ?>
	<?php endif; ?>
	<th class="" >Full Name (SURNAME,FIRST MI) </th>
	<th>LRN</th>	
	<?php if(!isset($_GET['print'])): ?>	
		<th class="vc70" >Birthdate <br /><span style="font-weight:normal;font-size:0.8em;" >YYYY-MM-DD</span></th>
	<?php else: ?>
		<th>Birthdate</th>
	<?php endif; ?>
	<?php if(!isset($_GET['print'])): ?>
		<th>Save</th>		
	<?php endif; ?>	
	<th class="vc150" >Address</th>
	<?php if(!isset($_GET['print'])): ?>	
		<th class="vc50" >
			<select id="imale" class='vc70'>	
				<option value="1" > Male </option>
				<option value="0" > Female </option>
			</select>					
			<br />	
			<input type="button" value="All" onclick="populateColumn('male');" >						
		</th>
	<?php else: ?>
		<th>Sex</th>
	<?php endif; ?>

	
	<?php if(!isset($_GET['print'])): ?>		
		<th>POS<br />
			<input class="pdl05 vc50" id="ipos" /><br />	
			<input type="button" value="All" onclick="populateColumn('pos');" >							
		</th>
	<?php endif; ?>		

</tr>

<?php if(isset($_GET['print'])): ?>
	<?php $incs="incs/profiles_print.php"; include_once($incs); ?>
<?php else: ?>
	<?php $incs="incs/profiles_form.php"; include_once($incs); ?>
<?php endif;  ?>



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




function xeditRow(i,cid){
	$('#csb'+i).hide();		
	var posi = $('#posi'+i).val();
	var lrn 		= $('#lrn'+i).val();
	var code 		= $('#code'+i).val();
	var fullname 	= $('#fullname'+i).val();
	var cname 		= $('#cname'+i).val();
	var birthdate	= $('#birthdate'+i).val();
	var address		= $('#address'+i).val();
	var is_male		= $('#is_male'+i).val();
		
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xeditData";
	var pdata="task="+task+"&dbtable="+dbtable+"&id="+pkid+"&is_displayed="+disp+"&position="+pos+"&amount="+amount+"&indent="+indent;
	pdata+="&amount_hidden="+amthidden+"&in_total="+intotal;
	
	$.ajax({type: 'POST',url: vurl,data: pdata,success:function(){  }  });					
}	/* fxn */




</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/promotions.js"></script>
