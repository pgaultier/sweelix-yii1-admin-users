<?php
/**
 * File ActionMenu.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweelix.yii1.admin.users.widgets
 */

namespace sweelix\yii1\admin\users\widgets;
use sweelix\yii1\web\helpers\Html;

/**
 * Class ActionMenu
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.1
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweelix.yii1.admin.users.widgets
 */
class ActionMenu extends \CWidget {

	/**
	 * Init widget
	 * Called by CController::beginWidget()
	 *
	 * @return void
	 * @since  1.11.0
	 */
	public function init() {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.users.widgets');
		\Yii::app()->getClientScript()->registerCssFile($this->getController()->getModule()->getAssetsUrl().'/css/users.css');
	}

	/**
	 * Render widget
	 * Called by CController::endWidget()
	 *
	 * @return void
	 * @since  1.11.0
	 */
	public function run() {
		\Yii::trace(__METHOD__.'()', 'sweelix.yii1.admin.users.widgets');
		echo Html::tag('ul', array('id'=>'actionMenu'),
			Html::tag('li', array('class'=>'cancel'),
				Html::link(
					\Yii::t('users', 'Cancel / Back'),
					'javascript:window.history.back();',
					array('title'=>\Yii::t('users', 'Cancel / Back'))
				)
			)."\n".
			Html::tag('li', array('class'=>'contentElement'),
				Html::link(
					\Yii::t('users', 'Create new user'),
					array('user/new'),
					array('title'=>\Yii::t('users', 'Create new user'))
				)
			)
		);
	}
}
