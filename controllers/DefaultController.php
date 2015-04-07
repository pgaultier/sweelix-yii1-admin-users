<?php
/**
 * File DefaultController.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  controllers
 * @package   sweelix.yii1.admin.users.controllers
 */

namespace sweelix\yii1\admin\users\controllers;

use sweelix\yii1\admin\core\web\Controller;
use sweelix\yii1\admin\core\models\Author;
use sweelix\yii1\web\helpers\Html;
use CActiveDataProvider;
use CDbCriteria;
use CLogger;
use Yii;
use Exception;

/**
 * Class DefaultController
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.1.0
 * @link      http://www.sweelix.net
 * @category  controllers
 * @package   sweelix.yii1.admin.users.controllers
 *
 * @property array rolesFromModules
 */
class DefaultController extends Controller
{

    /**
     * Default action. Should redirect to real action
     *
     * @return void
     * @since  1.11.0
     */
    public function actionIndex()
    {
        try {
            Yii::trace(__METHOD__ . '()', 'sweelix.yii1.admin.users.controllers');
            $authManager = Yii::app()->getAuthManager();
            $existingModules = array_keys($this->getModule()->getParentModule()->getModules());

            $missingModules = array();
            $definedModules = array();

            foreach ($authManager->getAuthItems(\CAuthItem::TYPE_ROLE) as $module => $data) {
                $definedModules[] = $module;
            }

            foreach ($existingModules as $existingModule) {
                if (in_array($existingModule, $definedModules) === true) {
                    $definedModules = array_diff($definedModules, array($existingModule));
                } else {
                    $missingModules[] = $existingModule;
                }
            }
            if (count($definedModules) > 0) {
                //remove authitems
                foreach ($definedModules as $definedModule) {
                    $authManager->removeAuthItem($definedModule);
                }
            }
            if (count($missingModules) > 0) {
                //add authitems
                foreach ($missingModules as $missingModule) {
                    $authManager->createAuthItem($missingModule, \CAuthItem::TYPE_ROLE);
                }
            }

            $criteria = new CDbCriteria();
            $criteria->order = 'authorLastname, authorFirstname ASC';
            $usersDataProvider = new CActiveDataProvider(
                'sweelix\yii1\ext\entities\Author',
                array('criteria' => $criteria)
            );
            $this->render('list', array('usersDataProvider' => $usersDataProvider));

        } catch (Exception $e) {
            Yii::log(
                'Error in ' . __METHOD__ . '():' . $e->getMessage(),
                CLogger::LEVEL_ERROR,
                'sweelix.yii1.admin.users.controllers'
            );
            throw $e;
        }

    }

    /**
     * Perform user creation
     *
     * @return void
     * @since  2.0.0
     */
    public function actionCreate()
    {
        try {
            Yii::trace(__METHOD__ . '()', 'sweelix.yii1.admin.users.controllers');
            $callback = false;
            $author = new Author('create');

            $roles = $this->getRolesFromModules();

            if (isset($_POST[Html::modelName($author)])) {
                $callback = true;
                $author->attributes = $_POST[Html::modelName($author)];
                if ($author->save() === true) {
                    $authManager = Yii::app()->getAuthManager();
                    foreach ($author->authorRoles as $role) {
                        $authManager->assign($role, $author->authorId);
                    }
                    $authManager->save();
                    $this->redirect(array('index', 'id' => $author->authorId));
                } else {
                    $author->authorPassword = '';
                    $author->authorControlPassword = '';
                }
            }
            if (Yii::app()->getRequest()->isAjaxRequest === true) {
                $this->renderPartial('_form', array('author' => $author, 'roles' => $roles, 'notice' => $callback));
            } else {
                $this->render('create', array('author' => $author, 'roles' => $roles, 'notice' => $callback));
            }
        } catch (Exception $e) {
            Yii::log(
                'Error in ' . __METHOD__ . '():' . $e->getMessage(),
                CLogger::LEVEL_ERROR,
                'sweelix.yii1.admin.users.controllers'
            );
            throw $e;
        }
    }

    /**
     * Perform user edition
     *
     * @return void
     * @since  2.0.0
     */
    public function actionEdit($id)
    {
        try {
            Yii::trace(__METHOD__ . '()', 'sweelix.yii1.admin.users.controllers');
            $callback = false;
            $author = Author::model()->findByPk($id);
            $author->setScenario('adminUpdate');
            if ($author === null) {
                throw new \CHttpException(404, Yii::t('users', 'User does not exist'));
            }
            $authManager = Yii::app()->getAuthManager();
            $roles = $this->getRolesFromModules();

            if (isset($_POST[Html::modelName($author)])) {
                $callback = true;
                $author->attributes = $_POST[Html::modelName($author)];
                if ($author->validate() === true) {
                    $attributes = array(
                        'authorLastname',
                        'authorFirstname',
                        'authorEmail'
                    );
                    if ($author->authorPassword !== '') {
                        $attributes[] = 'authorPassword';
                    }
                    if ($author->save(true, $attributes) === true) {
                        if ($author->authorId !== Yii::app()->getUser()->getId()) {
                            foreach ($roles as $realRole => $baseRole) {
                                if (in_array($realRole, $author->authorRoles) === true) {
                                    if ($authManager->checkAccess($realRole, $author->authorId) === false) {
                                        $authManager->assign($realRole, $author->authorId);
                                    }
                                    // we need it
                                } else {
                                    $authManager->revoke($realRole, $author->authorId);
                                    // we should remove it
                                    // $authManager
                                }
                            }
                            $authManager->save();
                        }
                    }
                }
            } else {
                $author->authorRoles = array_keys($authManager->getRoles($author->authorId));
            }
            $author->authorPassword = '';
            $author->authorControlPassword = '';
            if (Yii::app()->getRequest()->isAjaxRequest === true) {
                $this->renderPartial('_form', array('author' => $author, 'roles' => $roles, 'notice' => $callback));
            } else {
                $this->render('edit', array('author' => $author, 'roles' => $roles, 'notice' => $callback));
            }
        } catch (Exception $e) {
            Yii::log(
                'Error in ' . __METHOD__ . '():' . $e->getMessage(),
                CLogger::LEVEL_ERROR,
                'sweelix.yii1.admin.users.controllers'
            );
            throw $e;
        }
    }


    private $rolesFromModules;

    /**
     * Get available roles
     *
     * @return array
     * @since  2.0.0
     */
    protected function getRolesFromModules()
    {
        if ($this->rolesFromModules === null) {
            $this->rolesFromModules = array();
            $modules = array_keys(Yii::app()->getAuthManager()->getRoles());

            // $values = array_fill(0, count($modules), false);
            $this->rolesFromModules = array_combine($modules, $modules);
        }
        return $this->rolesFromModules;
    }

    /**
     * Define filtering rules
     *
     * @return array
     * @since  1.11.0
     */
    public function filters()
    {
        return array('accessControl');
    }

    /**
     * Define access rules / rbac stuff
     *
     * @return array
     * @since  1.11.0
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'roles' => array($this->getModule()->getName())
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }
}
