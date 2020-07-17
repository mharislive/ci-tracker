<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;
use Config\Database;

class UserModel extends Model
{
    protected $table = 'user';

    function hashPassword($password)
    {
        $options = [
            'cost' => 11
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    function verifyPassword($password, $hash)
    {
        if (password_verify($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }

    function verifyUser($username, $password)
    {
        $db = Database::connect();
        $sql = 'SELECT * FROM user WHERE username=' . $db->escape($username);
        $query = $db->query($sql);
        $row = $query->getRowArray();

        if (empty($row)) {
            return ['status' => false, 'message' => "Username doesn't exists."];
        } else {
            if ($this->verifyPassword($password, $row['password'])) {
                return ['status' => true, 'data' => $row];
            } else {
                return ['status' => false, 'message' => "Username or password is incorrect."];
            }
        }
    }

    function registerUser($data)
    {
        $db = Database::connect();
        $password = $this->hashPassword($data['password']);

        $sql = "INSERT INTO user (username, password, role) VALUES (" . $db->escape($data['username']) . ", " . $db->escape($password) . ", " . $db->escape($data['role']) . ")";

        return $db->query($sql);
    }
}
