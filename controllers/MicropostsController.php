<?php

namespace app\controllers;

use app\models\Relationships;
use Yii;
use app\models\Microposts;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MicropostsController implements the CRUD actions for Microposts model.
 */
class MicropostsController extends Controller
{
    public $rows,$numberOfMicroposts,$row_following,$row_followed;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','update','create','delete','ajax-index'],
                'rules' => [
                    [
                        'actions' => ['index','update','create','delete','ajax-index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public  function reloadMicroRows()
    {
        $userId = Yii::$app->user->identity->getId();
        $ids = Relationships::find()->select('followed_id')->where(['follower_id' => $userId])->all();
        $newIds = array();
        foreach ($ids as $id)
            array_push($newIds,$id->followed_id);

        return (new \yii\db\Query())
            ->select(['userName', 'content'])
            ->from('users')
            ->join('INNER JOIN', 'microposts', 'users.userId = microposts.userId')
            ->where(['or', 'users.userId=:userId', ['users.userId' => $newIds]])
            ->addParams([':userId' => $userId])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }

    public function actionAjaxIndex()
    {
        $request = Yii::$app->request;
        $userId = Yii::$app->user->identity->getId();
        $content = $request->post('content');
        $micropost = new Microposts();
        $micropost->userId = $userId;
        $micropost->content = $content;
        if($micropost->save(false))
            echo $content;
    }

    /**
     * Lists all Microposts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Microposts();
        $userId = Yii::$app->user->identity->getId();

        //For micropost creation
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            $rows = $this->reloadMicroRows();

            $numberOfMicroposts = Microposts::find()->where(['userId'=>$userId])->count();

            $row_following = Relationships::find()->where(['follower_id'=>$userId])->count();

            $row_followed = Relationships::find()->where(['followed_id'=>$userId])->count();

            return $this->render('index', ['model' => $model,
                'rows' => $rows,
                'numberOfMicroposts' => $numberOfMicroposts,
                'row_following' => $row_following,
                'row_followed' => $row_followed]);
        }

        $rows = $this->reloadMicroRows();

        $numberOfMicroposts = Microposts::find()->where(['userId'=>$userId])->count();

        $row_following = Relationships::find()->where(['follower_id'=>$userId])->count();

        $row_followed = Relationships::find()->where(['followed_id'=>$userId])->count();

        return $this->render('index',['model' => $model,'rows' => $rows,
            'numberOfMicroposts' => $numberOfMicroposts,
            'row_following' => $row_following,
            'row_followed' => $row_followed]);
        /*else
            return $this->render('index',['model' => $model]);*/
    }

    /**
     * Displays a single Microposts model.
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
     * Creates a new Microposts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->render('index');
    }

    /**
     * Updates an existing Microposts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Deletes an existing Microposts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Microposts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Microposts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Microposts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
