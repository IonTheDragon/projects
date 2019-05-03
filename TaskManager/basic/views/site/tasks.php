<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>	
	
<h4>Tasks</h4>
<?=Yii::$app->user->isGuest ? ('<p>Please login to edit table</p>') : ('')?>
<table id="task_table">	
	<tr>
		<td>Title</td>
		<td>User</td>
		<td>Status</td>
		<td>Description</td>
		<td colspan="2">Action</td>
	</tr>		
<?php foreach ($tasks as $task): ?>
	<tr id="tr<?php echo $task->id?>">
		<td><?= Html::encode("{$task->title}") ?></td>
		<td><?= $task->user ?></td>
		<td><?= $task->status ?></td>
		<td><?= $task->description ?></td>
		<?=Yii::$app->user->isGuest ? ('<td></td>') : ('<td>'.Html::Button('Edit',array('onclick'=>'edit_task_form('.$task->id.');')).'</td><td>'.Html::Button('Delete',array('onclick'=>'delete_task('.$task->id.');')).'</td>')?>      
	</tr>
<?php endforeach; ?>
</table>
<?=Yii::$app->user->isGuest ? ('') : (yii\bootstrap4\Button::widget([
										'label' => 'Add',
										'options' => ['class' => 'btn-lg', 'onclick'=>'add_task_form();'],
										])
									 )
?> 
<?= LinkPager::widget(['pagination' => $pagination_tasks]) ?>
