<?php

/* @var $this yii\web\View */

use yii\helpers\Url;  
use yii\helpers\Html; 

$this->title = 'Главная';

?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Баланс пользователей</h2>
		<?php
			echo Yii::$app->user->identity && Yii::$app->user->identity->is_admin 
			? 
				'<p><a class="btn btn-success" href="'.
					Url::toRoute(['/user/index']).'">Перейти к таблице пользователей</a></p> 
				<p><a class="btn btn-success" href="'.
					Url::toRoute(['/payment/index']).'">Перейти к таблице платежей</a></p>'					
			: (
				Yii::$app->user->identity 
				
				?
				
				'<h4>Авторизуйтесь как админ для работы с таблицей пользователей</h4>'.
					
				(
					'<p>'
					. Html::beginForm(['/site/logout'], 'post')
					. Html::submitButton(
						'Выход (' . Yii::$app->user->identity->username . ')',
						['class' => 'btn btn-success logout']
					)
					. Html::endForm()
					. '</p>'
				)					
				
				:
				
				'<h4>Авторизуйтесь для работы с таблицей пользователей</h4>
					<p><a class="btn btn-success" href="'.
					Url::toRoute(['/site/login']).'">Авторизоваться</a></p>
				');				
		?>
    </div>
	<!--
    <div class="body-content">

        <div class="row">
            <div class="col">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
        </div>

    </div>
	-->
</div>
