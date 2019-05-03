<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>		
<h4>Users</h4>
<?=Yii::$app->user->isGuest ? ('<p>Please login to edit table</p>') : ('')?>
<table id="user_table">
	<tr>
		<td>User</td>
		<td>Occupation</td>
		<td colspan="2">Action</td>
	</tr>	
<?php foreach ($persons as $person): ?>
	<tr id="ptr<?php echo $person->id?>">
		<td><?= Html::encode("{$person->name}") ?></td>
		<td><?= $person->occupation ?></td>
		<?=Yii::$app->user->isGuest ? ('<td></td>') : ('<td>'.Html::Button('Edit',array('onclick'=>'edit_person_form('.$person->id.');')).'</td><td>'.Html::Button('Delete',array('onclick'=>'delete_person('.$person->id.');')).'</td>')?>  
	</tr>
<?php endforeach; ?>
</table>
<?=Yii::$app->user->isGuest ? ('') : (yii\bootstrap4\Button::widget([
										'label' => 'Add',
										'options' => ['class' => 'btn-lg',  'onclick'=>'add_person_form();'],
										])
									 )
?>  
<?= LinkPager::widget(['pagination' => $pagination]) ?>		
