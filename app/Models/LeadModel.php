<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;
use Config\Database;

class LeadModel extends Model
{
    protected $table = 'lead';

    function saveLead($data, $timestamp)
    {
        $db = Database::connect();

        $timestamp = $db->escape($timestamp);

        $sql = "INSERT INTO lead (name, phone, address, email, note, created_at, updated_at) VALUES (" . $db->escape($data['0']) . ", " . $db->escape($data['1']) . ", " . $db->escape($data['2']) . ", " . $db->escape($data['3']) . ", " . $db->escape($data['4']) . ", " . $timestamp . ", " . $timestamp . ")";

        return $db->query($sql);
    }

    function getLead($search)
    {
        $db = Database::connect();
        $sql = 'SELECT * FROM lead WHERE phone=' . $db->escape($search);
        $query = $db->query($sql);
        $result = $query->getResultArray();

        if (empty($result)) {
            return ['status' => false, 'message' => "Data not found."];
        } else {
            return ['status' => true, 'data' => $result];
        }
    }
}
