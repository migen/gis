<div class="accordParent" >	
<button onclick="accorToggle('scripts')" style="width:262px;" class="bg-blue2" > <p class="b f16" >Scripts</p> </button>  	
<table id="scripts" class="gis-table-bordered table-fx" >

<tr><td class="vc250" > <a href="<?php echo URL.'scripts/proma'; ?>" >Promote All</a></td></tr>
<tr><td class="vc250" > <a href="<?php echo URL.'scripts/avetraits/'.$_SESSION['qtr']; ?>" >Ave Traits</a></td></tr>
<tr><td class="vc250" > <a href="<?php echo URL.'scripts/totalAttdM/'.DBYR; ?>" >Total Attendance (M)</a></td></tr>
<tr><td class="vc250" > <a href="<?php echo URL.'scripts/totalAttdQ/'.DBYR; ?>" >Total Attendance (Q)</a></td></tr>
<tr><td class="vc250" > <a href="<?php echo URL.'scripts/attdqtr5'; ?>" >Attendance Qtr5</a></td></tr>
<tr><td class="vc250" > <a href="<?php echo URL.'scripts/grsum'; ?>" >Gr Sum sjalp</a></td></tr>

<tr><td>&nbsp;</td></tr>
</table>
</div>