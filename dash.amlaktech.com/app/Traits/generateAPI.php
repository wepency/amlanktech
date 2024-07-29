<?php

namespace App\Traits;

trait generateAPI
{
    public function success($data = null, $message = null){
        if (is_array($data)){
            if (empty($data))
                $data = null;
        }

        if (is_array($message)){
            if (empty($message))
                $message = null;
        }

        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => true
        ]);
    }

    public function error($errors = null, $message = null, $code = 403, $blocked = false, $flatten = true){
        if (is_array($errors)){
            if (empty($errors))
                $errors = null;
        }

        if ($message == '')
            $message = null;

        $errors = is_array($errors) || is_null($errors) || gettype($errors) == 'string' ? $errors : $errors->toArray();

        return response()->json([
            'errors' => $flatten ? $this->array_flatten($errors) : $errors,
            'message' => $message,
            'is_blocked' => $blocked,
            'success' => false
        ], $code);
    }

    protected function array_flatten($array) {
        $return = array();

        if (is_array($array)){
            foreach ($array as $key => $value) {
                if (is_array($value)){ $return = array_merge($return, $this->array_flatten($value));}
                else {$return[] = $value;}
            }
        }

        return empty($return) ? null : $return;
    }

    protected function pagination_links($query) : array {
        return [
            'from' => $query?->firstItem(),
            'to' => $query?->lastItem(),
            'total' => $query->total(),
            'per_page' => $query?->perPage(),
            'current_page' => $query->currentPage(),
            'last_page' => $query?->lastPage(),
            "next_page_url" => $query?->nextPageUrl(),
            "previous_page_url" => $query?->previousPageUrl()
        ];
    }
}
