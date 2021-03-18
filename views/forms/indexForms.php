<style>

.form th,.form td { font-size:1.2em; padding:10px 10px;vertical-align:middle; }
.form input { font-size:1.1em; }
.form input submit { color:red; }

</style>



<h5>

	Forms | <?php $this->shovel('homelinks'); ?>



</h5>


<form method="POST" >
<table class="form gis-table-bordered table-altrow" >
	<tr><th>#</th><th class="vc200" >Name</th></tr>
	<tr><td>1</td><td>Anna</td></tr>
	<tr><td>2</td><td>Bella</td></tr>
	<tr><td>3</td><td>Cocoa</td></tr>
</table>


<br />

<table class="form gis-table-bordered table-altrow" >
	<tr><th>Name</th><td>Anna Buted</td></tr>
	<tr><th>Father</th><td><input name="post[father]" value="anna father" ></td></tr>
	<tr><th>Mother</th><td><input name="post[father]" value="anna mother" ></td></tr>
	<tr><td colspan=2><input type="submit" name="submit" value="Submit" ></td></tr>
</table>


</form>