<?php

namespace App\Http\Requests;

trait BaseRequest
{
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            /**
             * If request is to API, dispatch exception
             */
            if (\Request::is('api/*')) {
                if ($validator->errors()->count()) {
                    session()->flash("validator_errors", $validator->errors());
                    throw new \App\Exceptions\Api\InvalidDataException();
                }
            }
        });
    }
}
