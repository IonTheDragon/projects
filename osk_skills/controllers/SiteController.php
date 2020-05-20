<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\Users;
use app\models\UserSkills;
use app\models\Skills;
use app\models\City;
use app\models\NamesCollection;

use yii\helpers\Url; 

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
                        'actions' => ['logout', 'data', 'delete'],
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
    public function actionIndex()
    {	
		$cities = [];
		$skills = [];
		if (!Yii::$app->user->isGuest)	
		{
			$cities = City::find()->all();
			$skills = Skills::find()->all();
		}
		
        return $this->render('index', ['cities' => $cities, 'skills' => $skills]);
    }
	
    /**
     * Return users data.
     *
     * @return json
     */
    public function actionData()
    {
		if (Yii::$app->user->isGuest) return;
			
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$query = Users::find();
		
		$query->with(['skills.name', 'city']);
		
		if (!empty(Yii::$app->request->get('search')['value'])) $query->where(['name' => Yii::$app->request->get('search')['value']]);
			

		$users = $query->orderBy('id')
			->offset(Yii::$app->request->get('start'))
			->limit(Yii::$app->request->get('length'))
			->all();
			
		$data = [];	

		foreach ($users as $user)
		{		
				$item = $user->name.". Место жительства: ".$user->city[0]->name.". Навыки: ";
				 
				if (empty($user->skills)) $item .= 'Нет';
				else
				{
					$lastKey = array_key_last($user->skills);
					foreach ($user->skills as $key => $skill)
					{
						$item .= $skill->name[0]->name;
						if($key != $lastKey) $item .= ', ';																				
					}
				}
				$data[] = [$item, '<a onClick="delete_item('.$user->id.')" title="Удалить" aria-label="Удалить"><span class="glyphicon glyphicon-trash"></span></a>'];
		}
		
		return ['data' => $data];

	}	

    /**
     * Delete action.
     *
     * @return json
     */	
	public function actionDelete()
    {
		if (Yii::$app->user->isGuest) return;
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$user = Users::findOne(Yii::$app->request->get('id'));
		if (!empty($user)) $user->delete();
		
		UserSkills::deleteAll(['user_id' => Yii::$app->request->get('id')]);
		
		return ['status' => 'ok', 'id' => Yii::$app->request->get('id')];
	}
	
	 /**
     * Add action.
     *
     * @return json
     */	
	public function actionAdd()
    {
		if (Yii::$app->user->isGuest) return;
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$cities = City::find()->all();
		$ckeys = [];
		
		foreach ($cities as $city)
		{
			$ckeys[] = $city->cid;
		}
		
		$city_id = $ckeys[array_rand($ckeys, 1)];
		
		$names = NamesCollection::find()->all();
		$nvals = [];
		
		foreach ($names as $name)
		{
			$nvals[] = $name->name;
		}

		$nval = $nvals[array_rand($nvals, 1)];

		$skills = Skills::find()->all();
		$skeys = [];
		
		foreach ($skills as $skill)
		{
			$skeys[] = $skill->sid;
		}
		
		$skills_num = rand(0, 3);
		
		$skill_ids = null;
		if (!empty($skills_num)) $skill_ids = array_rand($skeys, $skills_num);

		$new_user = new Users();
		$new_user->name = $nval;		
		$new_user->city_id = $city_id;
		$new_user->save();
		$insert_id = $new_user->id;
		
		if (!empty($skill_ids))
		{
			if (is_array($skill_ids))
			{
				foreach ($skill_ids as $skill_id)
				{
					$new_uskill = new UserSkills();
					$new_uskill->user_id = $insert_id;
					$new_uskill->skill_id = $skeys[$skill_id];
					$new_uskill->save();			
				}
			}
			else
			{
				$new_uskill = new UserSkills();
				$new_uskill->user_id = $insert_id;
				$new_uskill->skill_id = $skeys[$skill_ids];
				$new_uskill->save();				
			}
		}
		
		return ['status' => 'ok', 'id' => $insert_id, 'name' => $nval, 'city_id' => $city_id, 'skills' => $skill_ids];
	}
	
	/**
     * Custom add action.
     *
     * @return json
     */	
	public function actionCustomAdd()
    {
		if (Yii::$app->user->isGuest) return;
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$name = Yii::$app->request->post('name');
		$city = Yii::$app->request->post('city');
		$skills = Yii::$app->request->post('skills');
		
		if (empty($name)) return ['status' => 'error', 'error' => 'Введите имя'];
		
		$new_user = new Users();
		$new_user->name = $name;		
		$new_user->city_id = $city;
		$new_user->save();
		$insert_id = $new_user->id;
		
		if (!empty($skills))
		{		
			foreach ($skills as $skill)
			{
				$new_uskill = new UserSkills();
				$new_uskill->user_id = $insert_id;
				$new_uskill->skill_id = $skill;
				$new_uskill->save();			
			}		
		}
		
		return ['status' => 'ok', 'id' => $insert_id, 'name' => $name, 'city_id' => $city, 'skills' => $skills];
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
