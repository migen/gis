

<style>


.bg-pink { background-color:pink; } 
.bg-blue { background-color:#7995e8; } 
.bg-brown { background-color:brown; } 
.bg-red { background-color:red; } 
.name{ width:280px; }
.wrapper{ width:580px; }
.box{ width:100px; height:100px; border: 1px solid black; float:left; margin:6px; padding:6px; border-radius:6px;  }
.boxtype{ width:100px; height:40px; border: 1px solid black; float:left; margin:6px; padding:6px; border-radius:6px;  }

.prodtypes{ height:50px; }
.prodtypes,.cartdiv{ float:left; }
#total{ font-size:1.2em; }

.leftdiv { width: 40%; float:left;}
.rightdiv { width: 50%; float:left;}


</style>

<?php 

pr($_SESSION['q1']);
?>

<div class="leftdiv" >

<h5>
	<span class="brown" style="size:1.2em;" >(我 &hearts; 你， 陳嘉仪)</span>
	<span class="blue" >APPA | 168</span> <span class="red" >Store POS</span> Product Types 
	| <a href="<?php echo URL.'stores'; ?>" >POS</a>
		
</h5>


<?php


?>


<!-- Scroll bar present and enabled when more contents -->        
<div style="width:600px;height:160px;overflow-y:scroll;float:left;">
<div class="boxtype" ><span onclick="showMerchandise(0,'blue');" >All</span></div>
<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['id']; $color=$rows[$i]['color']; ?>
	<div class="boxtype bg-<?php echo $color; ?>" ><span onclick="showMerchandise(<?php echo $id; ?>,'<?php echo $color; ?>');" >
	<?php echo "#".$id."&nbsp;"; echo $rows[$i]['name']; ?></span></div>
<?php endfor; ?>

</div>	<!-- types -->


<div class="wrapper" >
	<table style="display:block;">
		<div id="display"></div>
	</table>
</div>


</div>	<!-- left -->

<div class="rightdiv" >
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
		
		<tr><th colspan=2>Total</th><th colspan=3><input id="total" class="b full right" name="pos[total]" value=0 ></th></tr>
		<tr><th colspan=5 ><input style="font-size:1.6em;" type="submit" name="submit" value="Checkout" ></th></tr>				
	</table>
</div>
</form>
</div>	<!-- right -->



<script>

var gurl = "http://<?php echo GURL; ?>";
var row=0;


$(function(){
	
})


function showMerchandise(id,color){
	var url = gurl+'/ajax/xappa.php';	
	var task = "xgetMerchandise";
	$.ajax({
		url: url,
		type: "POST",
		data: 'task='+task+'&id='+id,		
		sucess: function(data){
			var content="abcdef";
			$('#display').html(content);
			// console.log(data);
		}
	});
		
}	/* fxn */


function showMerchandiseXXX(id,color){
	var vurl = gurl+'/ajax/xmerchandise.php';	
	var task = "xgetMerchandise";
	$.ajax({
		url: vurl,dataType:"json",type:"POST",async:true,
		data: 'task='+task+'&id='+id,
		success: function(s) {  
			var cs=s.length;
			content="<h5>Products</h5>";			
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content+='<p><span id="'+s[i].id+'" class="box bg-'+s[i].color+'" onclick="addToCart(this.id);return false;" >'+'#'+s[i].id+' '+s[i].name+'<br />'+s[i].price+'</span></p>';
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
	// $('#total').val(total.toFixed(2));		
	$('#total').val(total.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));	

}	/* fxn */




</script>

