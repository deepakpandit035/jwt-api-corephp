<?php
require_once '../models/UserModel.php';
require_once '../helpers/JWT.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function login($data) {
        $user = $this->userModel->findByUsername($data['username']);
        if ($user && password_verify($data['password'], $user['password'])) {
            $token = JWT::encode(['id' => $user['id'], 'role' => $user['role']]);
            echo $token;die;
            return json_encode(['token' => $token]);
        }
        return json_encode(['message' => 'Invalid credentials'], JSON_PRETTY_PRINT);
    }

    public function register($data) {
        if ($this->userModel->create($data['username'], $data['password'])) {
            return json_encode(['message' => 'User registered successfully'], JSON_PRETTY_PRINT);
        }
        return json_encode(['message' => 'User registration failed'], JSON_PRETTY_PRINT);
    }
}