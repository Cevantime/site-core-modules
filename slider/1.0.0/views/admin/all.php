<?php $this->load->helper('images/image') ?>
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Titre</th>
				<th>Texte</th>
				<th>Lien</th>
				<th>Image</th>
				<th style="width: 3.5em;">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($slides) : ?>
				<?php foreach ($slides as $slide): ?>
					<tr>
						<td><?php echo $slide->id; ?></td>
						<td><?php echo $slide->title; ?> </td>
						<td><?php echo $slide->desc; ?> </td>
						<td><?php echo $slide->link; ?> </td>
						<td ><?php echo '<img src="' . imageresize(base_url($slide->imageName), 300, 200) . '">'; ?></td>					
						<td>	
							<?php if (user_can('update', $modelName, $slide->id)): ?>
								<a href="<?php echo base_url('slider/sliderbo/edit') . '/' . $slide->id ?>"><i class="fa fa-pencil"></i></a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<a href="<?php echo base_url('slider/sliderbo/add'); ?>" class="btn btn-primary">Ajouter un slide</a>
</div>