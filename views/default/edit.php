<?php
/**
 * File edit.php
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

<?php $this->widget('sweeft.widgets.BreadcrumbWidget', array(
	'elements' => array(
		Yii::t('users', 'Users management'),
		Yii::t('users', 'Editing user ID {id}', array('{id}' => $author->authorId)),
	),
)); ?>

<nav>
	<br><br><br>
	<ul class="shortcuts">
		<li>
			<?php echo Html::link(
					Yii::t('users', 'Create new user'),
					array('create'),
					array('title'=>Yii::t('users', 'Create new user'))
			);?>
		</li>
	</ul>
</nav>
<section>
	<div id="content">
		<ul class="menu">
			<li>
				<?php echo Html::link(Yii::t('users', 'Users list'), array('index'), array('title' => Yii::t('users', 'Users list'))); ?>
			</li>
		</ul>

			<?php echo Html::beginAjaxForm('','post');?>
				<?php $this->renderPartial('_form', array('author'=>$author, 'option'=>'create', 'notice'=>(isset($notice)?$notice:false), 'roles'=>$roles)); ?>
			<?php echo Html::endForm(); ?>
	</div>
</section>

