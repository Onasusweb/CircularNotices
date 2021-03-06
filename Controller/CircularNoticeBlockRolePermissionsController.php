<?php
/**
 * CircularNoticeBlockRolePermissions Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppController', 'CircularNotices.Controller');

/**
 * CircularNoticeBlockRolePermissions Controller
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Controller
 */
class CircularNoticeBlockRolePermissionsController extends CircularNoticesAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'CircularNotices.CircularNoticeSetting',
		'Blocks.Block',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsRoomRole' => array(
			// コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('edit')
			),
		),
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		// タブの設定
		$this->initSettingTabs('role_permissions');
	}

/**
 * edit action
 *
 * @return void
 */
	public function edit() {
		if (! $this->NetCommonsFrame->validateFrameId()) {
			$this->throwBadRequest();
			return false;
		}

		if (! $frame = $this->Frame->findById($this->viewVars['frameId'])) {
			$this->throwBadRequest();
			return false;
		}

		if (! $frame['Block'] || ! $frame['Block']['id']) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', $frame['Block']['id']);
		$this->set('blockKey', $frame['Block']['key']);

		$permissions = $this->NetCommonsBlock->getBlockRolePermissions(
			$this->viewVars['blockKey'],
			['content_creatable']
		);

		if (! $setting = $this->CircularNoticeSetting->getCircularNoticeSetting($this->viewVars['frameId'])) {
			$this->throwBadRequest();
			return false;
		}

		if ($this->request->is(array('post', 'put'))) {
			$data = $this->data;
			$this->CircularNoticeSetting->saveCircularNoticeSetting($data);
			if ($this->handleValidationError($this->CircularNoticeSetting->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirectByFrameId();
				}
				return;
			}
		}

		$results = array(
			'circularNoticeSetting' => $setting['CircularNoticeSetting'],
			'blockRolePermissions' => $permissions['BlockRolePermissions'],
			'roles' => $permissions['Roles'],
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}
}
