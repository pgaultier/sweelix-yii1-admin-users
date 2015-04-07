<?php
/**
 * File _headerView.php
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
?>
<tr>
	<th class="main-id">
		<?php echo(Yii::t('users', 'Id'));?>
	</th>
	<th>
		<?php echo(Yii::t('users', 'Name'));?>
	</th>
	<th class="email">
		<?php echo(Yii::t('users', 'Email'));?>
	</th>
	<th class="date-time">
		<?php echo(Yii::t('users', 'Last login'));?>
	</th>
	<th class="action">
		<?php echo(Yii::t('users', 'Action'));?>
	</th>
</tr>