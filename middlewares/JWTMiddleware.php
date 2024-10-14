<?php
require_once '../helpers/JWT.php';

class JWTMiddleware {
    public static function authenticate() {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            $decoded = JWT::decode($token);
            if ($decoded) {
                return $decoded;
            }
        }
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        exit;
    }
}