<?php 

// pr($data);

// pr($_SESSION['q']);
$srid=$_SESSION['srid'];

$limit=isset($_GET['limit'])? $_GET['limit']:30;


?>


<h5>
	Password Reset | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'passwords/reset'; ?>">Filter</a>
	<?php if($srid==RMIS): ?>
		| <a href="<?php echo URL.'codename/one/'.$row['ucid']; ?>">Code</a>
		| <a href="<?php echo URL.'clearance/one/'.$row['ucid']; ?>">Status</a>
	<?php endif; ?>
	
	
</h5>

<?php if($has_subject): ?>
	<table class="gis-table-bordered" >
		<?php 
			// $ucid=$row['ucid'];
			// $code=$row['code'];
			// $ctp=$row['ctp'];
			// $name=$row['name'];
			// $birthdate=$row['birthdate'];
			extract($row);
			debug($row);
			$pass=($subject_is_student)? $birthdate:'pass';		
		?>
		<tr>
			<td><?php echo $ucid; ?></td>
			<td><?php echo $code; ?></td>
			<td><?php echo $name; ?></td>	
			<td>bdate: <?php echo $birthdate; ?></td>
			<td>login: <?php echo $account.'-'.$ctp; ?></td>
			<?php if((isset($_GET['show'])) && ($srid==RMIS)): ?>
				<td><?php echo $row['ctp']; ?></td>
			<?php endif; ?>
			<form method="POST" >				
				<td>
					<input type="hidden" name="subject_name" value="<?php echo $name; ?>" >
					<input type="hidden" name="ucid" value="<?php echo $ucid; ?>" >
					<input name="pass" value="<?php echo $pass; ?>" >					
					<input type="submit" name="submit" value="Reset" ></td>
			</form>
			
		</tr>
		
	</table>
<?php endif; ?>

<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>



<div class="clear ht50" ></div>





<script>
var gurl = "http://<?php echo GURL; ?>";
var limits="<?php echo $limit; ?>";
// var lady=charmee();


$(function(){
	// alert(limits);
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/passwords/resets/'+ucid;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
