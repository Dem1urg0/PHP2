<?php

namespace engine;

interface IDB
{
    public function getAll();

    public function getOne($id);

    public function delete($id);

    public function update($id, $fields, $values);

    public function insert($fields, $values);
}