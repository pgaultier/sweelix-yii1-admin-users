<?php
/**
 * File ListUsers.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweelix.yii1.admin.users.widgets
 */

namespace sweelix\yii1\admin\users\widgets;

use sweelix\yii1\web\helpers\Html;
use sweelix\yii1\admin\core\models\Author;
use Yii;

/**
 * Class ListUsers
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweelix.yii1.admin.users.widgets
 */
class ListUsersWidget extends \CWidget
{
    /**
     * @var array collection list of users
     */
    private $list = null;

    /**
     * Init client part (js, css, ...) needed to handle tree users
     *
     * @return void
     * @since  1.11.0
     */
    private function _initClient()
    {
        $sweeftModule = Yii::app()->getModule('sweeft');
        Yii::app()->getClientScript()->registerCoreScript('cookie');
        Yii::app()->getClientScript()->registerSweelixScript('callback');
        Yii::app()->getClientScript()->registerCssFile($sweeftModule->getAssetsUrl() . '/css/jstree.css');
        Yii::app()->getClientScript()->registerScriptFile($sweeftModule->getAssetsUrl() . '/js/jquery.jstree.js');
        Yii::app()->getClientScript()->registerScriptFile($this->getController()->getModule()->getAssetsUrl() . '/js/jquery.sweelix.users.js');
    }

    /**
     * Init widget
     * Called by CController::beginWidget()
     *
     * @return void
     * @since  1.11.0
     */
    public function init()
    {
        Yii::trace(__METHOD__ . '()', 'sweelix.yii1.admin.users.widgets');
        $this->_initClient();
        $criteria = new \CDbCriteria();
        $criteria->order = 'authorId asc';
        //XXX: be carefull, we must pass full tree users.
        $this->list = Author::model()->findAll($criteria);
    }

    /**
     * Render widget
     * Called by CController::endWidget()
     *
     * @return void
     * @since  1.11.0
     */
    public function run()
    {
        Yii::trace(__METHOD__ . '()', 'sweelix.yii1.admin.users.widgets');
        echo Html::tag(
            'div',
            array('id' => 'treemenu'),
            self::listToHtml($this->list)
        );
    }

    /**
     * Render users list
     *
     * @param array $data array of Author
     * @param integer $currentUserId the id of the current user
     *
     * @return string
     * @since  1.11.0
     */
    public static function listToHtml($data)
    {
        Yii::trace(__METHOD__ . '()', 'sweelix.yii1.admin.users.widgets');

        $str = Html::tag('ul', array('id' => 'treeMenu'), false, false);

        foreach ($data as $row) {
            $class = 'leaf';

            $str .= Html::tag(
                'li',
                array(
                    'id' => 'node-' . $row->authorId,
                    'class' => $class,
                ),
                Html::link(
                    $row->getFullName(),
                    array('user/edit', 'userId' => $row->authorId),
                    array('title' => $row->authorFirstname)
                ),
                false
            );

            $str .= Html::closeTag('li');
        }
        $str .= Html::closeTag('ul');
        return $str;
    }
}
