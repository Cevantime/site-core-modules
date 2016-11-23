<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class File extends DATA_Model {

	const TABLE_NAME = 'files';

	public $infos = array();

	public function getInfos($filename) {
		return $this->infos[$filename];
	}

	public function getTableName() {
		return self::TABLE_NAME;
	}

	public function validationRulesForInsert($datas) {
		$m = $this;
		$rules = array(
			'is_folder' => array(
				'field' => 'is_folder',
				'label' => translate('Est un répertoire'),
				'rules' => 'required|in_list[0,1]'
			),
			'parend_id' => array(
				'field' => 'parent_id',
				'label' => translate('Dossier parent'),
				'rules' => array(
					array('is_natural_or_empty', function($v) {
							$this->load->library('form_validation');
							return $this->form_validation->is_natural($v) || $v === '';
						})
				)
			)
		);
		if (isset($datas['is_folder']) && $datas['is_folder']) {

			$rules['name'] = array(
				'field' => 'name',
				'label' => translate('Nom de fichier'),
				'rules' => array(
					'required',
					'regex_match[/^([a-zA-ZÀ-ÿ\-_ 0-9\.]+)$/]',
					array('is_parent_uniq', function($name) use ($datas) {
							$userId = $datas['user_id'];
							if (!isset($datas['parent_id']))
								return true;
							$parentId = $datas['parent_id'];
							if (!$parentId) {
								$parentId = null;
							}
							return $this->isParentUniq($name, $parentId, $userId);
						}
					))
			);
		} else {
			$rules['file'] = array(
				'field' => 'file',
				'label' => translate('Fichier'),
				'rules' => 'file_required|file_allowed_type[image,image_icon,application,document,compress]'
			);
		}
		return $rules;
	}

	public function validationRulesForUpdate($datas) {
		$model = $this;
		$rules['id'] = array(
			'field' => 'id',
			'label' => 'Id',
			'rules' => array(
				'required',
				'is_natural',
				array('exists', array($model, 'exists'))
			)
		);
		$rules['name'] = array(
			'field' => 'name',
			'label' => translate('Nom de fichier'),
			'rules' => array(
				'regex_match[/^([a-zA-ZÀ-ÿ\-_ 0-9\.]+)$/]',
				array('is_parent_uniq', function($name) use ($datas) {
						$userId = $datas['user_id'];
						$parentId = isset($datas['parent_id']) ? $datas['parent_id'] : null;
						if (!isset($datas['parent_id']))
							return $parentId = null;

						else {
							$parentId = $datas['parent_id'];
						}

						if (!$parentId) {
							$parentId = null;
						}
						return $this->isParentUniq($name, $parentId, $userId);
					}
				))
		);

		$rules['parent_id'] = array(
			'field' => 'parent_id',
			'label' => translate('Dossier parent'),
			'rules' => array(
				array('is_natural_or_empty', function($v) {
						$this->load->library('form_validation');
						return $this->form_validation->is_natural($v) || $v === '';
					}),
				array('is_not_self_containing', function($v) use($datas) {
						if ($v === $datas['id']) {
							return false;
						}
						$parent = $this->getId($v);
						if (!$parent)
							return true;
						$hierarchy = explode('/', $parent->hierarchy);
						if (in_array($datas['id'], $hierarchy)) {
							return false;
						}

						return true;
					})
			)
		);
		return $rules;
	}

	public function isParentUniq($name, $parentId, $userId = null) {
		if (!$userId) {
			$userId = user_id();
		}
		if (!$parentId)
			$parentId = null;
		return $this->get(array('user_id' => $userId, 'name' => $name, 'parent_id' => $parentId)) == FALSE;
	}

	public function fromDatas($datas = null) {
		$this->infos = array();
		return parent::fromDatas($datas);
	}

	protected function doUpload(&$datas, $uploadPath, $key) {
		if (isset($datas['id']) && $datas['id']) {
			return true;
		}
		if (isset($_FILES[$key])) {
			$this->upload->initialize(array('upload_path' => './' . $uploadPath, 'allowed_types' => '*'));
			if ($this->upload->do_upload($key)) {
				$this->infos[$key] = $this->upload->data();
				if ($datas) {
					$datas[$key] = $uploadPath . '/' . $this->upload->file_name;
				} else {
					$_POST[$key] = $uploadPath . '/' . $this->upload->file_name;
				}
			} else {
				return false;
			}
		}
		return true;
	}

	protected function beforeInsert(&$to_insert = null) {
		if (array_key_exists('parent_id', $to_insert) && !$to_insert['parent_id'])
			$to_insert['parent_id'] = null;

		if (array_key_exists('parent_id', $to_insert)) {
			$parent = $this->getId($to_insert['parent_id']);
		} else {
			$parent = null;
		}
		$to_insert['hierarchy'] = $parent ? $parent->hierarchy . '/' . $parent->id : '';
		if (!isset($to_insert['is_folder']) || !$to_insert['is_folder']) {
			$to_insert['infos'] = $this->infos['file'];
			$to_insert['name'] = $this->infos['file']['file_name'];
			$to_insert['type'] = $this->infos['file']['file_type'];
		} else {
			$to_insert['file'] = null;
			$to_insert['infos'] = null;
		}


		parent::beforeInsert($to_insert);
	}

	protected function beforeUpdate(&$datas = null, $where = null) {
		if (array_key_exists('parent_id', $datas) && !$datas['parent_id']) {
			$datas['parent_id'] = null;
		}

		if (array_key_exists('parent_id', $datas)) {
			$parent = $this->getId($datas['parent_id']);
		} else {
			$parent = null;
		}
		unset($datas['is_folder']);
		unset($datas['infos']);
		unset($datas['file']);
		if (array_key_exists('parent_id', $datas)) {
			$parent = $this->getId($datas['parent_id']);
			$datas['hierarchy'] = $parent ? $parent->hierarchy . '/' . $parent->id : '';
		}
		parent::beforeUpdate($datas, $where);
	}

	public function getGrouped($where = null, $filters = null, $type = 'object', $columns = null) {
		$this->db->order_by('is_folder DESC, name ASC');
		if ($filters && !in_array('all', $filters)) {
			$this->db->group_start()
					->where_in('type', $filters)
					->or_where('type', null)
					->group_end();
		}
		if ($where) {
			$this->db->where($where);
		}
		return parent::get(NULL, $type, $columns);
	}

	public function isOwnedBy($file, $user) {
		return $file->user_id == $user->id;
	}

	public function uploadPaths() {
		return array('file' => 'uploads/filebrowser');
	}

	public function deleteFile($file) {
		$children = $this->get(array('parent_id' => $file->id));
		if ($children) {
			foreach ($children as $child) {
				$this->deleteFile($child);
			}
		}
		if($this->deleteId($file->id) && $file->file) {
			unlink($file->file);
		}
	}

}
