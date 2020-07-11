<!DOCTYPE html>
<html>
<head>
	<title>Templates Excel Import</title>
</head>
<body>
	<div>
		<h1>Templates Excel Importer</h1>
		<p>
			<form method="POST" action="{{ route('templates.importexcel')  }}" enctype="multipart/form-data">
				@csrf
				<input type="file" name="select_file">
				<input type="submit" name="">
				
			</form>
			
		</p>
	</div>
</body>
</html>