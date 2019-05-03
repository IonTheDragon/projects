<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Person;
use app\models\Task;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionAddtaskform()
    {
		if(!Yii::$app->user->isGuest)
		{
			$query = Person::find();
			$persons = $query->all();	
			$access = "1";
		}	
		else $access = "0";
        return $this->renderAjax('addtaskajax', [
            'persons' => $persons, 
            'access' => $access,          
        ]);		   	
	}      
    public function actionEdittaskform()
    {
		if(isset($_POST['edit_task_id'])&&!Yii::$app->user->isGuest)
		{
			$task_id = $_POST['edit_task_id'];
			$task = Task::findOne($task_id);
			$task_user = $task->user;
			$task_title = $task->title;
			$task_status = $task->status;		
			$task_description = $task->description;	
			$params = array($task_id,$task_user,$task_title,$task_status,$task_description);
			$query = Person::find();
			$persons = $query->all();
			$access = "1";				
		}	
		else $access = "0";
        return $this->renderAjax('edittaskajax', [
            'params' => $params,
            'persons' => $persons,
            'access' => $access,         
        ]);		   	
	} 
    public function actionAddpersonform()
    {
		if(!Yii::$app->user->isGuest)
		{
			$access = "1";	
		}	
		else $access = "0";
        return $this->renderAjax('addpersonajax', [
            'access' => $access,          
        ]);		   	
	} 	
    public function actionEditpersonform()
    {
		if(isset($_POST['edit_person_id'])&&!Yii::$app->user->isGuest) {
			$person_id = $_POST['edit_person_id'];
			$person = Person::findOne($person_id);
			$person_name = $person->name;
			$person_occupation = $person->occupation;	
			$params = array($person_id,$person_name,$person_occupation);
			$access = "1";					
		}	
		else $access = "0";
        return $this->renderAjax('editpersonajax', [
            'params' => $params,    
            'access' => $access,      
        ]);		   	
	}	
    public function actionAddtask()
    {
		if(isset($_POST)&&!Yii::$app->user->isGuest)
		{
			$i = 0;	
			$elements = [];		
			foreach ($_POST as $element) {
				$elements[$i] = $element;
				$i++;
			}			
			$user = $elements[0];
			$title = $elements[1];
			$status = $elements[2];
			$description = $elements[3];
			$task = new Task;	
			$task->user = $user;
			$task->title = $title;			
			$task->status = $status;
			$task->description = $description;	
			$result = $task->save();
			if ($result) 
			{
				$out_arr = array('id' => $task->id, '$title' => $title, 'user' => $user, 'status' => $status, 'description' => $description, 'message' => 'added');				
			}	
			else $out_arr = array('message' => 'error');				
		}	
		else $out_arr = array('message' => 'access denied');
		$output = json_encode($out_arr);
        return $output;         		   	
	} 	
    public function actionEdittask()
    {
		if(isset($_POST)&&!Yii::$app->user->isGuest)
		{
			$i = 0;	
			$elements = [];		
			foreach ($_POST as $element) {
				$elements[$i] = $element;
				$i++;
			}			
			$id = $elements[0];
			$title = $elements[2];
			$user = $elements[1];
			$status = $elements[3];
			$description = $elements[4];
			$task = Task::findOne($id);	
			$task->title = $title;
			$task->user = $user;
			$task->status = $status;
			$task->description = $description;	
			$result = $task->save();
			if ($result) 
			{
				$out_arr = array('id' => $id, '$title' => $title, 'user' => $user, 'status' => $status, 'description' => $description, 'message' => 'updated');				
			}	
			else $out_arr = array('message' => 'error');				
		}	
		else $out_arr = array('message' => 'access denied');
		$output = json_encode($out_arr);
        return $output;         		   	
	} 
    public function actionDeletetask()
    {
		if(isset($_POST['delete_task_id'])&&!Yii::$app->user->isGuest)
		{		
			$id = $_POST['delete_task_id']; 	
			$task = Task::findOne($id);
			$title = $task->title;
			$user = $task->user;
			$status = $task->status;
			$description = $task->description;						
			$result = $task->delete();
			if ($result) 
			{
				$out_arr = array('id' => $id, '$title' => $title, 'user' => $user, 'status' => $status, 'description' => $description, 'message' => 'deleted');				
			}	
			else $out_arr = array('message' => 'error');				
		}	
		else $out_arr = array('message' => 'access denied');
		$output = json_encode($out_arr);
        return $output;         		   	
	} 	
    public function actionAddperson()
    {
		if(isset($_POST)&&!Yii::$app->user->isGuest)
		{
			$i = 0;	
			$elements = [];		
			foreach ($_POST as $element) {
				$elements[$i] = $element;
				$i++;
			}			
			$name = $elements[0];
			$occupation = $elements[1];
			$person = new Person;	
			$person->name = $name;
			$person->occupation = $occupation;				
			$result = $person->save();
			if ($result) 
			{
				$out_arr = array('id' => $person->id, 'name' => $name, 'occupation' => $occupation, 'message' => 'added');				
			}	
			else $out_arr = array('message' => 'error');				
		}	
		else $out_arr = array('message' => 'access denied');
		$output = json_encode($out_arr);
        return $output;         		   	
	}		
    public function actionEditperson()
    {
		if(isset($_POST)&&!Yii::$app->user->isGuest)
		{
			$i = 0;	
			$elements = [];		
			foreach ($_POST as $element) {
				$elements[$i] = $element;
				$i++;
			}			
			$id = $elements[0];
			$name = $elements[1];
			$occupation = $elements[2];
			$person = Person::findOne($id);	
			$person->name = $name;
			$person->occupation = $occupation;
			$result = $person->save();
			
			if ($result) 
			{
				$out_arr = array('id' => $id, 'name' => $name, 'occupation' => $occupation, 'message' => 'updated');				
			}	
			else $out_arr = array('message' => 'error');				
		}	
		else $out_arr = array('message' => 'access denied');
		$output = json_encode($out_arr);
        return $output;         		   	
	}
    public function actionDeleteperson()
    {
		if(isset($_POST['delete_person_id'])&&!Yii::$app->user->isGuest)
		{			
			$id = $_POST['delete_person_id'];
			$person = Person::findOne($id);
			$name = $person->name;
			$occupation = $person->occupation;					
			$result = $person->delete();
			if ($result) 
			{
				$out_arr = array('id' => $id, 'name' => $name, 'occupation' => $occupation, 'message' => 'deleted');			
			}	
			else $out_arr = array('message' => 'error');				
		}	
		else $out_arr = array('message' => 'access denied');
		$output = json_encode($out_arr);
        return $output;         		   	
	} 	 	    
    public function actionIndex()
    {
		$query = Person::find();
		$query_tasks = Task::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
         $pagination_tasks = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query_tasks->count(),
        ]);       

        $persons = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $tasks = $query_tasks->orderBy('user')
            ->offset($pagination_tasks->offset)
            ->limit($pagination_tasks->limit)
            ->all();         
            
        return $this->render('index', [
            'persons' => $persons,
            'tasks' => $tasks,
            'pagination' => $pagination,
            'pagination_tasks' => $pagination_tasks,           
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
