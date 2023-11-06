<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @php $p = env('PUBLIC_PATH'); @endphp
    <link rel="stylesheet" href="{{ $p }}/css/style.alinma.css">
    <style>
    </style>
    <title>Alinma receipt</title>
</head>
<body class="font-thesans relative text-[#562d24] h-[10.7in]" dir="rtl" onclick="window.print()">
    <div class="p-4 flex justify-between">
        <img src="{{ $p }}/img/alinma/header.jpg" class="w-[180px]" alt="">
        <div class="text-left">
            <div>إجراء تحويل</div>
            <div>Make a Transfer</div>
        </div>
    </div>

    <div class="bg-[#f5f5f3] h-[100px] mx-4 my-2 w-[85%]">
    </div>

    <div class="m-4 grid grid-cols-2 text-[12px]">
        
            <div class="grid grid-cols-10 col-span-1 p-2">
                <div class="col-span-3 m-1 flex flex-col text-[9px]">
                    <div>من حساب</div>
                    <div>From Account</div>
                </div>
                <div class="col-span-7 m-1 p-2 bg-[#e7ded0]">
                    xxxx xxxx xxxx {{ $receipt->from_number }}
                </div>
            </div>
            
            <div class="grid grid-cols-10 col-span-1 p-2">
                <div class="col-span-3 m-1 flex flex-col text-[9px]">
                    <div>نوع التحويل</div>
                    <div>Type</div>
                </div>
                <div class="col-span-7 m-1 p-2 bg-[#e7ded0]">
                    حساب في الإنماء
                </div>
            </div>
            
            <div class="grid grid-cols-10 col-span-1 p-2">
                <div class="col-span-3 m-1 flex flex-col text-[9px]">
                    <div>إلى مستفيد</div>
                    <div>To beneficiary</div>
                </div>
                <div class="col-span-7 m-1 p-2 bg-[#e7ded0]">
                    {{ $receipt->to_name }}
                </div>
            </div>

            <div class="grid grid-cols-10 col-span-1 p-2">
                <div class="col-span-3 m-1 flex flex-col text-[9px]">
                    <div>حساب المستفيد</div>
                    <div>BeneficiaryAccount</div>
                </div>
                <div class="col-span-7 m-1 p-2 bg-[#e7ded0]">
                    {{ $receipt->to_number }}
                </div>
            </div>

            <div class="grid grid-cols-10 col-span-1 p-2">
                <div class="col-span-3 m-1 flex flex-col text-[9px]">
                    <div>المبلغ</div>
                    <div>Amount</div>
                </div>
                <div class="col-span-7 m-1 p-2 bg-[#e7ded0]">
                    SAR {{ $receipt->amount }}
                </div>
            </div>

            <div class="grid grid-cols-10 col-span-1 p-2">
                <div class="col-span-3 m-1 flex flex-col text-[9px]">
                    <div>الغرض من التحويل</div>
                    <div>Fund Transfer Purpose</div>
                </div>
                <div class="col-span-7 m-1 p-2 bg-[#e7ded0]">
                    {{ $receipt->purpose }}
                </div>
            </div>

            <div class="grid grid-cols-10 col-span-1 p-2">
                <div class="col-span-3 m-1 flex flex-col text-[9px]">
                    <div>مذكره</div>
                    <div>Memo</div>
                </div>
                <div class="col-span-7 m-1 p-2 bg-[#e7ded0]">
                    {{ $receipt->memo }}
                </div>
            </div>



            <div class="grid grid-cols-10 col-span-1 p-2">
                <div class="col-span-3 m-1 flex flex-col text-[9px]">
                    <div>تاريخ العملية</div>
                    <div>Transaction Date</div>
                </div>
                <div class="col-span-7 m-1 p-2 bg-[#e7ded0]">
                    {{ $receipt->date }}
                </div>
            </div>

            <div class="grid grid-cols-10 col-span-1 p-2">
                <div class="col-span-3 m-1 flex flex-col text-[9px]">
                    <div>الرقم المرجعي</div>
                    <div># Reference</div>
                </div>
                <div class="col-span-7 m-1 p-2 bg-[#e7ded0]">
                    {{ $receipt->reference }}
                </div>
            </div>
    </div>
    
    <div class="absolute flex justify-between items-center h-12 py-2 px-6 bottom-[-108px] left-0 w-full bg-[#f5f5f3]">
        <div class="text-sm">
            <div>920028000</div>
            <div dir="ltr">w.alinma.com</div>
        </div>

        <div class="text-[10px]">
            رقم ضريبة القيمة المضافة لمصرف الإنماء 3506666 Number VAT Alinma
        </div>
    </div>
</body>
</html>