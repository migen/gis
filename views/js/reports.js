
function fby(){
	var start = year+'-01-01';
	var end = year+'-12-31';
	$('#start').val(start);
	$('#end').val(end);
}

function fbm(){
	$('#start').val(year+'-'+month_id+'-01');
	$('#end').val(ldm);
}



function fbtoday(){
	$('#start').val(today);
	$('#end').val(tomorrow);
}


function fbdate(){
	var date=$('#date').val();
	$('#start').val(date);
	$('#end').val(date);	
}

function dateToday(today){
	$('#start').val(today);
	$('#end').val(today);
}