<!DOCTYPE html>
<html>
<head>
	<title>Products Excel Import</title>
</head>
<body>
	<div>
		<h1>Products Excel Importer</h1>
		<p>
			<form method="POST" action="{{ route('products.importexcel')  }}" enctype="multipart/form-data">
				@csrf
				<input type="file" name="select_file">
				<input type="submit" name="">
				
			</form>
			
		</p>
	</div>
</body>
</html>