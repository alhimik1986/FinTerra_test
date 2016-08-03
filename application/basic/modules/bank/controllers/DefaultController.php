<?php

namespace app\modules\bank\controllers;

use Yii;
use yii\web\Controller;
use app\modules\bank\models\SearchUsers;
use app\modules\bank\models\Users;
use app\modules\bank\models\BankTransactionForm;


class DefaultController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new SearchUsers();
        $dataProvider = $searchModel->searchWithLastComments(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearchUser($term)
    {
        $results = [];
        $query = Users::find();

        if (is_numeric($term)) {
            $query->orFilterWhere([
                'id' => $term,
            ]);
        }

        if (is_string($term)) {
            $query->orFilterWhere(['like', 'name', $term]);
            //$query->orFilterWhere(['like', 'email', $term]);
        }

        foreach($query->asArray()->limit(10)->all() as $model) {
            $results[] = [
                'id' => $model['id'],
                'label' => $model['name'] . ' (id: ' . $model['id'] . ') - баланс: '.$model['balance'].' р.',
            ];
        }

        echo json_encode($results);
    }

    
    public function actionTransactionForm()
    {
        return $this->render('transactionForm', ['model'=>new BankTransactionForm]);
    }
    public function actionTransact()
    {
        if (Yii::$app->request->isPost) {
            $model = new BankTransactionForm;
            $model->load(Yii::$app->request->post());
            $model->transact();
            
           return  $this->render('transact', ['model'=>$model, 'data'=>$model->getTransactionData()]);
        }
    }
}
