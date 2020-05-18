<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Payment;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
		if (!Yii::$app->user->identity || !Yii::$app->user->identity->is_admin) return $this->redirect(['/site/login']);
		
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$new_user = new User();
		$new_payment = new Payment();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $new_user,
			'model_payment' => $new_payment,
			'message' => '',
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		if (!Yii::$app->user->identity || !Yii::$app->user->identity->is_admin) return $this->redirect(['/site/login']);
		
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if (!Yii::$app->user->identity || !Yii::$app->user->identity->is_admin) return $this->redirect(['/site/login']);
		
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && !empty(Yii::$app->request->post('User')['password']) && !empty(Yii::$app->request->post('User')['phone'])) {
			
			$ex_user = User::find()
			->where(['phone' => Yii::$app->request->post('User')['phone']])
			->one();
			
			if(!empty($ex_user)) {
				$searchModel = new UserSearch();
				$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
				
				$new_user = new User();
				$new_payment = new Payment();

				return $this->render('index', [
					'searchModel' => $searchModel,
					'dataProvider' => $dataProvider,
					'model' => $new_user,
					'model_payment' => $new_payment,
					'message' => 'Пользователь с таким номером телефона уже существует',
				]);
			}
			
			$model->password = Yii::$app->getSecurity()->generatePasswordHash(Yii::$app->request->post('User')['password']);	
			$model->id = 0;
			if (empty($model->balance)) $model->balance = 0;
            $model->save(); 
			return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		if (!Yii::$app->user->identity || !Yii::$app->user->identity->is_admin) return $this->redirect(['/site/login']);
		
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	 /**
     * Activate user
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionActivate($id)
    {
		if (!Yii::$app->user->identity || !Yii::$app->user->identity->is_admin) return $this->redirect(['/site/login']);
		
		$model = $this->findModel($id);
		$status = $model->status;
		if ($status) $model->status = 0;
		else $model->status = 1;
		$model->save();
		
		return $this->redirect(['index']);
	}

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		if (!Yii::$app->user->identity || !Yii::$app->user->identity->is_admin) return $this->redirect(['/site/login']);
		
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
