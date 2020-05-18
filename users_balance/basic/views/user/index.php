<?php

use yii\helpers\Html;
use yii\grid\GridView;


use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Пользователи');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>		
		<?php
			Modal::begin([
			 'header' => '<h2>Создать пользователя</h2>',
			 'toggleButton' => ['label' => 'Создать пользователя', 'class' => 'btn btn-success'],
			 'footer' => '',
			]);
		?>
		<?=
			$this->render('_form', [
				'model' => $model,
			]);
		?>		
		<?php
			Modal::end();	
		?>
    </p>
	
	<p>		
		<?php
			Modal::begin([
			 'header' => '<h2>Пополнить баланс</h2>',
			 'toggleButton' => ['label' => 'Пополнить баланс', 'class' => 'btn btn-success'],
			 'footer' => '',
			]);
		?>
		<?=
			$this->render('/payment/_form', [
				'model' => $model_payment,
			]);
		?>		
		<?php
			Modal::end();	
		?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'phone',
            'balance',
			[
				'label' => 'Статус',
				'format' => 'raw',
				'value' => function($data){
					if($data->status) return 'Активен';
					else return 'Заморожен';
				},
			],

			['class' => 'yii\grid\ActionColumn',

				'template'=>'{activate}{delete}',

					'buttons'=>[

						'activate' => function ($url, $model) {	

							return Html::a('<span class="glyphicon glyphicon-lock"></span>', $url, [

								'title' => Yii::t('yii', 'Активировать/заблокировать'),

							]);                                          

						}

					]                            

			],
        ],
    ]); ?>
	
	<p style="color:red"><?php echo empty($message) ? '' : $message?></p>
	
</div>
