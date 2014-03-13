<?php
/**
 * File Module.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.0
 * @link      http://www.sweelix.net
 * @category  users
 * @package   sweelix.yii1.admin.users
 */

namespace sweelix\yii1\admin\users;
use sweelix\yii1\admin\core\components\BaseModule;

/**
 * Class Module
 *
 * This module is the base container for all admin submodules
 * @see Module in components.
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.0
 * @link      http://www.sweelix.net
 * @category  users
 * @package   sweelix.yii1.admin.users
 * @since     1.0.0
 */
class Module extends BaseModule {
	/**
	 * @var string controllers namespace
	 */
	public $controllerNamespace = 'sweelix\yii1\admin\users\controllers';
	/**
	 * Init the module with specific information.
	 * @see CModule::init()
	 *
	 * @return void
	 * @since  1.2.0
	 */
	protected function init() {
		$this->basePath = __DIR__;
		\Yii::setPathOfAlias($this->getShortId(), __DIR__);
		\Yii::app()->getMessages()->extensionPaths[$this->getShortId()] = $this->getShortId().'.messages';
		parent::init();
	}
}
