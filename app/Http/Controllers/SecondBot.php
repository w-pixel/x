<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Traits\PdfTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;


use PDF;
class SecondBot extends Controller
{
    use PdfTrait;
    // 6545671886:AAE4m71nMNK-n4NfEXHL_6m8DpgoTdH2MeA
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

        $this->sendMessage(
            $id,
            'انتظر ثواني بين ما انجز المهمة 🐸',
        );

        $receipt = Receipt::create($data);

        $url = asset('receipt/' . $receipt->id);


        $web2pdf = $this->web2pdf($url);

        if (isset($web2pdf['error'])){
            $this->sendMessage(
                $id,
                'تعذر تحويل الى pdf 😭',
            );
            return;
        }
        
        $this->sendPdf($id,$web2pdf['name']);

        $this->clearCommand($id);
    }


    
    function web2pdf(string $url)
    {
        info($url);
        // Define the URL
        $url = 'https://www.web2pdfconvert.com/api/convert/web/to/pdf?storefile=true&filename=contract-aram-invest-com-pdf-receipts-public-receipt-4';

        // Define the form data
        $data = [
            'url' => $url . '?weorj=wer',
            'pricing' => 'monthly',
            'ConversionDelay' => '0',
            'CookieConsentBlock' => 'true',
            'LoadLazyContent' => 'true',
            'Scale' => '100',
            'FixedElements' => 'absolute',
            'ViewportWidth' => '800',
            'ViewportHeight' => '800',
            'PageOrientation' => 'portrait',
            'PageRange' => '1-20',
            'PageSize' => 'letter',
            'MarginTop' => '0',
            'MarginRight' => '0',
            'MarginBottom' => '0',
            'MarginLeft' => '0',
            'ParameterPreset' => 'Custom',
        ];




        $tries = 0;
        
        while ($tries < 3){
            try {
                $req = Http::withHeaders(['User-Agent' => $this->getUserAgent()])->asForm()->post($url, $data);
                if ($req->status() == 200){
    
                    $content = $req->json();

                    if (isset($content['Files'])){
                        $path = public_path('pdfs/' . $content['Files'][0]['FileId'] . '.pdf');
                        
                        $pdf = Http::withHeader('User-Agent',$this->getUserAgent())->get($content['Files'][0]['Url'])->body();

                        File::put($path,$pdf);

                        return ['name' => $path];
                    }
  
                }
           }
            catch (Exception $ex){
                // do no thing on exception
            }
            $tries++;
        }

        return ['error' => true];
    }




    function getUserAgent()
    {
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_1) AppleWebKit/604.3.5 (KHTML, like Gecko) Version/11.0.1 Safari/604.3.5';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.89 Safari/537.36 OPR/49.0.2725.47';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/604.4.7 (KHTML, like Gecko) Version/11.0.2 Safari/604.4.7';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.108 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Edge/16.16299';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/604.4.7 (KHTML, like Gecko) Version/11.0.2 Safari/604.4.7';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/604.3.5 (KHTML, like Gecko) Version/11.0.1 Safari/604.3.5';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Linux x86_64; rv:52.0) Gecko/20100101 Firefox/52.0';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.108 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:52.0) Gecko/20100101 Firefox/52.0';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36 OPR/49.0.2725.64';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.108 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/604.4.7 (KHTML, like Gecko) Version/11.0.2 Safari/604.4.7';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/62.0.3202.94 Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:56.0) Gecko/20100101 Firefox/56.0';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:58.0) Gecko/20100101 Firefox/58.0';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; Trident/7.0; rv:11.0) like Gecko';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0';
        $userAgentArray[] = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0;  Trident/5.0)';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; rv:52.0) Gecko/20100101 Firefox/52.0';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/63.0.3239.84 Chrome/63.0.3239.84 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Fedora; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:56.0) Gecko/20100101 Firefox/56.0';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.108 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.89 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0;  Trident/5.0)';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/604.3.5 (KHTML, like Gecko) Version/11.0.1 Safari/604.3.5';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:57.0) Gecko/20100101 Firefox/57.0';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.79 Safari/537.36 Edge/14.14393';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:56.0) Gecko/20100101 Firefox/56.0';
        $userAgentArray[] = 'Mozilla/5.0 (iPad; CPU OS 11_1_2 like Mac OS X) AppleWebKit/604.3.5 (KHTML, like Gecko) Version/11.0 Mobile/15B202 Safari/604.1';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:58.0) Gecko/20100101 Firefox/58.0';
        $userAgentArray[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Safari/604.1.38';
        $userAgentArray[] = 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
        $userAgentArray[] = 'Mozilla/5.0 (X11; CrOS x86_64 9901.77.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.97 Safari/537.36';

        $getArrayKey = array_rand($userAgentArray);
        return $userAgentArray[$getArrayKey];
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
