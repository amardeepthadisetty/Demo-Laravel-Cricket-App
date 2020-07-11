<!DOCTYPE html>
<html>
<head>
	<title>Templates Excel Import</title>
</head>
<body>
	<div>
		<h1>Templates Excel Importer</h1>
		<p>
			<form method="POST" action="<?php echo e(route('templates.importexcel')); ?>" enctype="multipart/form-data">
				<?php echo csrf_field(); ?>
				<input type="file" name="select_file">
				<input type="submit" name="">
				
			</form>
			
		</p>
	</div>
</body>
</html><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/import/templatesimportexcel.blade.php ENDPATH**/ ?>