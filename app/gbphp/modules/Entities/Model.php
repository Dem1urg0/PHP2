<?php

namespace App\modules\Entities;

/**
 * Class Model (сущность)
 */
abstract class Model
{
    public function filling($params)
    {
        foreach ($params as $param => $value) {
            if (property_exists($this, $param)) {
                $this->$param = $value;
            }
        }
    }

    public function checkFillParams($params = ['id', 'name', 'price'])
    {
        foreach ($params as $param) {
            if (empty($this->$param)) {
                return false;
            }
        }
        return true;
    }
    public function checkParams($param)
    {
        if ($param == 'bd' || $param == 'names' || $param == 'values' || $param == 'params') {
            return true;
        } else {
            return false;
        }
    }
}
