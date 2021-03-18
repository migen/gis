<script>

var gurl = "http://<?php echo GURL; ?>";
var home = "<?php echo 'pools'; ?>";
var crid = "<?php echo $crid; ?>";


$(function(){
	itago('clipboard');
	

})






</script>



<h5>
	Roster Students (by Keys)
	
	
</h5>


<div class="clear" >
<table class='gis-table-bordered table-fx'>
<?php 
	$d['classrooms']=$classrooms;$d['sy']=$sy;$d['axn']='students';	
	$this->shovel('redirect_classroom',$d); 
?>
	
</table>
</div>

<!------------->

<div class="addrows" style="width:600px;float:left;"  >

<?php if($crid): ?>
<form method="POST" >	<!-- form add -->
<h5> 
	Add Students
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
</h5>
<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th class="vc200" >Scid</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="scid<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>]" /></td>		
		
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="submit" value="Submit" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

<p><?php $this->shovel('numrows'); ?></p>

</form> <!-- add -->

<?php else: ?>
<h5>Please choose a classroom.</h5>
<?php endif; ?>

</div>







<!------------->


<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="scid" >Scid</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<div class="clear ht100" >&nbsp;</div>

