<?php

namespace Rickyfun\LetsBeast\Beast;


class BeastService
{
    use Beast;

    private $nfiles = 0;

    private $finish = 0;

    public function __construct()
    {
        $this->nfiles = 0;
        $this->finish = 0;
    }

    public function validateLoaded()
    {
        if (!extension_loaded('beast')) {
            throw new \Exception('Not found module beast');
        }
    }

    public function calculate_directory_schedule($dir)
    {
        $dir = rtrim($dir, '/');

        $handle = opendir($dir);
        if (!$handle) {
            return false;
        }

        while (($file = readdir($handle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $path = $dir . '/' . $file;

            if (is_dir($path)) {
                $this->calculate_directory_schedule($path);

            } else {
                $infos = explode('.', $file);

                if (strtolower($infos[count($infos)-1]) == 'php') {
                    $this->nfiles++;
                }
            }
        }

        closedir($handle);
    }


    public function encrypt_directory($dir, $new_dir, $expire, $type)
    {
        $dir = rtrim($dir, '/');
        $new_dir = rtrim($new_dir, '/');

        $handle = opendir($dir);
        if (!$handle) {
            return false;
        }

        while (($file = readdir($handle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $path = $dir . '/' . $file;
            $new_path =  $new_dir . '/' . $file;

            if (is_dir($path)) {
                if (!is_dir($new_path)) {
                    mkdir($new_path, 0777);
                }

                $this->encrypt_directory($path, $new_path, $expire, $type);

            } else {
                $infos = explode('.', $file);

                if (strtolower($infos[count($infos)-1]) == 'php'
                    && filesize($path) > 0)
                {
                    if ($expire > 0) {
                        $result = $this->encodeFile($path, $new_path,
                            $expire, $type);
                    } else {
                        $result = $this->encodeFile($path, $new_path, 0, $type);
                    }

                    if (!$result) {
                        echo "Failed to encode file `{$path}'\n";
                    }

                    $this->finish++;

                    $percent = intval($this->finish / $this->nfiles * 100);

                    printf("\rProcessed encrypt files [%d%%] - 100%% \n", $percent);

                } else {
                    copy($path, $new_path);
                }
            }
        }

        closedir($handle);
    }

    public function run($src_path, $dst_path, $expire, $encrypt_type)
    {
        $src_path     = trim($src_path);
        $dst_path     = trim($dst_path);
        $expire       = trim($expire);
        $encrypt_type = strtoupper(trim($encrypt_type));

        if (empty($src_path) || !is_dir($src_path)) {
            exit("Fatal: source path `{$src_path}' not exists\n\n");
        }

        if (empty($dst_path)
            || (!is_dir($dst_path)
                && !mkdir($dst_path, 0777)))
        {
            exit("Fatal: can not create directory `{$dst_path}'\n\n");
        }

        $entype = Beast::typeDefine($encrypt_type);

        printf("Source code path: %s\n", $src_path);
        printf("Destination code path: %s\n", $dst_path);
        printf("Expire time: %s\n", $expire);
        printf("------------- start process -------------\n");

        $expire_time = 0;
        if ($expire) {
            $expire_time = strtotime($expire);
        }

        $time = microtime(TRUE);

        $this->calculate_directory_schedule($src_path);
        $this->encrypt_directory($src_path, $dst_path, $expire_time, $entype);

        $used = microtime(TRUE) - $time;

        printf("\nFinish processed encrypt files, used %f seconds\n", $used);
    }
}