<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<link rel="shortcut icon" href="<?php echo site_url(UPLOAD_LOGO.get_option('icon')) ?>" />
	<link rel="apple-touch-icon" href="<?php echo site_url(UPLOAD_LOGO.get_option('icon')) ?>" />


	<base href="<?php echo $base_url; ?>" />

	<title><?php echo $page_title; ?></title>

	<?php
		foreach ($meta_data as $name => $content)
		{
			echo "<meta name='$name' content='$content'>".PHP_EOL;
		}

		foreach ($stylesheets as $media => $files)
		{
			foreach ($files as $file)
			{
				$url = starts_with($file, 'http') ? $file : base_url($file);
				echo "<link href='$url' rel='stylesheet' media='$media'>".PHP_EOL;
			}
		} 
        if(!empty($scripts['head'])){
    		foreach ($scripts['head'] as $file)
    		{
    			$url = starts_with($file, 'http') ? $file : base_url($file);
    			echo "<script src='$url'></script>".PHP_EOL;
    		}
        }
	?>
	<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
</head>
<body class="hold-transition sidebar-mini <?php echo $body_class; ?>" data-baseurl="<?php echo base_url(); ?>">