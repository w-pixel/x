<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Traits\PdfTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


use PDF;
class SecondBot extends Controller
{
    use PdfTrait;
    protected $apiUrl = 'https://api.telegram.org/bot6545671886:AAE4m71nMNK-n4NfEXHL_6m8DpgoTdH2MeA';

    function handleView($id){
        $receipt = Receipt::whereId($id)->firstOrFail();

        return view($receipt->type,compact('receipt'));
    }

    function getMakeMessage($name)
    {
        if ($name == 'ابو ظبي'){
            return $this->buildMakeMessage(
                'تاريخ التحويل : 25 Sep 2023 19:15',
                'مقدار التحويل : 3,500.00',
                'اسم المستفيد : MAJID JUMA KHALIFA',
                'بنك المستفيد : ADIB',
                'رقم حساب المستلم : 28444733',
                'رقم حساب المحول : 28444732'
            );
        }
        elseif ($name == 'الراجحي'){
            return $this->buildMakeMessage(
                'تاريخ التحويل : 2023/10/30 - 11:35 AM',
                'المبلغ : 999',
                'من : حجي احمد',
                'اخر اربع ارقام بالايبان : 2049',
                'إلى : حجي وليد',
                'رقم المستلم : 686000010006080447333',
                'الغرض : حوالات شخصية'
            );
        }

        return 'البنك الذي اخترته تحت الصيانة ، الرجاء المحاولة لاحقا';
    }
    
    function alinma($id,$text){
        $this->sendMessage($id,'تحت التطوير ، حاول لاحقا :)');
        $this->clearCommand($text);
        return;
    }
    function alahly($id,$text){
        $this->sendMessage($id,'تحت التطوير ، حاول لاحقا :)');
        $this->clearCommand($text);
        return;
    }

    function alrajhi($id,$text){
        $text = $this->checkLengthMessage($id,$text,7,'الراجحي');

        // Message is not valid
        if ($text === false) return;

        $part = fn($text) => $this->partText($text);

        $points = ['date','amount','from_name','from_number','to_name','to_number','purpose'];
        $data = ['type' => 'alrajhi'];

        foreach ($points as $key => $value){
            $data[$value] = $part($text[$key]);
        }   

        $receipt = Receipt::create($data);

        $url = asset('receipt/' . $receipt->id);
        $text = "تم صنع الرابط : \n\n `$url` \n\n الموقع اللي يحول : https://www.web2pdfconvert.com";
        $this->sendMessage(
            $id,
            $text,
        );

        $this->clearCommand($id);

    }

    function checkLengthMessage($id,$text,$expected_length,$bank){

        $text = explode("\n",$text);

        if (count($text) != $expected_length){
            $this->sendMessage(
                $id,
                'البيانات التي ارسلتها اقل او اكثر من المطلوب ، يجب ان تكون البيانات على هذا الشكل 👇' . "\n\n" . $this->getMakeMessage($bank)
            );
            return false;
        }

        return $text;
    }

    function buildMakeMessage(...$inputs){
        $result = '`';

        foreach ($inputs as $input){
            $result .= $input . "\n";
        }
        return $result . '`';
    }

    function AbuDhabi($id,$text){   
        $text = $this->checkLengthMessage($id,$text,6,'ابو ظبي');

        // Message is not valid
        if ($text === false) return;

        $part = fn($text) => $this->partText($text);

        $data = [
            'ref_number' => $this->generateReferenceNumber(),
            'from' => $part($text[5]),
            'to' => $part($text[4]),
            'transaction_date' => $part($text[0]),
            'transfer_amount' => $part($text[1]),
            'recipient_name' => $part($text[2]),
            'recipient_bank' => $part($text[3])
        ];



        $pdfPath = public_path(md5($id . random_int(0000,9999999999)) . '.pdf');

        Pdf::loadView('welcome',$data)->save($pdfPath);

        $this->sendPdf($id,$pdfPath);

        unlink($pdfPath);

        $this->clearCommand($id);

    }


    function partText($text){
        try {
            return trim(explode(':',$text,2)[1]);
        }
        catch (\Exception $ex){
            exit;
        }
    }

    function sendPdf($chatId, $pdfFile)
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

    function clearCommand($id){
        $commandsPath = base_path('last-command.json');

        $commands = json_decode(file_get_contents($commandsPath));

        if (isset($commands->$id)){
            unset($commands->$id);
            file_put_contents($commandsPath,json_encode($commands));
        }

    }



    public function handle(Request $request)
    {
        
        //return;

        $message = $request->json()->all();


        $pathAdmins = base_path('admins1.json');
        $pathTried = base_path('tried1.json');
        
        $admins = json_decode(file_get_contents($pathAdmins));
        $tried = json_decode(file_get_contents($pathTried));

        $commandsPath = base_path('last-command.json');
        $commands = json_decode(file_get_contents($commandsPath));


        if (!isset($message['message']['text'])){
            info($message);
            $this->sendMessage($admins[0],'An error happen with message key');
            return;
        }

        $message = $message['message'];
        $id = $message['from']['id'];
        $name = $message['from']['first_name'] . ' ' .  (isset($message['from']['last_name']) ? $message['from']['last_name'] : '');
        $text = $message['text'];

        $keyboard_1 = [ 'الراجحي', 'ابو ظبي', 'الاهلي', 'الانماء' ];
        $keyboard = [
            ['الراجحي','ابو ظبي'],
            ['الاهلي','الانماء'],
        ];


        if (!in_array($id,$tried)){
            $send = 'Someone has tried to run bot' . PHP_EOL
                . 'Id : ' . $id . PHP_EOL
                . 'Name : ' . "[$name](tg://user?id=$id)" . PHP_EOL
                . '`/add ' . $id . '`'; 
            
            $this->sendMessage($admins[0],$send);
            $tried[] = $id;
            file_put_contents($pathTried,json_encode($tried));
            return;
        }
        
        if (!in_array($id,$admins)){
            return;
        }


        $replyMarkup = json_encode([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]);

        // if message is start
        if ($text == '/start'){

            if (isset($commands->$id)){
                unset($commands->$id);
                file_put_contents($commandsPath,json_encode($commands));
            }


            // Send the response
           $this->sendMessage($id,"اخوية الغالي $name ، اختار البنك اللي تريده من الاسفل",$replyMarkup);
            return;

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

        

        $commandsArray = [
            'الراجحي'  => fn($id,$text) => $this->alrajhi($id,$text),
            'ابو ظبي' => fn($id,$text) => $this->AbuDhabi($id,$text),
            'الانماء' => fn($id,$text) => $this->alinma($id,$text),
            'الاهلي'  => fn($id,$text) => $this->alahly($id,$text),
        ];
        
        // if the user already have a command
        if (isset($commands->$id)){
            if (in_array($text,$keyboard_1)){
                $commands->$id = $text;
                file_put_contents($commandsPath,json_encode($commands));
                $this->sendMessage(
                    $id,
                    'حسنا ، الان قم بإرسال البيانات بهذا الشكل 👇' . "\n\n" . $this->getMakeMessage($text),
                );
            }
            else {
                $commandsArray[$commands->$id]($id,$text);
            }
        }
        else {

            if (isset($commandsArray[$text])){

                $commands->$id = $text;
                file_put_contents($commandsPath,json_encode($commands));

                $this->sendMessage(
                    $id,
                    'اوكي ارسل البيانات الخاصة بالبنك على هذا الشكل' . "\n\n" . $this->getMakeMessage($text)
                    );


            }
            else {
                $this->sendMessage(
                    $id,
                    'الرجاء اختيار البنك اولا',
                    $replyMarkup
                );
            }

        }
    }

}
