<h5>Locking</h5>

<?php 

// pr($departments);
// pr($subjects);


// echo "Today: ".$_SESSION['today']."<br />";
// echo "Date lockdown: ".."<br />";

?>





<table class="gis-table-bordered table-fx" >
<tr><th>Today</th><td><?php echo $_SESSION['today']; ?></td></tr>
<tr><th>Q<?php echo $qtr; ?> Lockdown</th><td><?php echo $_SESSION['settings']['date_lockdown_q'.$qtr]; ?></td></tr>
<tr><th>Q<?php echo $qtr; ?> Locking</th><td>
	<a href="<?php echo URL.'acad/lockAll?qtr='.$qtr; ?>" onclick="return confirm('Sure?');" >Lock All</a>
	| <a href="<?php echo URL.'acad/unlockAll?qtr='.$qtr; ?>" onclick="return confirm('Sure?');" >UnLock All</a>
</td></tr>






</table>