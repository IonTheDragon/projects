<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Платежи');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Пополнить баланс'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'datetime',
            'phone',
            'amount',

			['class' => 'yii\grid\ActionColumn',

				'template'=>'{delete}',

					'buttons'=>[

						'delete' => function ($url, $model) {
							return Html::a('<span class="glyphicon glyphicon-minus"></span>', $url, [
										'title' => Yii::t('app', 'Отменить'),
										'data' => [
											'confirm' => Yii::t('app', 'Вы уверены что хотите отменить платёж?'),
											'method' => 'post',
										],
							]);
						}

					],                           
					
			],
        ],
    ]); ?>
	
	<p>Итого <?php echo empty($total) ? 0 : $total ?></p>

</div>
