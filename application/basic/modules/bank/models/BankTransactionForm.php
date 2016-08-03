<?php

namespace app\modules\bank\models;

use app\modules\bank\services\TransactService;
use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer user_id_donator
 * @property integer $user_id_acceptor
 * @property number $balance
 */
class BankTransactionForm extends \yii\base\Model
{
    public $user_id_donator;
    public $user_id_acceptor;
    public $balance;

    protected $donator;
    protected $acceptor;
    protected $success = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id_donator', 'user_id_acceptor', 'balance'], 'required'],
            [['user_id_donator', 'user_id_acceptor'], 'number'],
            [['user_id_donator', 'user_id_acceptor'], 'compare', 'compareValue'=>0, 'operator'=>'!=', 'message'=>'Выберите пользователя'],
            [['balance'], 'compare', 'compareValue'=>0, 'operator'=>'>', 'message'=>'"'.$this->getAttributeLabel('balance').'" должна быть положительной.'],
            [['balance'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id_donator' => 'Отправитель',
            'user_id_acceptor' => 'Получатель',
            'balance' => 'Перечисляемая сумма',
        ];
    }

    public function transact()
    {
        $this->validateTransaction();
        if ($this->hasErrors())
            return;

        $transaction = $this->donator->getDb()->beginTransaction();
        $this->success = TransactService::transact($transaction, $this->donator, $this->acceptor, $this->balance);
    }
    protected function validateTransaction()
    {
        $this->donator = Users::findOne($this->user_id_donator);
        if (!$this->donator)
            $this->addError('user_id_donator', '"' . $this->getAttributeLabel('user_id_donator') . '" не найден.');
        $this->acceptor = Users::findOne($this->user_id_acceptor);
        if (!$this->acceptor)
            $this->addError('user_id_acceptor', '"' . $this->getAttributeLabel('user_id_acceptor') . '" не найден.');

        $this->validate();
        if ($this->hasErrors())
            return;

        $this->balance = round($this->balance, 2);
        
        if ($this->donator->balance < $this->balance)
            $this->addError('balance', 'Недостаточно средств для перечисления этой суммы.');
    }



    public function getTransactionData()
    {
        return [
            'donator' => $this->donator ? $this->donator->attributes : [],
            'acceptor' => $this->acceptor ? $this->acceptor->attributes : [],
            'balance' => $this->balance,
            'success' => $this->success,
        ];
    }
}
