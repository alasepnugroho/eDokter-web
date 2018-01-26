<?php

namespace backend\controllers;

use Yii;
use app\models\UserManajemen;
use app\models\search\UserManajemenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\SignupForm;
use common\models\Staff;

/**
 * UserManajemenController implements the CRUD actions for UserManajemen model.
 */
class UserManajemenController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view','inactive','create','delete','active','update'],
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
     * Lists all UserManajemen models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserManajemenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = [
            'pageSize' => 8
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserManajemen model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserManajemen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $modelStaff = new Staff();
                $modelStaff->user_id = $user->id;
                $modelStaff->save();
                return $this->redirect(['index']);
            }
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }       
    }

     /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->session->setFlash('info', 'Update Data Successfully');
            return $this->redirect(['staff/view', 'id' => $model->id]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }
    
    /**
     * Deletes an existing UserManajemen model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Change status user to inactive
     * @param integer $id
     * @return mixed
     */
    public function actionInactive($id = null)
    {
        if ($id != null){
            $model = $this->findModel($id);
            $model->status = 0;
            if ($model->save()){
                return $this->redirect(['index']);
            }else{
                print_r($model->getErrors());
            }           
        }else{
            $model = $this->findModel(\Yii::$app->user->identity->id);
            $model->status = 0;
            $model->save();
            if ($model->save()){
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('info','Account inactive');
                return $this->goHome();
            }
        }
       
    }

    /**
     * Change status user to Active
     * @param integer $id
     * @return mixed 
     */
    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->status = 10;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserManajemen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserManajemen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserManajemen::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionResetPassword()
    {
        //set up user and load past data
        $user = Yii::$app->user->identity;
        $loadedPost = $user->load(Yii::$app->request->post());
        
        //validate for normal request
        if ($loadedPost && $user->validate()){
            $user->password = '123456';
            //save,set flash & refresh page
            $user->save(false);
            Yii::$app->session->setFlash('success','you have successfully reset password');
            return $this->refresh();
        }
        return $this->render("resetpassword", ['user' => $user,]);
    }

}
