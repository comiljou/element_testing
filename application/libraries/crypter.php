<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__).'/phpseclib');
require('phpseclib/Crypt/RSA.php');


class crypter {
    const private_key_name = 'private.key';
    const public_key_name = 'public.key';
    private $path = ""; // path to keys folder

    public function __construct() {
        $ci =& get_instance();
        $ci->config->load('crypter');
        $this->path = $ci->config->item('keys_folder');;
    }

    public function generateKeys()
    {
        $path = $this->path;

        if(empty($path))
        {
            trigger_error('crypter :: generateKeys - Path for key generation is empty', E_USER_WARNING);
            return false;
        }

        $rsa = new Crypt_RSA();

        $keys = $rsa->createKey();
        if(is_dir($path))
        {
            $private_file_path = $path . '/' . self :: private_key_name;
            if(!file_put_contents($private_file_path, $keys['privatekey']))
            {
                return  'Unable to write private key, possibly "' . $path .'" folder is write protected';
            }

            $public_file_path = $path.'/'. self :: public_key_name;
            if(!file_put_contents($public_file_path, $keys['publickey']))
            {
                return  'Unable to write public key, possibly "' . $path .'" folder is write protected';
            }
        }
        else
        {
            trigger_error('crypter :: generateKeys - Path for key generation is not directory', E_USER_WARNING);
            return false;
        }

        return 'Keys successfully generated and saved to ' . $path;

    }


    public function encryptString($string_to_encrypt = '')
    {
        $path = $this->path;

        if(!is_string($string_to_encrypt))
        {
            trigger_error('crypter :: encryptString - $string_to_encrypt is not string', E_USER_WARNING);
            return false;
        }

        $public_file_path = $path.'/'. self :: public_key_name;

        if(!file_exists($public_file_path))
        {
            trigger_error('crypter :: encryptString - $public_file_path is not exists', E_USER_WARNING);
            return false;
        }

        $rsa = new Crypt_RSA();
        $public_key = file_get_contents($public_file_path);
        if(!$rsa->loadKey($public_key)) // public key
        {
            trigger_error('crypter :: encryptString - key load failed', E_USER_WARNING);
            return false;
        }

        return  $rsa->encrypt($string_to_encrypt);

    }


    public function decryptString($string_to_decrypt = '')
    {
        $path = $this->path;

        if(!is_string($string_to_decrypt))
        {
            trigger_error('crypter :: decryptString - $string_to_encrypt is not string', E_USER_WARNING);
            return false;
        }

        $private_file_path = $path.'/'. self :: private_key_name;

        if(!file_exists($private_file_path))
        {
            trigger_error('crypter :: decryptString - $public_file_path is not exists', E_USER_WARNING);
            return false;
        }

        $rsa = new Crypt_RSA();
        $private_key = file_get_contents($private_file_path);
        if(!$rsa->loadKey($private_key)) // private key
        {
            trigger_error('crypter :: decryptString - key load failed', E_USER_WARNING);
            return false;
        }

        return  $rsa->decrypt($string_to_decrypt);

    }
}
