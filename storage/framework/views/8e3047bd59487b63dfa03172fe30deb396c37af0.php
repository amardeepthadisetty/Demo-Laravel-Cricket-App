<!DOCTYPE html>
<html>
<head>
	<title>Products Excel Import</title>
</head>
<body>
	<div>
		<h1>Products Excel Importer</h1>
		<p>
			<form method="POST" action="<?php echo e(route('products.importexcel')); ?>" enctype="multipart/form-data">
				<?php echo csrf_field(); ?>
				<input type="file" name="select_file">
				<input type="submit" name="">
				
			</form>
			
		</p>
	</div>
</body>
</html><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/import/importexcel.blade.php ENDPATH**/ ?>