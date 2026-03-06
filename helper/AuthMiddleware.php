<?php

require_once __DIR__ . '/JWTService.php';

class AuthMiddleware {

    public static function check()
    {
        if (!isset($_COOKIE['token'])) {
            return [
                "status" => false,
                "message" => "Token missing"
            ];
        }

        $decoded = JWTService::validate($_COOKIE['token']);

        if (!$decoded) {
            return [
                "status" => false,
                "message" => "Invalid token"
            ];
        }
        /* Refresh token automatically */
        $newToken = JWTService::generate([
            "id"=>$decoded->data->id,
            "role" => 'admin_id',
            "name"=>$decoded->data->name
            ]);
            
        setcookie("token",$newToken,[
            "expires"=>time()+900,
            "path"=>"/",
            "httponly"=>true,
            "secure" => false, // true if using https
            "samesite" => "Lax"
            ]);    
    
    
        return [
            "status" => true,
            "user" => $decoded
        ];
    }
}
