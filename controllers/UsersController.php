<?php

namespace app\controllers;

use app\models\Microposts;
use app\models\Relationships;
use Yii;
use app\models\Users;
use yii\filters\AccessControl;
use app\models\uersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','update','delete'],
                'rules' => [
                    [
                        'actions' => ['index','update','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
        ];
    }

    /**
     * Lists all users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new uersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $checkAdminArray = Users::find()->select('admin')->where(['userId'=>Yii::$app->user->getId()])->one();
        $checkAdmin = $checkAdminArray->admin;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'checkAdmin' => $checkAdmin
        ]);
    }

    /**
     * Displays a single users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $userId = Yii::$app->user->getId();
        $followCheck = Relationships::find()->where("follower_id = '$userId' and followed_id = '$id'")->count();

        $rows = (new \yii\db\Query())
            ->select(['userName', 'content'])
            ->from('users')
            ->join('INNER JOIN', 'microposts', 'users.userId = microposts.userId')
            ->where('users.userId=:profileId')
            ->addParams([':profileId' => $id])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        $numberOfMicroposts = Microposts::find()->where(['userId'=>$id])->count();

        $row_following = Relationships::find()->where(['follower_id'=>$id])->count();

        $row_followed = Relationships::find()->where(['followed_id'=>$id])->count();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'followCheck' => $followCheck,
            'rows'=>$rows,
            'numberOfMicroposts' => $numberOfMicroposts,
            'row_following' => $row_following,
            'row_followed' => $row_followed
        ]);
    }

    /**
     * Creates a new users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['microposts/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionFollow()
    {
        $userId = Yii::$app->user->identity->getId();
        $relation = new Relationships();
        $relation->follower_id = $userId;
        $relation->followed_id = $_GET['followedId'];
        $relation->save();

        return $this->redirect(['view','id' =>$_GET['followedId']]);
    }

    public function actionUnfollow()
    {
        $userId = Yii::$app->user->identity->getId();
        $followedId = $_GET['followedId'];
        Relationships::deleteAll("follower_id = '$userId' and followed_id = '$followedId'");
        return $this->redirect(['view','id' =>$_GET['followedId']]);
    }

    /**
     * Updates an existing users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($id == Yii::$app->user->identity->getId())
        {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->userId]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
        else
        {
            return Yii::$app->runAction('microposts/index');
        }
    }

    /**
     * Deletes an existing users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $checkAdminArray = Users::find()->select('admin')->where(['userId'=>Yii::$app->user->getId()])->one();
        if ($checkAdminArray->admin)
            $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
