function chkAllvarCalc(x){
	$('#chkAll'+x).click(function(event) {
		var total=0;	
		if(this.checked) {
			$('.chk'+x).each(function() {
				this.checked = true;
				total+= parseFloat($(this).val());				
			});
			$('#calctotal').val(parseFloat(total).toFixed(2));					
			
		} else {
			$('.chk'+x).each(function() {
				this.checked = false;
			});
			$('#calctotal').val(parseFloat(total).toFixed(2));								
		}
	});

}	/* fxn */