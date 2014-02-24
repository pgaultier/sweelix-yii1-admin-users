<?php
/**
 * File _form.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweelix.yii1.admin.users.views.default
 */
use sweelix\yii1\web\helpers\Html;
?>
	<fieldset>
		<?php echo Html::activeLabel($author, 'authorFirstname');?><br/>
		<?php echo Html::activeTextField($author, 'authorFirstname', array('class' => 'classic'));?><br/>

		<?php echo Html::activeLabel($author, 'authorLastname');?><br/>
		<?php echo Html::activeTextField($author, 'authorLastname', array('class' => 'classic'));?><br/>

		<?php echo Html::activeLabel($author, 'authorEmail');?><br/>
		<?php echo Html::activeTextField($author, 'authorEmail', array('class' => 'classic'))?><br/>

		<?php if($author->authorId !== Yii::app()->getUser()->getId()): ?>
		<label><?php echo Yii::t('users', 'Roles'); ?></label><br/>
		<?php echo Html::activeCheckBoxList($author, 'authorRoles', $roles, array(
			'separator' => "\n",
			'uncheckValue' => null,
		)); ?><br/>
		<?php endif; ?>

		<?php echo Html::activeLabel($author, 'authorPassword'); ?><br/>
		<?php echo Html::activePasswordField($author, 'authorPassword', array('class' => 'classic')); ?><br/>

		<?php echo Html::activeLabel($author, 'authorControlPassword'); ?><br/>
		<?php echo Html::activePasswordField($author, 'authorControlPassword', array('class' => 'classic')); ?><br/>
		<?php echo Html::link(Yii::t('users', 'Cancel'), array('default/'), array('class' => 'button danger')); ?>
		<?php echo Html::htmlButton(Yii::t('users', 'OK'), array('type' => 'submit', 'class' => 'success')); ?>
	</fieldset>
<?php

if((isset($notice) === true) && ($notice === true)) {
	if($author->hasErrors() === false) {
		echo Html::script(Html::raiseShowNotice(array(
				'title' => '<span class="icon-bubble-dots light"></span> '. Yii::t('users', 'Info'),
				'close' => '<span class="icon-circle-cancel light">x</span>',
				'text' => Yii::t('users', 'User details were saved'),
				'cssClass' => 'success'
		)));
	} else {
		echo Html::script(Html::raiseShowNotice(array(
				'title' => '<span class="icon-bubble-exclamation light"></span> '. Yii::t('users', 'Error'),
				'close' => '<span class="icon-circle-cancel light">x</span>',
				'text' => Yii::t('users', 'User details were not saved'),
				'cssClass' => 'danger'
		)));
	}
}
