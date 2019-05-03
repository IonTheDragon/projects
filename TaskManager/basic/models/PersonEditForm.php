<?php

namespace app\models;

use yii\base\Model;

class PersonEditForm extends Model
{
    public $id;
    public $name;
    public $occupation;

    public function rules()
    {
        return [
            [['id', 'name', 'occupation'], 'required'],
        ];
    }
}
?>
