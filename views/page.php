<!DOCTYPE HTML>
<html>
	<head>
		<script src= "web/assets/jquery/jquery.js" ></script>
		<script src = "web/js/request.js" ></script>
		<meta charset = "utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="web/assets/bootstrap/css/bootstrap.min.css">
		<title> Курс доллара </title>
	</head>
	<body>
		<form name = 'get-form' action = '' method = 'GET'>
			<input type="date" id ="calendar" required>
			<input type="submit" id = "btn" value="Отправить">
		</form>

		<div id = 'content'> </div>
		<table class="table">
		<thead>
			<tr>
			<th scope="col">Курс</th>
			<th scope="col">Дата</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		</table>
	</body>
</html>