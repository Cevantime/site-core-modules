<?php

class Slide extends DATA_Model {
	
	CONST TABLE_NAME = 'slider';
	
	public function getTableName() {
		return self::TABLE_NAME;
	}
	
	public function validationRulesForInsert($datas) {
		return array(
			array(
				'field' => 'title',
				'label' => translate('Titre'),
				'rules' => 'required|min_length[2]|max_length[50]'
			),
			array(
				'field' => 'desc',
				'label' => translate('Description'),
				'rules' => 'required|min_length[10]|max_length[1000]'
			),
			array(
				'field' => 'link',
				'label' => translate('Link'),
				'rules' => 'valid_url'
			),
			array(
				'field' => 'imageName',
				'label' => translate('Image'),
				'rules' => 'file_required|file_image_mindim[500,500]|file_image_maxdim[2500,2500]|file_size_max[500KB]|file_allowed_type[image]'
			)
		);
	}
	
	public function validationRulesForUpdate($datas) {
		return array(
			array(
				'field' => 'title',
				'label' => translate('Titre'),
				'rules' => 'min_length[2]|max_length[50]'
			),
			array(
				'field' => 'desc',
				'label' => translate('Description'),
				'rules' => 'min_length[10]|max_length[1000]'
			),
			array(
				'field' => 'imageName',
				'label' => translate('Image'),
				'rules' => 'file_image_mindim[500,500]|file_image_maxdim[2500,2500]|file_size_max[500KB]|file_allowed_type[image]'
			)
		);
	}
	 public function uploadPaths() {

			return array('imageName' => 'uploads/slides');
        }

}
