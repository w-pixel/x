<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PdfController extends Controller
{
    //

    //protected $token = '6442439406:AAHwQ1_1mU6Sfcgq2Kl3HHdGXaM7QN2FTqo';
    protected $apiUrl = 'https://api.telegram.org/bot6442439406:AAHwQ1_1mU6Sfcgq2Kl3HHdGXaM7QN2FTqo';
    

    function sendMessage($chat_id,$text){
        $data = [
            'text' => $text,
            'chat_id' => $chat_id,
            'parse_mode' => 'markdown'
        ];
        Http::get($this->apiUrl . '/sendMessage',$data);
    }
    function randomNumber($length){
        $randomNumber = random_int(1,9);
        for ($i = 1;$i < $length;$i++){
            $randomNumber .= random_int(0,9);
        }
        return $randomNumber;
    }
    
    public function handleBot(Request $request)
    {
        // Parse the incoming webhook payload (assuming JSON data)
        $data = $request->json();

        // Process the webhook data (you can customize this part)
        $this->processWebhookData($data);

        // Send a response (if needed)
        //return response()->json(['message' => 'Webhook received and processed.']);
    }


    private function processWebhookData($data)
    {
        $message = $data->all()['message'];
        $id = $message['from']['id'];
        $name = $message['from']['first_name'] . ' ' .  $message['from']['last_name'];
        $text = $message['text'];
        $pathAdmins = base_path('admins.json');
        $pathTried = base_path('tried.json');
        
        $admins = json_decode(file_get_contents($pathAdmins));
        $tried = json_decode(file_get_contents($pathTried));


        if (!in_array($id,$tried)){
            $send = 'Someone has tried to run bot' . PHP_EOL
                . 'Id : ' . $id . PHP_EOL
                . 'Name : ' . $name . PHP_EOL
                . '`/add ' . $id . '`'; 
            
            $this->sendMessage($admins[0],$send);
            $tried[] = $id;
            file_put_contents($pathTried,json_encode($tried));
            return;
        }
        
        if (!in_array($id,$admins)){
            return;
        }


        // if message is start
        if ($text == '/start'){
            $send = $this->getStartMessage($name);
            $this->sendMessage($id,$send);
        }

        if ($id == $admins[0]){
            if ($this->startWith($text,'/add')){
                $this->addAdmin($id,$text,$admins,$pathAdmins);
                return;
            }

            if ($this->startWith($text,'/rm')){
                $this->removeAdmin($id,$text,$admins,$pathAdmins);
                return;
            }
        }

        if ($this->startWith($text,'جديد')){
            $this->handleNewPdf($id,$text);
            return;
        }
    }


    function handleNewPdf($id,$text){
        $text = explode("\n",$text);

        if (count($text) != 5){
            $this->sendMessage($id,'البيانات التي تم إرسالها اقل او اكثر من المطلوب ! ');
            return;
        }

        //! need edit if we have multibanks
        
        $part = fn($text) => trim(explode(':',$text)[1]);
        $data = [
            'ref_number' => $this->generateReferenceNumber(),
            'from' => $this->randomNumber(8),
            'to' => $this->randomNumber(8),
            'transaction_date' => $part($text[1]),
            'transfer_amount' => $part($text[2]),
            'recipient_name' => $part($text[3]),
            'recipient_bank' => $part($text[4])
        ];



        $pdfPath = public_path(md5($id . random_int(0000,9999999999)) . '.pdf');

        Pdf::loadView('welcome',$data)->save($pdfPath);

        $this->sendPdf($id,$pdfPath);

        unlink($pdfPath);

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
    }


    
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

    function startWith($text,$neelde){
        return Str::startsWith($text,$neelde);
    }

    function getStartMessage($name)
    {
        return 'يا هلا ب ' . $name . "🐒\n\n"
        . "عزيزي حتى تسوي PDF إستخدم هاي الرسالة\n\n"
        . "`جديد\n"
        . "تاريخ التحويل : \n"
        . "مقدار التحويل : \n"
        . "اسم المستفيد : \n"
        . "بنك المستفيد : `";
    }

    function generateReferenceNumber(){
        return 'A@#$@#$';
    }
    
    function index(){
        $data = [
            'ref_number' => $this->generateReferenceNumber(),
            'from' => $this->randomNumber(8),
            'to' => $this->randomNumber(8)
        ];
    
        return view('welcome',$data);
        $pdf = Pdf::loadView('welcome')->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}