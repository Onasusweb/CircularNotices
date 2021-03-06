<?php
/**
 * circular notice edit target element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="form-group">
	<div>
		<?php echo $this->Form->label(
			'CircularNoticeContent.userId',
			__d('circular_notices', 'Circular Target') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div class="col-xs-offset-1 col-xs-11">
		<?php echo $this->Form->input('CircularNoticeContent.is_room_targeted_flag', array(
			'div' => false,
			'type' => 'select',
			'label' => false,
			'error' => false,
			'multiple' => 'checkbox',
			'selected' => $circularNoticeContent['isRoomTargetedFlag'],
			'options' => array(
				'1' => __d('circular_notices', 'All Members Belings to this Room'),
			),
		)); ?>
		<?php
			$options = array();
			foreach ($groups as $group) :
				$options[$group['group']['id']] = $group['group']['name'];
			endforeach;
			echo $this->Form->input('CircularNoticeContent.target_groups', array(
				'div' => false,
				'type' => 'select',
				'label' => false,
				'error' => false,
				'multiple' => 'checkbox',
				'selected' => $circularNoticeContent['targetGroups'],
				'options' => $options,
			));
		?>
	</div>
	<div>
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'CircularNoticeContent',
				'field' => 'is_room_targeted_flag',
			]); ?>
	</div>
</div>
