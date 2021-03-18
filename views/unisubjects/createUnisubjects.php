<h5>
	Add College Subjects | <?php $this->shovel('homelinks'); ?>
	| <a class="u" onclick="ilabas('addrows')" >Add</a>		
	| <a class="u" onclick="pclass('smartboard');" >Smartboard</a>
	
	
</h5>

<?php 

// pr($rows[0]);

?>

<div class="" style="float:left;width:35%;" >
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Code</th>
	<th>Subject</th>
</tr>

<?php $numrows=isset($_POST['numrows'])? $_POST['numrows']:1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input id="code<?php echo $i; ?>" tabIndex="2" class="vc100 pdl05 " name="posts[<?php echo $i; ?>][code]"  ></td>
	<td><input id="name<?php echo $i; ?>" tabIndex="4" class="vc200 pdl05 " name="posts[<?php echo $i; ?>][name]"  ></td>
</tr>
<?php endfor; ?>
</table>
<p><input type="submit" name="submit" value="Add" ></p>

</form>

<?php $this->shovel('numrows'); ?>

</div>	<!-- half -->

<div class="smartboard " style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="code" >Code</option>
	<option value="name" >Name</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>


<div class="third" >


<ol>
<h4 class="b" >Subjects</h4>
<?php foreach($rows AS $row): ?>
<li><?php echo $row['code'].' - '.$row['name'].' #'.$row['id']; ?></li>
<?php endforeach; ?>
</ol>
</div>


<script>
var gurl="http://<?php echo GURL; ?>";
var sy="<?php echo DBYR; ?>";

$(function(){
	nextViaEnter();
	itago('addrows');
	itago('smartboard');
	
	
});






</script>
