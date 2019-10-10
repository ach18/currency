$(document).ready(function(){
	$("#btn").click(
		function(){
			sendAjax();
			$("#content").append('<img id="waiting" src="web/img/loading.gif" />');
			$("#calendar").attr("disabled", true);
			return false;
		}
	);
});

function sendAjax(){
	$.ajax({
		type: "GET",
		url: "index.php",
		data: {
			ajax:true,
			date:$("#calendar").val()
		},
		success: function(response) {
			jsonObj = JSON.parse(response);
			$("#waiting").remove();
			$("#error").remove();
			//$("#content").append(response);
			$(".table").append('<tr><td>' + jsonObj['exchange_rate'] + '</td><td>' + jsonObj['date'] + '</td></tr>');
			$("#calendar").attr("disabled", false);
		},
		error: function(error){
			$("#waiting").remove();
			$("#content").html("<p id ='error'>Ошибка: укажите другую дату</p>");
			$("#calendar").attr("disabled", false);
		}
	});
}