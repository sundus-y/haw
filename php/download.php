<?php
	$file = basename($_GET['file']);
	echo $file;
	$file = 'upload/'.$file;

 	if(!file_exists($file)){ // file does not exist
		echo $file;
		die('Error: File not found');
	} else {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();

		// read the file from disk
		readfile($file);
	}
?>