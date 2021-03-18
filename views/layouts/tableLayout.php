<style>


/* minimalist */
.divTable{ display:table; }	
.divBody{ display:table-row-group; }
.divRow{ display:table-row; }
.divCell,.divHead{ display:table-cell; }
.divHeader{ display:table-header-group; }
.divFooter{ display:table-footer-group; }

/* custom */
.divTable{ display:table;width:60%; }
.divBody{ display:table-row-group; }
.divRow{ display:table-row; }
.divCell,divHead{ display:table-cell;padding:3px 10px;border:1px solid #999; }
.divHeader{ display:table-header-group;background-color:#ddd; }
.divFooter{ display:table-footer-group;background-color:#ddd;font-weight:bold;	 }



</style>



<div class="divTable" >
<div class="divBody" >

<div class="divRow" >
	<div class="divHead" >First name</div>
	<div class="divCell" ><input type="text" name="first_name" placeholder="First name"  ></div>	
	<div class="divCell" >Middle name</div>
	<div class="divCell" ><input type="text" name="middle_name" placeholder="Middle name"  ></div>	
	<div class="divCell" >Last name</div>
	<div class="divCell" ><input type="text" name="last_name" placeholder="Last name"  ></div>		
	<div class="divCell" >Birthdate</div>
	<div class="divCell" ><input type="text" name="birthdate" placeholder="Birthdate"  ></div>			
</div>	<!-- row -->



</div>	<!-- divBody -->
</div>	<!-- divTable -->