<?php
class UserController {
    public function getProfile($user) {
        echo json_encode(['id' => $user->id, 'role' => $user->role], JSON_PRETTY_PRINT);
    }
}