<?php

namespace App\Http\Services;

class Cryptography
{
    public $ciphering; // Storingthe cipher method
    public $iv_length; // Using OpenSSl Encryption method
    public $options;
    public $encryption_iv, $decryption_iv; // Non-NULL Initialization Vector for encryption
    public $encryption_key, $decryption_key; // Storing the encryption key


    function __construct() {
        $this->ciphering = "AES-128-CTR";
        $this->iv_length = openssl_cipher_iv_length($this->ciphering);
        $this->options = 0;
        $this->encryption_iv = config('app.cryptoIVKey');
        $this->decryption_iv = config('app.cryptoIVKey');
        $this->encryption_key = config('app.cryptoSecretKey');
        $this->decryption_key = config('app.cryptoSecretKey');
    }


    // public function run(string $text): string
    // {


    //     // $ciphering = "AES-128-CTR";

    //     // // Using OpenSSl Encryption method
    //     // $iv_length = openssl_cipher_iv_length($ciphering);
    //     // $options = 0;

    //     // // Non-NULL Initialization Vector for encryption
    //     // $encryption_iv = config('app.cryptoIVKey');

    //     // // Storing the encryption key
    //     // $encryption_key = config('app.cryptoSecretKey');

    // }

    public function Test(){
        // The cipher method to get iv length of
        $method = 'aes-128-gcm';

        // Get the iv length
        $ivl = openssl_cipher_iv_length($method);


        $ciphering = "AES-128-CTR"; // Storingthe cipher method
        $iv_length = openssl_cipher_iv_length($ciphering); // Using OpenSSl Encryption method
        $options = 0;

        // Output the ivl to
        //dd($ivl);
        return $iv_length;
    }


    public function encryptText(string $text_to_encrypt): string
    {
        // Using openssl_encrypt() function to encrypt the data
        return  $encryption = openssl_encrypt($text_to_encrypt, $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);
    }


    public function decryptText(string $text_to_decrypt): string
    {
        // Using openssl_decrypt() function to decrypt the data
        return  $decryption = openssl_decrypt($text_to_decrypt, $this->ciphering, $this->decryption_key, $this->options, $this->decryption_iv);
    }
}
