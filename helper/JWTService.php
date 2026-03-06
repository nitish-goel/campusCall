<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService {

    private static function getSecret() {                       
        $JWT_secret = $_ENV['JWT_SECRET']; // from .env
        return $JWT_secret; 
    }
    public static function generate($user) {

        $payload = [
            "iss" => "CampusFeedback",
            "iat" => time(),
            "exp" => time() + 900,
            "data" => [
                "id" => $user['id'],
                "role" => 'admin_id',
                "name" => $user['username']
            ]
        ];

        return JWT::encode($payload, self::getSecret(), 'HS256');
    }

    public static function validate($token) {
        try {
            return JWT::decode($token, new Key(self::getSecret(), 'HS256'));
        } catch (Exception $e) {
            return false;
        }
    }
}