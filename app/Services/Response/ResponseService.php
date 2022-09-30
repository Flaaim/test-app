<?php 

namespace App\Services\Response;

class ResponseService 
{
    private static function ResponseParams($status, $errors = [], $data = []){
        return [
            'status' => $status,
            'errors' => (object)$errors,
            'data' => (object)$data,
        ];
    }

    public static function sendJsonResponse($status, $code, $errors = [], $data = []){
        return response()->json(
            self::ResponseParams($status, $errors, $data), $code
        );
    }

    public static function success(){
        return self::sendJsonResponse(true, 200, [], []);
    }
}