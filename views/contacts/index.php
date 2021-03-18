<?php



?>

<!------------------------------------------------------------------------>

<h5>
	<span ondblclick="tracepass();" class="u"  >Contacts</span> | 
	<a href="<?php echo URL.$home; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					

	| <a href="<?php echo URL.'contacts'; ?>" >Index</a> 
	| <a href="<?php echo URL.'mis/contact'; ?>" >Register</a> 
</h5>

<div class="hd" ><?php pr($_SESSION['q']); ?></div>

<p><?php $this->shovel('hdpdiv'); ?></p>


<div class="third" >
<table class="gis-table-bordered table-fx f12">
<tr class="headrow">
	<td>#</td>
	<td>Legend</td>
</tr>

<tr>
	<td>1</td>
	<td>M - Male (1 (Male),- (Female))</td>
</tr>

<tr>
	<td>2</td>
	<td>S - Status (1-(Active),-(Not Active))</td>
</tr>
</table>
</div>

<div class="half">
	<input class="pdl10" id="code"  />
	<button onclick="xverifyCode($('#code').val());" > Check ID</button>
</div>
<!------------------------------------------------------------------------>

<div class="clear"> </div>

<p>
<form method='GET' >

<table class="gis-table-bordered" >
<tr class="headrow" >
<th>Sort</th><th>Order</th><th># Rows</th><th>Page</th><th>Initial</th><th>Role</th><th>Prnt</th><th>Username</th><th>Name</th><th>&nbsp;</th></tr>
<tr>
	<td>
		<select name="sort" >
			<option value="c.name">Name</option>
			<option value="c.code">Code</option>
			<option value="c.is_male">Gender</option>
			<option value="r.name">Role</option>
			<option value="c.parent_id">PCID</option>
		</select>
	</td>	
	<td>
		<select name="order" >
			<option value="ASC" >Asc</option>
			<option value="DESC" <?php $order = (isset($_SESSION['get']['order']) && ($_SESSION['get']['order']=='DESC'))? true:false; echo ($order)? 'selected': null; ?> >Desc</option>
		</select>
	</td>		
	<td><input class="pdl05 vc50" type='number' name='numrows' value="<?php echo (isset($_SESSION['get']['numrows']))? $_SESSION['get']['numrows']:'50'; ?>" /></td>		
	<td><input id="cpage" class="vc50 pdl05" type="number" name="page" value="1" /></td>	
	<td>
		<select name="first_letter" >
			<option value="">-</option>
			<option value="a">a</option><option value="b">b</option><option value="c">c</option><option value="d">d</option><option value="e">e</option><option value="f">f</option><option value="g">g</option><option value="h">h</option><option value="i">i</option><option value="i">j</option><option value="k">k</option><option value="l">l</option><option value="m">m</option><option value="n">n</option><option value="o">o</option><option value="p">p</option><option value="q">q</option><option value="r">r</option><option value="s">s</option><option value="t">t</option><option value="u">u</option><option value="v">v</option><option value="w">w</option><option value="x">x</option><option value="y">y</option><option value="z">z</option>
		</select>
	</td>	
	<td>
		<select name="role" >
			<option value="0" >All</option>
			<?php foreach($roles AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  > <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>
	</td>		
	<td>
		<select name="parent" >
			<option value=2 >All</option>
			<option value=0>0</option>
			<option value=1>1</option>
		</select>
	</td>
	<td><input class="pdl05 vc100" type='text' name='code' placeholder="ID Number" /></td>	
	<td><input class="pdl05 vc150" type='text' name='contact' placeholder="name" autofocus /></td>	
	<td><input type='submit' name='submit' value='Filter'></td>		
</tr>
</table>
</form>
</p>

<?php 
	// for sorting
	$get = isset($_GET)? sages($_GET):'';	 
		
?>


<!------------------------------------------------------------------------>


<!------------------------------------------------------------------------>


<!----------------- hidden ------------------------------------------------------->

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th class="vc20" >&nbsp;</th>
	<th class="vc20" >#</th>
	<th class="vc30" >PCID</th>
	<th class="vc30" >UCID</th>
	<th class="vc80" >Code-IMG</th>
	<th><a href="<?php echo URL.'mgt/contacts/'.$get; ?>sort=c.name">Manage Account</a></th>	
	<th class="vc100" >Login</th>
	<th class="hd vc100" >Pass</th>
	<th class="vc50" >Role</th>
	<th class="center" ><a href="<?php echo URL.'mgt/contacts/'.$get; ?>sort=c.is_male">M</a></th>		<!-- gender -->
	<th class="center" ><a href="<?php echo URL.'mgt/contacts/'.$get; ?>sort=c.is_active">S</a></th>	<!-- active -->	
	<th class="vc80" >Manage</th>
	<th class="hd vc20" >UCID</th>
</tr>

<?php for($i=0;$i<$num_contacts;$i++): ?>

<tr>
	<td><input type="checkbox" name="rows[<?php echo $contacts[$i]['id'];?>]" value="<?php echo $contacts[$i]['id']; ?>" /></td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $contacts[$i]['pcid'];  ?></td>
	<td><?php echo $contacts[$i]['ucid'];  ?></td>
	<td><a href="<?php echo URL.'photos/one/'.$contacts[$i]['parent_id'];  ?>" > <?php echo $contacts[$i]['code']; ?></a></td>
	<td class="vc200" >
		<?php if($contacts[$i]['role_id'] != 1): ?>	
			<a href="<?php echo URL.'mgt/users/'.$contacts[$i]['parent_id'];  ?>" > <?php echo $contacts[$i]['name']; ?></a>
		<?php else: ?> 		
			<?php echo $contacts[$i]['name']; ?>
		<?php endif; ?>		
	
	
	</td>
	<td> <?php echo $contacts[$i]['account']; ?> </td>
	<td class="hd" > <?php echo $contacts[$i]['ctp']; ?> </td>
	
	<td class="vc100 <?php echo ($contacts[$i]['is_active']=='1')? NULL:'red'; ?> " ><?php echo $contacts[$i]['title']; ?></td>
	<td class="vc25 center" ><?php echo ($contacts[$i]['is_male'])? '1':'-'; ?></td>
	<td class="vc25 center" id="stat<?php echo $i; ?>" ><?php echo ($contacts[$i]['is_active'])? '1':'-'; ?></td>
	<td class="vc300" >
		<button class="vc50" ><a class="no-underline" href="<?php echo URL.'mis/statuses/'.$contacts[$i]['id']; ?>" >Status</a></button>
		<button class="vc50" ><a class="no-underline" href="<?php echo URL.'mgt/pass/'.$contacts[$i]['id']; ?>" >Pass</a></button>
		<button class="vc50" ><a class="no-underline" href="<?php echo URL.'contacts/ucis/'.$contacts[$i]['parent_id']; ?>" >Edit</a></button>
		<button class="vc50" ><a onclick="return confirm('Dangerous!');" class="no-underline" 
			href="<?php echo URL.'mis/purge/'.$contacts[$i]['id']; ?>" >DEL</a></button>		
	</td>
	<td class="hd" ><?php echo $contacts[$i]['id']; ?></td>
	
		
</tr>

<?php endfor; ?>			

</table>

<p>
	<input type='submit' name='batch' value='Batch' >
	<?php $this->shovel('boxes'); ?>
</p>

</form> <!-- for batch -->



<!------------------------------------------------------------------------>

<p>

	<!-- pagination -->
	<?php  if(isset($num_pages) && $num_pages){ echo $data['pages']; } ?>
</p>

<!------------------------------------------------------------------------>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	hd();
	// tracehd();
	$('#hdpdiv').hide();
	
	nextViaEnter();

})

function populateClassrooms(){

	populateColumn('cr');
	setClassrooms();
	

}	/* fxn */


function setClassrooms(){	
	$('.cr').each(function(){
		getLevel(this.value,this.id);
	})
}	/* fxn */


function xverifyCode(code){		/* contacts.code */	
	var vurl 	= gurl + '/ajax/xcontacts.php';	
	var task	= "xverifyCode";
		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&code='+code,						
		success: function(s) { 			
			if(s.name){ alert(s.id+':'+s.name); 
			} else { alert('Available'); } 			
		}		  
    });				
	
}	/* fxn */


function getLevel(crid,i){	
	var vurl 	= gurl + '/ajax/xclassrooms.php';	
	var task	= "xgetLvl";
		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'crid='+crid+'&task='+task,				
		success: function(s) { 			
			$('#lvlid'+i).val(s.lvl);
			$('#deptid'+i).val(s.dept);
		}		  
    });				
	
}	/* fxn */


function gotoContacts(){	
	var numrows  = $('#numrows').val();	
	var initials = $('#initials').val();	
	var rurl 	= gurl + '/contacts/index/'+numrows+'/'+initials;
	window.location = rurl;	
}	/* fxn */






</script>
