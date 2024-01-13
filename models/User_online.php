<?php

namespace app\models;

use yii\redis\ActiveRecord;

class User_online extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'name'];
    }

    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }

    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }
}

class CustomerQuery extends \yii\redis\ActiveQuery
{
    /**
     * Defines a scope that modifies the `$query` to return only active(status = 1) customers
     */
    public function active()
    {
        return $this->andWhere(['status' => 1]);
    }
}