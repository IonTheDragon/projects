<?php

/* @var $this yii\web\View */

use yii\helpers\Url;  
use yii\helpers\Html;
use yii\widgets\LinkPager; 

use yii\bootstrap\Modal;
 

$this->title = 'Главная';
?>

<style>
	.paginate_button:last-of-type
	{
		display: none !important;
	}
</style>

<link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<div class="site-index">

    <div class="jumbotron">
        <h2>Таблица пользователей</h2>
		<?php
			echo Yii::$app->user->isGuest
			? 
				('<h4>Авторизуйтесь для работы с таблицей пользователей</h4>
					<p><a class="btn btn-success" href="'.
					Url::toRoute(['/site/login']).'">Авторизоваться</a></p>
				')			
							
			: 
				(
				''
				);				
		?>
    </div>
	<?php if (!Yii::$app->user->isGuest) { ?>
    <div class="body-content">

        <div class="row">
            <div class="col">
				<p>
					<a class="btn btn-success" onClick="add_item()">Добавить случайного пользователя</a>
				</p>
				<?php
				Modal::begin([
					'header' => '<h2>Добавить пользователя</h2>',
					'toggleButton' => ['label' => 'Добавить пользователя', 'class' => 'btn btn-success'],
					'footer' => '',
				]);
				 
				?>
				<form action="<?= Url::toRoute(['/site/custom-add']) ?>" method="post" id="addForm">
					<div class="form-group field-name required">
						<label class="control-label" for="name">Имя</label>
						<input type="text" id="name" class="form-control" name="name" maxlength="255">
					</div>
					<div class="form-group field-city required">
						<label class="control-label" for="city">Город</label>
						<select id="city" class="form-control" name="city">
						    <?php foreach ($cities as $city) { ?>
							<option value="<?= $city->cid ?>"><?= $city->name ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group field-skills required">
						<label class="control-label" for="skills">Навыки</label>
						<select id="skills" class="form-control" name="skills[]" multiple>
						    <?php foreach ($skills as $skill) { ?>
							<option value="<?= $skill->sid ?>"><?= $skill->name ?></option>
							<?php } ?>
						</select>
					</div>					
					<div class="form-group">
						<button type="submit" class="btn btn-success">Добавить</button>    
					</div>

				</form>
				<?php
				 
				Modal::end();
				?>		
				<br><br>
				<table id="datatable" class="display" style="width:100%">
						<thead>
							<tr>
								<th>Сотрудник</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Сотрудник</th>
								<th>Действие</th>
							</tr>
						</tfoot>
				</table>
            </div>
        </div>

    </div>
	
	<script>	
		var datatable = $('#datatable').DataTable( {
			serverSide: true,
			ajax: "<?= Url::toRoute(['/site/data']) ?>",
			language: {
				lengthMenu:    "Показать _MENU_ записей",
				info:           "",
				infoEmpty:      "",
				infoFiltered:   "",
				search:         "Поиск по имени&nbsp;:",
				loadingRecords: "Загрузка...",
				zeroRecords:    "Пусто",
				emptyTable:     "Пусто",
				paginate: {
					first:      "Первая",
					previous:   "Предыдущая",
					next:       "Следующая",
					last:       "Последняя"
				}
			},
			ordering:  false,
			pagingType: "numbers",
		} );
		
		function delete_item(id)
		{
			var result = confirm("Вы уверены, что хотите удалить этот элемент?");
			if (result) {
				$.ajax({
				  url: "<?= Url::toRoute(['/site/delete']) ?>&id="+id
				}).done(function() {
				  datatable.draw();
				});		
			}			
		}
		
		function add_item()
		{
			$.ajax({
				 url: "<?= Url::toRoute(['/site/add']) ?>"
			}).done(function() {
				 datatable.draw();
			});					
		}
		
		$("#addForm").submit(function(e) {

			e.preventDefault(); // avoid to execute the actual submit of the form.

			var form = $(this);
			var url = form.attr('action');

			$.ajax({
				   type: "POST",
				   url: url,
				   data: form.serialize(), // serializes the form's elements.
				   success: function(data)
				   {
					   if(data.status == 'error') alert(data.error); // show response from the php script.
					   else {
						   datatable.draw();
						   $(".modal").modal('hide');
					   }
				   }
			});

		});
	</script>
	<?php } ?>
</div>
