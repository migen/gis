<style>

.name{ width:280px; }
.wrapper{ width:580px; }
.box{ width:100px; height:100px; border: 1px solid black; float:left; margin:6px; padding:6px; border-radius:6px;  }

.prodtypes{ height:50px; }
.prodtypes,.cartdiv{ float:left; }
.cartdiv{ padding-left:200px; }
#total{ font-size:1.2em; }


</style>

<?php 

// pr($_SESSION['q']);
?>


<h5>
	List of Product Types 
	
	
</h5>


<?php



// pr($data);

?>


<div class="prodtypes" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th class="name" >Name</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['id']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><span onclick="showMerchandise(<?php echo $id; ?>);" ><?php echo $rows[$i]['name']; ?></span></td>
	<td><a href="<?php echo URL.'merchandise/items/'.$id; ?>" >Items</a></td>
</tr>
<?php endfor; ?>
</table>

</div>




<form method=POST >
<div class="cartdiv" >
	<h5>Cart</h5>
	<table class="gis-table-bordered" >
		<tbody class="cart" >		
		<tr>
			<th>&nbsp;&nbsp;</th>
			<th class="vc200" >Item</th>
			<th class="center vc50" >Qty</th>
			<th class="center" >Unit<br />Price</th>
			<th class="center" >Subtotal</th>
		</tr>
		</tbody>
		<tr><th colspan=5 ><input type="submit" name="submit" value="Submit" >
			<button onclick="refresh();return false;" >Refresh</button></th></tr>		
		<tr><th colspan=2>Total</th><th colspan=3><input id="total" class="b full right" name="pos[total]" value=0 ></th></tr>
		
	</table>
</div>
</form>



<p class="clear" >&nbsp;</p>
<br />
<div class="wrapper clear" ></div>	<!-- wrapper -->




<script>

var gurl = "http://<?php echo GURL; ?>";
var row=0;



$(function(){
	// $('html').live('click',function(){ $('.wrapper').hide(); });	
	// appendBoxes();
	// alert(111);

})





function showMerchandise(id){
	var vurl = gurl+'/ajax/xmerchandise.php';	
	var task = "xgetMerchandise";
	$.ajax({
		url: vurl,dataType:"json",type:"POST",async:true,
		data: 'task='+task+'&id='+id,
		success: function(s) {  
			var cs=s.length;
			content="";			
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content+='<p><span id="'+s[i].id+'" class="box" onclick="addToCart(this.id);return false;" >'+'#'+s[i].id+' '+s[i].name+'<br />'+s[i].price+'</span></p>';
}
			$(".wrapper").html(content).show();content="";

		}		 
    });				

	
}	/* fxn */



function addToCart(id){
	var vurl = gurl+'/ajax/xmerchandise.php';	
	var task = "xgetProductById";
	$.ajax({
		url: vurl,dataType:"json",type:"POST",async:true,
		data: 'task='+task+'&id='+id,
		success: function(s) {  
			var cart=$('.cart');
			var content="";
			content+="<tr><td>"+(row+1)+"</td><td class='vc200' >#"+s.id+" "+s.name+"</td>";
			content+="<input name='positems["+row+"][product_id]' type='hidden' value="+s.id+" >";
			content+="<td><input name='positems["+row+"][qty]' onchange='doSubtotal("+row+");return false;' class='center vc50' type='number' value=1 ></td>";
			content+="<td><input name='positems["+row+"][price]' class='center vc100' value="+s.price+" ></td>";
			content+="<td><input name='positems["+row+"][subtotal]' class='subtotal center vc100' value="+s.price+" ></td>";			
			content+="</tr>";
			cart.append(content);
			row++;			
			refresh();					
		}
    });				
	
}


function doSubtotal(row){	/* amount or item subtotal */
	billTotal(row);

}

function billTotal(i){		/* bill total */
	var ip = $('input[name="positems['+i+'][price]"]').val();
	var iq = $('input[name="positems['+i+'][qty]"]').val();	
	if(iq>999){ alert('Qty too big!'); }
		
	if(iq !== ''){
		var x = ip * iq;
		$('input[name="positems['+i+'][subtotal]"]').val(x.toFixed(2));		
	} 
	refresh();
	
}


function refresh(){		/* bill total */
	var total = 0;	
	$.each($('.subtotal'),function(){ total+=parseFloat($(this).val()); });
	$('#total').val(total.toFixed(2));	

}	/* fxn */






function deferred(){ $.when(  alert(111) ).done(function() { alert(222) }); }


</script>

