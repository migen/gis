<?php $srid=$_SESSION['srid'];$min=isset($_GET['min'])? $_GET['min']:70;$max=isset($_GET['max'])? $_GET['max']:100; ?>

<h4 class="<?php echo ($srid!=RMIS)? 'shd':NULL; ?>" >
<table class="gis-table-bordered" >
<tr>
<td>Min<input id="min" class="vc50" value="<?php echo (isset($_GET['min']))? $_GET['min']:$min; ?>" ></td>
<td>Max<input id="max" class="vc50" value="<?php echo (isset($_GET['max']))? $_GET['max']:100; ?>" ></td>
<td><span class="u" onclick="randomize('aim');" >Randomize</span></td>
<td><span class="u" onclick="gotoUrl();" >RandomizeUrl</span></td>
</tr>
</table>
</h4>
