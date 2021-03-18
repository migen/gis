<h5>
	Student Registration
	<a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/students/'; ?>">Batch</a> 	

	<?php if(isset($_SESSION['last_registered'])): ?>
		<?php $lastreg=$_SESSION['last_registered']; ?>		
		| <a href="<?php echo URL.'profiles/student/'.$lastreg['scid'].DS.$lastreg['sy']; ?>" >Profile</a>
		| <a href="<?php echo URL.'assessment/assess/'.$lastreg['scid'].DS.$lastreg['sy']; ?>" >Assessment</a>
	<?php endif; ?>

	
</h5>

<h4 class="brown" >*Validate before registering. Strictly avoid DUPLICATE errors. *Regyr is <?php echo $regyr; ?></h4>

<h2>*New Student for SY <?php echo $regyr; ?></h2>

<?php 

if(!$dbexists){ echo "<h2 class='brown'>".$regyr." database has not been created. <br />
Please contact GIS Service Provider.</h2>"; exit; }


// require_once(SITE.'/views/registration/incs/filter_codename.php');
$this->shovel('filter_codename');



?>


<?php 
$code=isset($code)? $code:NULL;
?>

<div class="fifty" >
<form method="POST" >
<table class="gis-table-bordered table-fx" >

<tr><th>ID No.</th><td><input class="pdl05" name="post[code]" value="<?php echo $code; ?>"  />
<span class='b' >Male</span> <input class="vc30 pdl05" name="post[is_male]" value="1" type="number" min=0 max=1 />
</td></tr>
<tr><th>Full name</th><td><input name="post[fullname]" placeholder="Surname, Firstname Middle" 
class="pdl05 vc200"  /></td></tr>
<tr><td colspan="2" ><input type="submit" name="submit" value="Register" /></td></tr>
</table>
</form>
</div>




<div id="names" > </div>


<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy 	 = '<?php echo $_SESSION['sy']; ?>';
var limits='20';

$(function(){
	$('html').live('click',function(){
		$('#names').hide();
	});

})

function redirContact(ucid){
	var url = gurl + '/students/sectioner/' + ucid;	
	window.location = url;		
}


function getLvl(){	
	var crid=$('select[name="post[crid]"]').val();
	var vurl 	= gurl + '/ajax/xclassrooms.php';	
	var task	= "xgetLvl";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'crid='+crid+'&task='+task,				
		success: function(s) { $('#lvl').val(s.lvl); }		  
    });				
	
}	/* fxn */


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
