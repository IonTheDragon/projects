<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_skills".
 *
 * @property int $id
 * @property int $user_id
 * @property int $skill_id
 */
class UserSkills extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_skills';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'skill_id'], 'required'],
            [['user_id', 'skill_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'skill_id' => Yii::t('app', 'Skill ID'),
        ];
    }
	
		public function getName()
    {
        return $this->hasMany(Skills::className(), ['sid' => 'skill_id']);
    }	
}
