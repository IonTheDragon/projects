<?php

namespace app\models;

use yii\base\Model;

class TaskEditForm extends Model
{
    public $id;
    public $name;
    public $status;
    public $description;

    public function rules()
    {
        return [
            [['id', 'user', 'status', 'description'], 'required'],
        ];
    }    
}
?>
