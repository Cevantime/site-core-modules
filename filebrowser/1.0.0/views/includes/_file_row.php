<?php if ($file->is_folder): ?>
	<li class="file file-folder" data-file="<?php echo $file->id; ?>" id="folder-<?php echo $file->id; ?>">
		<div class="file-row">
			<span class="file-icon"><i class="fa fa-folder"></i></span>
			<a href="#" class="folder-name"><?php echo $file->name; ?></a> 
			<div class="file-actions">
				<a title="Supprimer le dossier" href="#" class="action" data-action="delete" data-file="<?php echo $file->id; ?>"><i class="fa fa-trash"></i></a>
				<a title ="Ajouter un dossier" href="#" class="action" data-action="add-folder" data-file="<?php echo $file->id; ?>"><i class="fa fa-folder"></i></a>
				<a title="Ajouter un fichier" href="#" class="action" data-action="add-file" data-file="<?php echo $file->id; ?>"><i class="fa fa-file"></i></a>
				<a title="Renommer un fichier" href="#" class="action" data-action="rename" data-file="<?php echo $file->id; ?>"><i class="fa fa-edit"></i></a>
				
			</div>

		</div>
	</li>
<?php else: ?>
	<li class="file file-file" data-type="<?php echo $file->type; ?>" data-source="<?php echo $file->file; ?>" data-file="<?php echo $file->id; ?>" id="file-<?php echo $file->id; ?>">
		<div class="file-row">
			<span class="file-icon"><img src="<?php echo imageresize($file->file, 20, 20); ?>" title="<?php echo $file->name; ?>"/></span>
			<a class="file-name" href="#"><?php echo $file->name; ?></a>
			<div class="file-actions">
				<a title="Supprimer le fichier" href="#" class="action" data-action="delete" data-file="<?php echo $file->id; ?>"><i class="fa fa-trash"></i></a>
				<a title="Renommer un fichier" href="#" class="action" data-action="rename" data-file="<?php echo $file->id; ?>"><i class="fa fa-edit"></i></a>
			</div>
		</div>
	</li>
<?php endif; ?>


