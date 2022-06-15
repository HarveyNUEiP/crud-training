<?php
defined("BASEPATH") or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function index()
    {
        // IO物件建構
        $io = new \marshung\io\IO();
        // 匯入處理 - 取得匯入資料
        $data = $io->import($builder = 'Excel', $fileArgu = 'fileupload');
        // 取得匯入config名子
        $configName = $io->getConfig()->getOption('configName');
        // 取得有異常有下拉選單內容
        $mismatch = $io->getMismatch();
        // $mismatch = $io->getConfig()->getMismatch();

        echo 'Config Name = ' . $configName . "<br>\n";
        echo 'Data = ';
        var_export($data);
        echo "\n";
        echo 'Exception content = ';
        var_export($mismatch);
    }
}