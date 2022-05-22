<!DOCTYPE html>
<html>
<body>

<h2>Export Robot  data</h2>

<form action="{{route('upload-json-data-db')}}" method="post">
	@csrf
  <label for="fname">Json File:</label><br>
  <input type="file" id="json_file" name="json_file" required="">
  <br>
  <br>
  <input type="submit" value="Submit">
</form> 

</body>
</html>

