<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Task manager';
?>
<div class="site-index">

    <h1>Task manager</h1>

    <p class="lead">Tables with users and their tasks</p>

    <div class="body-content">
		<?= yii\bootstrap4\Tabs::widget(['items' => [
          [
              'label' => 'Tasks',
              'content' => $this->render('tasks', ['tasks' =>$tasks, 'pagination_tasks' => $pagination_tasks]),
              'active' => true
          ],
          [
              'label' => 'Users',
              'content' => $this->render('workers', ['persons' =>$persons, 'pagination' => $pagination]),
          ],
         ]]) ?>                          
    </div>
    
<div id="newform"></div>

<script type="text/javascript">
	
function add_task_form()
 {

  $.ajax({
   type: 'POST',
   url: '<?php echo Url::to(['site/addtaskform']) ?>',
   update: '#newform',
   dataType:'html',
   success:function(data){
                $('#newform').html(data); 
                $(".body-content").css("display","none");
   },
   error:function(data){
                alert("error");
   },   
  }); 
}
	
function edit_task_form(data)
 {

  $.ajax({
   type: 'POST',
   url: '<?php echo Url::to(['site/edittaskform']) ?>',
   update: '#newform',
   data:{edit_task_id:data},
   dataType:'html',
   success:function(data){
                $('#newform').html(data); 
                $(".body-content").css("display","none");
   },
   error:function(data){
                alert("error");
   },   
  }); 
}

function delete_task(data)
 {

  $.ajax({
   type: 'POST',
    url: '<?php echo Url::to(['site/deletetask']) ?>',
   data:{delete_task_id:data},
   dataType:'html',
   success:function(data){
                alert(data); 
                document.location.reload(true);
   },
   error:function(data){
                alert("error");
   },   
  }); 
}

function add_person_form()
 {

  $.ajax({
   type: 'POST',
   url: '<?php echo Url::to(['site/addpersonform']) ?>',
   update: '#newform',
   dataType:'html',
   success:function(data){
                $('#newform').html(data); 
                $(".body-content").css("display","none");
   },
   error:function(data){
                alert("error");
   },   
  }); 
}

function edit_person_form(data)
 {

  $.ajax({
   type: 'POST',
   url: '<?php echo Url::to(['site/editpersonform']) ?>',
   update: '#newform',
   data:{edit_person_id:data},
   dataType:'html',
   success:function(data){
                $('#newform').html(data); 
                $(".body-content").css("display","none");
   },
   error:function(data){
                alert("error");
   },   
  });

}

function delete_person(data)
 {

  $.ajax({
   type: 'POST',
    url: '<?php echo Url::to(['site/deleteperson']) ?>',
   data:{delete_person_id:data},
   dataType:'html',
   success:function(data){
                alert(data); 
                document.location.reload(true);
   },
   error:function(data){
                alert("error");
   },   
  }); 
}

</script>    
    
</div>
