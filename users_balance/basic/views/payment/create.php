<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */

$this->title = Yii::t('app', 'Пополнить баланс');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Платежи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	
	<p style="color:red"><?php echo empty($message) ? '' : $message?></p>

</div>
