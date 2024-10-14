<?php

require_once __DIR__ . '/../vendor/autoload.php'; 

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;
use Exception;

class JWT {
    private static $key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwicm9sZSI6ImFkbWluIn0';  // Replace with an actual key, not a JWT token

    public static function encode($payload, $exp = 3600) {
        $payload['exp'] = time() + $exp;  // Set expiration time
        return FirebaseJWT::encode($payload, self::$key, 'HS256');
    }

    public static function decode($token) {
        try {
            // Use the Key class to specify key and algorithm
            return FirebaseJWT::decode($token, new Key(self::$key, 'HS256'));
        } catch (Exception $e) {
            http_response_code(401);  // Unauthorized
            echo json_encode(['error' => 'Invalid token']);
            return false;
        }
    }
}
