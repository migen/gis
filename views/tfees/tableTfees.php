<?php 

// pr($_SESSION['q']);

?>

<h5>
	Tuition Fees Table	
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	

<?php 
	$sy=DBYR;
	$d['sy']=$sy;$d['repage']="tfees/table";
	$this->shovel('sy_selector',$d); 
?>	
	
	
</h5>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."tfees/details/".$sel['id']."/$sy?num=1"; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>

<h4 class="brown" >
<ol>
<li>No comma for Amount, i.e. 1500.00</li>
<li>YYYY-MM-DD for Date, i.e. 2016-05-20</li>
</ol>


</h4>

<form method="POST" >

<table class="gis-table-bordered table-fx table-altrow"  >
<tr>
<th>#</th>
<th>L#</th>
<th>Level</th>
<th>Label</th>
<th class="vc60" >Num
	<br /><input class="vc50" id="inum" />
	<input type="button" value="All" onclick="populateColumn('num');" >						
</th>
<th class="vc60" >Tuition
	<br /><input class="vc80" id="ituition" />
	<input type="button" value="All" onclick="populateColumn('tuition');" >						
</th>

<th>Total</th>
<th class="vc60" >Resfee
	<br /><input class="vc80" id="iresfee" />
	<input type="button" value="All" onclick="populateColumn('resfee');" >						
</th>
<th>Resdue
	<br /><input class="vc80" id="iresdue" />
	<input type="button" value="All" onclick="populateColumn('resdue');" >						
</th>
<th>A1DP
	<br /><input class="vc80" id="iy1_dpfee" />
	<input type="button" value="All" onclick="populateColumn('y1_dpfee');" >						
</th>
<th>S2DP
	<br /><input class="vc80" id="is2_dpfee" />
	<input type="button" value="All" onclick="populateColumn('s2_dpfee');" >						
</th>
<th>M3DP
	<br /><input class="vc80" id="im3_dpfee" />
	<input type="button" value="All" onclick="populateColumn('m3_dpfee');" >						
</th>
<th>Q4DP
	<br /><input class="vc80" id="iq4_dpfee" />
	<input type="button" value="All" onclick="populateColumn('q4_dpfee');" >						
</th>

<th>A1DP Due
	<br /><input class="vc80" id="iy1_dpdue" />
	<input type="button" value="All" onclick="populateColumn('y1_dpdue');" >						
</th>
<th>S2DP Due
	<br /><input class="vc80" id="is2_dpdue" />
	<input type="button" value="All" onclick="populateColumn('s2_dpdue');" >						
</th>
<th>M3DP Due
	<br /><input class="vc80" id="im3_dpdue" />
	<input type="button" value="All" onclick="populateColumn('m3_dpdue');" >						
</th>
<th>Q4DP Due
	<br /><input class="vc80" id="iq4_dpdue" />
	<input type="button" value="All" onclick="populateColumn('q4_dpdue');" >						
</th>

</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><input class="vc50" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['tid']; ?>" readonly /></td>
	<td><?php echo $rows[$i]['lvlid']; ?></td>
	<td>
		<select name="posts[<?php echo $i; ?>][level_id]" >
			<?php foreach($levels AS $sel): ?>	
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$rows[$i]['lvlid'])? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td><input class="vc100" name="posts[<?php echo $i; ?>][label]" tabindex="10"
		value="<?php echo $rows[$i]['label']; ?>" /></td>
	
	<td><input class="num vc50" name="posts[<?php echo $i; ?>][num]" tabindex="20"
		value="<?php echo $rows[$i]['num']; ?>" /></td>

	<td><input class="tuition vc80 right" name="posts[<?php echo $i; ?>][tuition]" tabindex="30"
		value="<?php echo $rows[$i]['tuition']; ?>" /></td>					
		
	<td><input class="vc80 right" name="posts[<?php echo $i; ?>][total]" tabindex="40"
		value="<?php echo $rows[$i]['total']; ?>" /></td>					
		
	<td><input class="resfee vc80 right" name="posts[<?php echo $i; ?>][resfee]" tabindex="50"
		value="<?php echo $rows[$i]['resfee']; ?>" /></td>					

	<td><input class="resdue vc80 right" name="posts[<?php echo $i; ?>][resdue]" tabindex="50"
		value="<?php echo $rows[$i]['resdue']; ?>" /></td>					

	<td><input class="y1_dpfee vc80 right" name="posts[<?php echo $i; ?>][y1_dpfee]" tabindex="60"
		value="<?php echo $rows[$i]['y1_dpfee']; ?>" /></td>					
		
	<td><input class="s2_dpfee vc80 right" name="posts[<?php echo $i; ?>][s2_dpfee]" tabindex="70"
		value="<?php echo $rows[$i]['s2_dpfee']; ?>" /></td>					

	<td><input class="m3_dpfee vc80 right" name="posts[<?php echo $i; ?>][m3_dpfee]" tabindex="80"
		value="<?php echo $rows[$i]['m3_dpfee']; ?>" /></td>					

	<td><input class="q4_dpfee vc80 right" name="posts[<?php echo $i; ?>][q4_dpfee]" tabindex="90"
		value="<?php echo $rows[$i]['q4_dpfee']; ?>" /></td>					

	<td><input class="y1_dpdue vc80 right" name="posts[<?php echo $i; ?>][y1_dpdue]" tabindex="100"
		value="<?php echo $rows[$i]['y1_dpdue']; ?>" /></td>					
		
	<td><input class="s2_dpdue vc80 right" name="posts[<?php echo $i; ?>][s2_dpdue]" tabindex="110"
		value="<?php echo $rows[$i]['s2_dpdue']; ?>" /></td>					

	<td><input class="m3_dpdue vc80 right" name="posts[<?php echo $i; ?>][m3_dpdue]" tabindex="120"
		value="<?php echo $rows[$i]['m3_dpdue']; ?>" /></td>					

	<td><input class="q4_dpdue vc80 right" name="posts[<?php echo $i; ?>][q4_dpdue]" tabindex="130"
		value="<?php echo $rows[$i]['q4_dpdue']; ?>" /></td>					
		
</tr>
<?php endfor; ?>

</table>

<p>
	<input type="submit" name="update" value="Update" onclick="return confirm('Sure?');" />
</p>

</form>
