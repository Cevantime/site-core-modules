<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<script type="text/javascript">
			var baseURL = "<?php echo base_url(); ?>";
		</script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/pagination.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/homeSlider.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/homePopup.js"></script>
		<link rel="stylesheet" href="<?php echo base_url('css/stylesheet.css'); ?>"></link>
		<?php echo $css_for_layout ?>
		<?php echo $js_for_layout ?>
		
        <title><?php echo $title_for_layout ?></title>
    </head>
    <body>
		<div id="fb-root"></div>
		<?php $this->load->view('includes/messages'); ?>
		
        <div id="wrap">
            <?php echo $content_for_layout ?>
        </div><!-- end wrapper -->
    </body>
</html>
