<?php

namespace yii2mod\rbac\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii2mod\rbac\models\BizRuleModel;
use yii2mod\rbac\models\search\BizRuleSearch;

/**
 * Class RuleController
 *
 * @package yii2mod\rbac\controllers
 */
class RuleController extends Controller
{
    /**
     * @var string search class name for rules search
     */
    public $searchClass = [
        'class' => BizRuleSearch::class,
    ];

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * List of all rules
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Yii::createObject($this->searchClass);
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new Rule item.
     *
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BizRuleModel();
        $model->className = 'yii2mod\rbac\rules\UserRule';
        
        return Yii::$app->sr->record->updateModel($model);
    }

    /**
     * Updates an existing Rule item.
     *
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionUpdate(string $id)
    {
        $model = $this->findModel($id);
        
        if ($model) {
            $model->className = 'yii2mod\rbac\rules\UserRule';
            
            return Yii::$app->sr->record->updateModel($model);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Deletes an existing Rule item.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionDelete(string $id)
    {
        $model = $this->findModel($id);
        Yii::$app->authManager->remove($model->item);
        Yii::$app->session->addFlash('success', Yii::t('yii2mod.rbac', 'Rule has been deleted.'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the BizRuleModel based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return BizRuleModel the loaded model
     *
     * @throws \yii\web\NotFoundHttpException
     */
    protected function findModel(string $id)
    {
        $item = Yii::$app->authManager->getRule($id);

        if (!empty($item)) {
            return new BizRuleModel($item);
        }

        throw new NotFoundHttpException(Yii::t('yii2mod.rbac', 'The requested page does not exist.'));
    }
}
