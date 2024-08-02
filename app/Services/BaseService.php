<?php

namespace App\Services;

abstract class BaseService
{
    /**
     * Create a new model
     * @param array $validated validated data
     * @return null|\Illuminate\Database\Eloquent\Model the new created model or null on fail
     */
    abstract static function create(array $validated = []): null|\Illuminate\Database\Eloquent\Model;

    /**
     * Update a model
     * @param mixed $model
     * @param array $validated validated data
     * @return null|\Illuminate\Database\Eloquent\Model the updated model or null on fail
     */
    abstract static function update(mixed $model, array $validated = []): null|\Illuminate\Database\Eloquent\Model;
}
