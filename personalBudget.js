
function setCurrentDate()
{
	var today = new Date();
	var date = today.toISOString().substr(0, 10);
	
	$("#date").val(date);
}
