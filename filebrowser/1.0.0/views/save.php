<?php

function fileVal($key, $datas) {
	return isset($datas) && isset($datas[$key]) ? $datas[$key] : '';
}
?>
<div id="forms">
	<fieldset>
		<legend>Ajouter un dossier</legend>
		<form id="form-add-folder" action="<?php echo current_url(); ?>" method="post">
			<input type="hidden" name="parent_id" id="InputParentId" value="0"/>
			<input type="text" name="name" id="InputName" value="<?php echo fileVal('name', $datas); ?>"/>
			<input type="hidden" name="is_folder"value="1"/>
			<input type="hidden" name="user_id" value="<?php echo user_id(); ?>"/>
			<button type="submit">Ajouter un dossier</button>

		</form>
	</fieldset>
	<fieldset>
		<legend>Ajouter un dossier</legend>
		<form id="form-add-file" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
			<input type="file" name="file" id="InputFile"/>
			<input type="hidden" name="parent_id" id="InputParentId" value="0"/>
			<input type="hidden" name="user_id" value="<?php echo user_id(); ?>"/>
			<input type="hidden" name="is_folder" value="0"/>
			<button type="submit">Ajouter un fichier</button>
		</form>
	</fieldset>
</div>
