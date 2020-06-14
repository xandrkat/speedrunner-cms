<?php

namespace backend\modules\User\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\User\models\User;
use backend\modules\User\modelsSearch\UserSearch;


class UserController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new UserSearch);
    }
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new User);
    }
    
    public function actionUpdate($id)
    {
        $model = User::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new User);
    }
    
    public function actionItemsList($q = '', $role = null)
    {
        $cond = $role ? ['role' => $role] : [];
        $out['results'] = User::itemsList('username', 'self', 20, $q);
        return $this->asJson($out);
    }
}
