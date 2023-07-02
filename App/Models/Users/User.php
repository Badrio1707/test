<?php

namespace App\Models\Users;

use PDO;

class User extends \Core\Model 
{
    public static function checkUsername($username)
    {
        $sql = 'SELECT * FROM users WHERE username = :username';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public static function checkPassword($username, $password)
    {
        $sql = 'SELECT * FROM users WHERE username = :username';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
            
        if (password_verify($password, $data['password'])) {
            return $data;
        }
        return false;
    }

    public static function updatePassword($username, $password)
    {
        $sql = 'UPDATE users SET password = :password WHERE username = :username';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public static function updateRedirect($redirect)
    {
        $sql = 'UPDATE redirect SET redirect = :redirect WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':redirect', $redirect, PDO::PARAM_STR);
        $stmt->bindValue(':id', 1, PDO::PARAM_INT);
       
        return $stmt->execute();
    }

    public static function checkSession($username)
    {
        $sql = 'SELECT * FROM users WHERE username = :username';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data['username'] == $username) {
            return $data;
        }
        return false;
    }

    public static function checkRequest($username, $request)
    {
        $sql = 'SELECT * FROM requests WHERE username = :username AND url = :request';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':request', $request, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() >= 1) {
            return true;
        } 
        return false;
    }

    public static function createRequest($data, $username)
    {
        $sql = 'INSERT INTO requests (name, amount, description, iban, url, mode, username) VALUES (:name, :amount, :description, :iban, :url, :mode, :username)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':amount', $data['amount'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':iban', $data['iban'], PDO::PARAM_STR);
        $stmt->bindValue(':url', $data['url'], PDO::PARAM_STR);
        $stmt->bindValue(':mode', $data['mode'], PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public static function getUserCount()
    {
        $sql = 'SELECT * FROM users';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public static function getRequestCount($username)
    {
        $sql = 'SELECT * FROM requests WHERE username = :username';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public static function getLogCount($username)
    {
        $sql = 'SELECT * FROM logs WHERE username = :username';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public static function getRequests($username)
    {
        $sql = 'SELECT * FROM requests WHERE username = :username ORDER BY id DESC';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getLogs($username)
    {
        $sql = 'SELECT * FROM logs WHERE username = :username ORDER BY id DESC';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getLog($id, $username)
    {
        $sql = 'SELECT * FROM logs WHERE username = :username AND user_id = :id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function deleteRequest($username, $url) 
    {
        $sql = 'DELETE FROM requests WHERE username = :username AND url = :url';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':url', $url, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public static function deleteRequests($username) 
    {
        $sql = 'DELETE FROM requests WHERE username = :username';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        return $stmt->execute();    
    }

    public static function deleteLog($username, $id) 
    {
        $sql = 'DELETE FROM logs WHERE username = :username AND user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public static function deleteLogs($username) 
    {
        $sql = 'DELETE FROM logs WHERE username = :username';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        return $stmt->execute();    
    }

    public static function banUser($id, $ip)
    {
        $sql = 'DELETE FROM logs WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $sql = 'INSERT INTO bans (ip) VALUES (:ip)';

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':ip', $ip, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                return true;
            } 
            return false;
        }
        return false;
    }

    public static function checkForPayment($id)
    {
        $sql = 'SELECT * FROM logs WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function updateTime($id)
    {
        $date = (new \DateTime())->format('Y-m-d H:i:s');

        $sql = 'UPDATE logs SET last_connected = :connected WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':connected', $date, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
       
        return $stmt->execute();
    }
}
