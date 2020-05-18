<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url; 

use kartik\datetime\DateTimePicker;
 

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="payment-form">

    <?php $form = ActiveForm::begin(['action' => Url::toRoute(['/payment/create'])]); ?>

    <?php
	echo '<label>Дата и время</label>';
	echo DateTimePicker::widget([
		'name' => 'Payment[datetime]',
		'options' => ['placeholder' => 'Выберите время ...'],
		'convertFormat' => true,
		'pluginOptions' => [
			'format' => 'y-MM-dd h:i',
			'todayHighlight' => true
		]
	]);
	?>
	<br>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
</div>
