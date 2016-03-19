<div class="row save-post">
	<div class="col-lg-9 col-md-12 main-content">
		<form class="form_add_blogpost" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
			<?php $this->load->view('blog/includes/bo-content'); ?>
			<button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		</form>
	</div>
</div>