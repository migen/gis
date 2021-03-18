<style>

.name{ width:280px; }
.wrapper{ width:580px; }
.box{ width:100px; height:100px; border: 1px solid black; float:left; }

.prodtypes,.cart{ float:left; }
.cart{ padding-left:100px; }


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



<div class="cart" >
	<h5>Cart</h5>
	<table class="cartTable gis-table-bordered" >
		<tr>
			<th>&nbsp;&nbsp;</th>
			<th class="vc200" >Item</th>
			<th class="center vc50" >Qty</th>
			<th>Price</th>
		</tr>
	</table>
	

</div>



<p class="clear" >&nbsp;</p>
<div class="wrapper clear" ></div>	<!-- wrapper -->




<script>

var gurl = "http://<?php echo GURL; ?>";



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
			var cart=$('.cartTable');
			var content="";
			content+="<tr><td>1</td><td class='vc200' >#"+s.id+" "+s.name+"</td>";
			content+="<td><input class='center vc50' type='number' value=1 ></td>";
			content+="<td>"+s.price+"</td></tr>";
			
			cart.append(content);

		}		 
    });				

	
}

// function 


</script>

