<?php

namespace app\controllers;

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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single users model.
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
        $insertRelationship = Yii::$app->db->createCommand()->insert('relationships',[
            'follower_id' => $userId,
            'followed_id' => $_GET['followedId']
        ])->execute();
        return $this->render('view', [
            'model' => $this->findModel($_GET['followedId']),
        ]);
    }

    public function actionUnfollow()
    {
        $userId = Yii::$app->user->identity->getId();
        $deleteRelationship = Yii::$app->db->createCommand()->delete('relationships',[
            'follower_id' => $userId,
            'followed_id' => $_GET['followedId']
        ])->execute();
        return $this->render('view', [
            'model' => $this->findModel($_GET['followedId']),
        ]);
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
        $checkAdmin = (new \yii\db\Query())
            ->select(['admin'])
            ->from('users')
            ->where(['userId' => Yii::$app->user->identity->getId()])
            ->all();
        if ($checkAdmin[0]['admin'])
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
