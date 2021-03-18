<?php 

	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbbooks="{$dbg}.05_books";

	// pr($_SESSION['q']);

?>

<h3>

	Booklists Manager (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	<?php include('linksBooklists.php'); ?>
	| <span class="u txt-blue" onclick="pclass('shd')" >Add</span>	

</h3>



<p class="" style="display:flex" >
<table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>Books</th>
		<td>
			<form method="GET" >
				<input class="pdl05" id="part" name="book" autofocus placeholder="code / name" />
				<input type="submit" name="submit" value="Search" >
				<input type="submit" name="auto" value="Filter" onclick='getDataByTable(dbbooks,30);return false;' />			
			</form>		
		</td>
		<td class="shd" >
			<form method="POST" >
				<input class="pdl05" name="book" autofocus placeholder="name"  />
				<input type="submit" name="submit" value="Add" >			
			</form>		
		</td>	
	</tr>
</table>


</p>

<div id="names" >names</div>


<?php if($count>0): ?>
	<table class="gis-table-bordered" >
		<tr>
			<th>Book ID</th>
			<th>Level</th>
			<th>Num</th>
			<th>Subject</th>
			<th>Book</th>
			<th>Sem</th>
			<th></th>
		</tr>
	<?php foreach($rows AS $i=>$row): ?>	
		<tr>
			<td><?php echo $row['book_id']; ?></td>
			<td><?php echo $row['level']; ?></td>
			<td><?php echo $row['num']; ?></td>
			<td><?php echo $row['subject']; ?></td>
			<td><?php echo $row['book']; ?></td>
			<td><?php echo $row['semester']; ?></td>
			<td>
				<a href="<?php echo URL.'booklists/edit/'.$row['book_id']; ?>" >Edit</a>
				| <a onclick="return confirm('Sure?');" href="<?php echo URL.'booklists/deleteLevelBook/'.$row['level_book_id']; ?>" >Delete</a>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>

<?php endif; ?>	<!-- buk -->


<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbbooks = "<?php echo $dbbooks; ?>";
var limit=20;
			
$(function(){
	shd();
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=gurl+"/booklists/manager/"+id;
	// alert(url);
	window.location=url;
}






</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

