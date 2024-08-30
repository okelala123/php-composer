<?php 
namespace App\Services;

class VifoAuthenticate{
    public function login()
    {
        $data = [
            'username' => 'VIFODEMO_Trung',
            'password' => '123456'
        ];

        return $data;
    }
}