<!DOCTYPE html>
<html>
<head>
	<title>send</title>
</head>
<body>
	<form action="{{url('/send')}}" method="post">
		{{csrf_field()}}
	<input type="text" name="text">
	<input type="submit" name="submit">
	</form>
</body>
</html>