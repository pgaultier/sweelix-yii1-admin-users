<?php
/**
 * File _itemView.php
 *
 * PHP version 5.4+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   3.0.0
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweelix.yii1.admin.users.views.default
 */
use sweelix\yii1\web\helpers\Html;
?>
<tr>
	<td class="main-id">
		<?php echo $data->authorId; ?>
	</td>
	<td>
		<?php echo $data->authorFirstname; ?>
		<?php echo $data->authorLastname; ?>
	</td>
	<td class="email">
		<?php echo Html::link(
				$data->authorEmail,
				'mailto:'.$data->authorEmail,
				array('title' => Yii::t('users', 'Send an email to {email}', array('{email}' => $data->authorEmail)) )
		); ?>
	</td>
	<td class="date-time">
		<?php
			if($data->authorLastLogin !== null) {
				$parsedDate = CDateTimeParser::parse($data->authorLastLogin,'yyyy-MM-dd HH:mm:ss');
				echo Yii::app()->getLocale()->getDateFormatter()->formatDateTime($parsedDate, 'medium');
			}
		?>
	</td>
	<td class="action">
		<?php echo Html::link(
			Yii::t('users', 'Edit'),
			array('edit', 'id' => $data->authorId),
			array(
				'class' => 'icon-edit',
				'title' => Yii::t('users', 'Edit'),
			)
		);?>
	</td>
</tr>