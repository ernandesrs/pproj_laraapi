<?php

namespace App\Exceptions\Api;

trait BaseException
{
    /**
     * Response message
     * @return string
     */
    abstract function message(): string;

    /**
     * Status code
     * @return int
     */
    abstract function status(): int;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        $response = [
            "success" => false,
            "error" => class_basename($this),
            "message" => $this->message(),
        ];

        if ($errors = session()->get("validator_errors", null)) {
            $response += [
                'errors' => $errors
            ];
        }

        return response()->json($response, $this->status());
    }
}
