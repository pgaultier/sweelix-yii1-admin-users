<?php
/**
 * File list.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweelix.yii1.admin.users.views.default
 */
use sweelix\yii1\web\helpers\Html;
?>

<?php $this->widget('sweelix\yii1\admin\core\widgets\Breadcrumb', array(
	'elements' => array(
		Yii::t('users', 'Users management')
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
		<?php $this->widget('sweelix\yii1\admin\core\widgets\ContextMenu', array(
			'main' => array(),
			// 'secondary' => array()
		)); ?>
			<?php
				$this->widget('sweelix\yii1\ext\web\widgets\ListView', array(
					'dataProvider' => $usersDataProvider,
					'itemView' => '_itemView',
					'headerView' => '_headerView',
					'footerView' => '_footerView',
					// 'summaryView' => '_summaryView',
					'template' => "<table>\n<thead>\n{header}\n{summary}\n</thead>\n<tbody>\n{items}\n</tbody>\n<tfoot>\n{footer}\n</tfoot>\n</table>",
					'viewData' => array(
							'title' => '{n} registered user|{n} registered users',
					),
				));
			?>
	</div>
</section>
