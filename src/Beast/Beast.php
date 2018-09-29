<?php

namespace Rickyfun\LetsBeast\Beast;


trait Beast
{
    public function typeDefine(string $encryptType)
    {
        switch ($encryptType)
        {
            case 'AES':
                $enType = BEAST_ENCRYPT_TYPE_AES;
                break;
            case 'BASE64':
                $enType = BEAST_ENCRYPT_TYPE_BASE64;
                break;
            case 'DES':
            default:
                $enType = BEAST_ENCRYPT_TYPE_DES;
                break;
        }
        return $enType;
    }

    public function encodeFile(string $input_file, string $output_file, int $expire_timestamp, int $encrypt_type)
    {
        return beast_encode_file($input_file, $output_file, $expire_timestamp, $encrypt_type);
    }

    public function availCache()
    {
        return beast_avail_cache();
    }

    public function supportFileSize()
    {
        return beast_support_filesize();
    }

    public function fileExpire($file)
    {
        return beast_file_expire($file);
    }

    public function cleanCache()
    {
        return beast_clean_cache();
    }
}