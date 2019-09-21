<!DOCTYPE html>
<html>
<head>
	<title>JSON</title>
</head>
<body>
	<script type="text/javascript">
		var request = new XMLHttpRequest();
		var requestURL = 'http://dummy.restapiexample.com/api/v1/employees';
		request.open('GET', requestURL);

		request.send();
		request.onload = function(){
			var ourData = JSON.parse(request.responseText);
      		for(var i = 0 ; i<ourData.length;i++){
      			console.log(ourData[i].employee_name);
      		}
		};


	</script>

</body>
</html>