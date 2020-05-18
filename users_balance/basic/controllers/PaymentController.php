<?php

namespace app\controllers;

use Yii;
use app\models\Payment;
use app\models\PaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\User;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
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
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
		if (!Yii::$app->user->identity || !Yii::$app->user->identity->is_admin) return $this->redirect(['/site/login']);
		
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$new_payment = new Payment();
		
		$total = Payment::find()->sum('amount');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'model' => $new_payment,
			'total' => $total,
        ]);
    }

    /**
     * Displays a single Payment model.
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
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if (!Yii::$app->user->identity || !Yii::$app->user->identity->is_admin) return $this->redirect(['/site/login']);
		
        $model = new Payment();

        if ($model->load(Yii::$app->request->post()) && !empty(Yii::$app->request->post('Payment')['phone'])) {
			
			//Проверка доступности пользователя
			
			$user = User::find()
			->where(['phone' => Yii::$app->request->post('Payment')['phone']])
			->one();

			if (empty($user) || !$user->status)
			{
				$searchModel = new PaymentSearch();
				$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
				
				$new_payment = new Payment();

				return $this->render('create', [
					'model' => $model,
					'message' => 'Нельзя пополнить баланс',
				]);
			}	
			
			if(!empty(Yii::$app->request->post('Payment')['amount']))
			{
				$balance = $user->balance;
				$balance += Yii::$app->request->post('Payment')['amount'];
				$user->balance = $balance;
				$user->save();	
			}
			
			if(empty(Yii::$app->request->post('Payment')['datetime'])) $model->datetime = date('Y-m-d H:i');

			$model->save();			
			
            return $this->redirect(['index']);
        }
		
		return $this->render('create', [
            'model' => $model,
			'message' => '',
        ]);

        //return $this->redirect(['index']);
    }

    /**
     * Updates an existing Payment model.
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
     * Deletes an existing Payment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		if (!Yii::$app->user->identity || !Yii::$app->user->identity->is_admin) return $this->redirect(['/site/login']);
		
		$payment = $this->findModel($id);
		if(empty($payment)) return $this->redirect(['index']);
		
		$user = User::find()
			->where(['phone' => $payment->phone])
			->one();

		if (!empty($user)) 
		{
			$balance = $user->balance;
			$balance -= $payment->amount;
			$user->balance = $balance;
			$user->save();
		}
		
        $payment->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
