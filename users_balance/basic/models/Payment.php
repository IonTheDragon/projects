<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property string $datetime
 * @property string $phone
 * @property float $amount
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datetime'], 'safe'],
            [['phone', 'amount'], 'required'],
            [['amount'], 'number'],
            [['phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'datetime' => Yii::t('app', 'Дата и время'),
            'phone' => Yii::t('app', 'Телефон'),
            'amount' => Yii::t('app', 'Сумма'),
        ];
    }
}
