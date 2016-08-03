<?php

namespace app\modules\bank\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $balance
 */
class Users extends \yii\db\ActiveRecord
{
    public $text; // для отображения последнего комментария пользователя
    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'balance'], 'required'],
            [['balance'], 'number'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'balance' => 'Balance',
        ];
    }


    public function getLastComment()
    {
        return $this->hasOne(Comments::className(), ['user_id'=>'id']);
    }
}
