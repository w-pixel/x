<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait PdfTrait{


    function removeAdmin($id,$text,$admins,$pathAdmins){
        $text = explode(' ',$text);

        
        // message is not complete 
        if (count($text) != 2){
            $this->sendMessage($id,'Please check your message before add admin , example : `/rm 949977741`');
            return;
        }

        if (!in_array($text[1],$admins)){
            $this->sendMessage($id,'Does not exists');
            return;
        }

        unset($admins[array_search($text[1],$admins)]);



        file_put_contents($pathAdmins,json_encode($admins));

        $this->sendMessage($id,'DONE ✅');

    }

    function addAdmin($id,$text,$admins,$pathAdmins){
        $text = explode(' ',$text);

        // message is not complete 
        if (count($text) != 2){
            $this->sendMessage($id,'Please check your message before add admin , example : `/add 949977771`');
            return;
        }

        if (in_array($text[1],$admins)){
            $this->sendMessage($id,'Already added ✅');
            return;
        }

        $admins[] = $text[1];

        file_put_contents($pathAdmins,json_encode($admins));

        $this->sendMessage($id,'DONE ADDED ✅');
    }

    
    public function sendPdf($chatId, $pdfFile)
    {

        // Check if the PDF file exists
        if (!file_exists($pdfFile)) {
            return;
        }

        try {
            Http::attach('document', file_get_contents($pdfFile), 'Transaction Receipt.pdf')
                ->post($this->apiUrl . '/sendDocument', [
                    'chat_id' => $chatId,
                ]);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur during the request
            return;
        }
        unlink($pdfFile);
    }
    
    function sendMessage($chat_id,$text,$reply_markup = [] , $parse_mode = 'MarkDown'){
         Http::get($this->apiUrl . '/sendMessage',[
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => $parse_mode,
            'reply_markup' => $reply_markup,
            'disable_web_page_preview' => true
        ]);
    }

    function randomNumber($length){
        $randomNumber = random_int(1,9);
        for ($i = 1;$i < $length;$i++){
            $randomNumber .= random_int(0,9);
        }
        return $randomNumber;
    }

    function generateReferenceNumber($bank = null,$date = '') {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charslen = strlen($chars) - 1;
        $numbers = '0123456789';
    
        $reference = '';

        if ($bank == 'alinma'){
            $nums = '';
            $rchars = '';
            
            for ($i = 0;$i < 5;$i++){
                $nums .= random_Int(0,9);
            }
            for ($i = 0;$i < 6;$i++){
                $rchars .= $chars[random_int(0,$charslen)];
            }
            return $chars[random_int(0,$charslen)] . $nums . $rchars;
        }
        elseif ($bank == 'alahly'){
            $reference .= join('',explode('/',$date));
            for ($i = 0;$i < 10;$i++){
                $reference .= $chars[random_int(0,25)];
            }
            $reference .= random_int(0,9);
            $reference .= $chars[random_int(0,25)];

            for ($i = 0;$i < 14;$i++){
                $reference .= random_int(0,9);
            }
            
            return $reference;
        }

        $charCount = 4;
        $numberCount = 12;
        for ($i = 0; $i < 16; $i++) {
            if ($charCount > 0 && ($i != 0 || $i != 1) && ($i % 4 == 1 || $i % 4 == 1)) {
                // Add a random character
                $randomChar = $chars[rand(0, strlen($chars) - 1)];
                $reference .= $randomChar;
                $charCount--;
            } else {
                // Add a random number
                $randomNum = $numbers[rand(0, strlen($numbers) - 1)];
                $reference .= $randomNum;
                $numberCount--;
            }
        }
    
        return $reference;
    }

    function startWith($text,$neelde){
        return Str::startsWith($text,$neelde);
    }
}