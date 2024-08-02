<?php

namespace App\Http\Controllers\Api;

trait WithFilter
{
    /**
     * Default limit
     * @var int
     */
    public int $defaultLimit = 15;

    /**
     * Apply filter
     * @param string $modelClass
     * @param array $filterData
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    function applyFilter(string $modelClass, array $filterData, array $searchableFields = [])
    {
        /**
         * @param \Illuminate\Database\Eloquent\Model $modelInstance
         */
        $modelInstance = new $modelClass();

        /**
         * Search
         */
        if (!empty($filterData['search']) && count($searchableFields) > 0) {
            $modelInstance = $modelInstance::whereRaw("MATCH(" . implode(', ', $searchableFields) . ") AGAINST(? IN BOOLEAN MODE)", $filterData['search']);
        }

        return $modelInstance->paginate(
            empty($filterData['limit']) ? $this->defaultLimit : $filterData['limit']
        )->withQueryString();
    }

    /**
     * Get validated filter inputs
     * @param array $rules rules for validation
     * @param array $data data to validate
     * @return array validated data
     */
    function getValidatedFilterInputs(array $rules = [], array $data = [])
    {
        return \Validator::make($data, $rules)->valid();
    }
}
