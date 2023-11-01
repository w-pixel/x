<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alrajhi receipts</title>
    <link rel="stylesheet" href="{{ env('PUBLIC') }}/css/style.min.css">
    <!-- #1b254a -->
</head>
<body dir="rtl" class="font-sf" onclick="window.print()">

    <div class="bg-[#1b254a] h-8"></div>
    
    <div class="flex justify-around items-center mt-14">
        <div>
            <div class="font-bold text-4xl">إيصال التحويل</div>
            <div class="font-bold text-4xl mt-2">Transfer Receipt</div>
        </div>
        <img src="{{ env('PUBLIC') }}/img/alrajhi/header.JPG" width="250px;">
    </div>

    
    <div class="w-[80%] mx-auto text-xl">
        <div class="flex justify-around items-center mt-14">
            <div>
                <div class="font-semibold text-2xl">التاريخ Date</div>
                <div class="text-2xl mt-1" dir="ltr">{{ $receipt->date }}</div>
            </div>
            <div class="text-lg">لمستفيد مصرف الراجحي Al Rajhi Bank beneficiary</div>
        </div>

        <div class="mt-4 rounded p-2 bg-[#e8e9ec] flex justify-between">
            <div>تفاصيل التحويل</div>
            <div>Transfer Details</div>
        </div>

        <div class="flex justify-between mt-4">
            <div class="mr-4 font-bold">المبلغ</div>
            <div dir="ltr">{{ $receipt->amount }} SAR</div>
            <div class="ml-4 font-bold">Amount</div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <div class="mr-4 font-bold">من</div>
            <div class="text-center">
                <div>{{ $receipt->from_name }}</div>
                <div>SA** **** **** **** **** {{ $receipt->from_number }}</div>
                <div>Al Rajhi Bank</div>
            </div>
            <div class="ml-4 font-bold">From</div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <div class="mr-4 font-bold">إلى</div>
            <div class="text-center">
                <div>{{ $receipt->to_name }}</div>
                <div>{{ $receipt->to_number }}</div>
            </div>
            <div class="ml-4 font-bold">To</div>
        </div>

        <div class="flex justify-between mt-6">
            <div class="mr-4 font-bold">الغرض</div>
            <div>
                {{ $receipt->purpose }}
            </div>
            <div class="ml-4 font-bold">Purpose</div>
        </div>

        <div class="mt-20 flex flex-row-reverse justify-between items-center">
            <img src="{{ env('PUBLIC') }}/img/alrajhi/bottom.JPG" class="max-w-[240px]">
            <div class="flex flex-col items-center text-2xl">
                <div class="text-xl">Alrajhibank.com.sa</div>
                <div class="text-4xl">344 003 920</div>
                <div class="flex flex-row-reverse mt-4 items-center gap-x-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                    </svg>

                    <img src="{{ env('PUBLIC') }}/img/alrajhi/whatsapp.JPG" class="w-[35px]" >
                </div>
            </div>
        </div>
    </div>

</body>
</html>