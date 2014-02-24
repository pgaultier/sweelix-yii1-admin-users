<?php
/**
 * File _itemView.php
 *
 * PHP version 5.2+
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2013 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.1
 * @link      http://www.sweelix.net
 * @category  views
 * @package   sweeft.modules.users.views.user
 */
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
		<?php echo Sweeml::link(
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
		<?php echo Sweeml::link(
			Yii::t('users', 'Edit'),
			array('edit', 'id' => $data->authorId),
			array(
				'class' => 'icon-edit',
				'title' => Yii::t('users', 'Edit'),
			)
		);?>
	</td>
</tr>