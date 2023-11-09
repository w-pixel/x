<!DOCTYPE html>
<html lang="ar" onclick="window.print()">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&family=Rubik:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.alahly.css">
    <title>Alahly Receiption</title>
</head>
<body dir="rtl" class="font-dejasans text-[11px]">
    <div class="flex flex-col justify-center mt-8 items-center">
        <img src="/img/alahly/header.jpg" width="200px" alt="">
        <div class="font-bold mt-3 text-[13px]">إيصال</div>
    </div>

    <div class="border-2 border-[#666] mt-3 mx-6 p-6">
        <div class="text-center font-bold">
            <div>الحوالة الفورية</div>
            <div class="mt-3">أعد لـ <span dir="ltr">{{ $receipt->from_name }}</span> بتاريخ {{ $receipt->date }} ووقت {{ $receipt->memo }}</div>
        </div>
        <div>
            <div class="my-10">عزيزي العميل،</div>
            <div class="w-[66%] flex">
                <div class="w-[50%]">رقم المرجع</div>
                <div class="w-[50%] font-bold">{{ $receipt->reference }}</div>
            </div>
            <div class="mt-1.5">الرجاء الاحتفاظ به للاستخدام في المستقبل</div>
            <div class="mt-1.5">الرقم الضريبي 300002471110003</div>
            <div class="mt-1.5">نشكرك لإستخدام خدمة الأهلي موبايل.</div>


            <span class="bg-[#808080] font-bold pl-8 mt-8 inline-block text-white">من</span>
            <div class="border-[#666] border-2 p-3">
                <div>
                    <span class="w-[25%]">الفرع</span>
                </div>

                <div>
                    <span class="w-[25%] inline-block">العملة</span>
                    <span>SAR</span>
                </div>
                <div>
                    <span class="w-[25%] inline-block">رقم الحساب</span>
                    <span>{{ $receipt->from_name }}</span>
                </div>
                <div>
                    <span class="w-[25%] inline-block">المبلغ</span>
                    <span>{{ $receipt->amount }} SAR</span>
                </div>
                <div>
                    <span class="w-[25%] inline-block">الرسوم</span>
                    <span>0.5 SAR</span>
                </div>
                <div>
                    <span class="w-[25%] inline-block">ضريبة القيمة المضافة</span>
                    <span>0.080 SAR</span>
                </div>
                <div>
                    <span class="w-[25%] inline-block">المبلغ الإجمالي</span>
                    <span>{{ (int)$receipt->amount + 0.58 }} SAR</span>
                </div>
            </div>

            <span class="bg-[#808080] font-bold pl-8 inline-block text-white">إلى</span>
            <div class="border-[#666] border-2 p-3">
                <div>
                    <span class="w-[25%] inline-block">تاريخ التنفيذ</span>
                    <span>{{ $receipt->date }}</span>
                </div>

                <div>
                    <span class="w-[25%] inline-block">العملة</span>
                    <span>SAR</span>
                </div>
                <div>
                    <span class="w-[25%] inline-block">رقم الحساب</span>
                    <span>{{ $receipt->to_number }}</span>
                </div>
                <div>
                    <span class="w-[25%] inline-block">المستفيد</span>
                    <span>{{ $receipt->to_name }}</span>
                </div>
                <div>
                    <span class="w-[25%] inline-block">مبلغ الإيداع</span>
                    <span>{{ $receipt->amount }} SAR</span>
                </div>
            </div>
            <div class="m-2">ملاحظات</div>

        </div>
        <div class="m-4 border-2 border-black">
            <div class="mx-2 font-bold">البنك الأهلي السعودي</div>
            <div class="mt-1">شركة مساهمة سعودية</div>

            <div class="mt-4 mr-2 text-[9px]">
                <div class="mt-0.5">رأس المال 60,000,000,000 ريال سعودي مدفوع بالكامل</div>
                <div class="my-6">سجل تجاري رقم 4030001588</div>
                <div class="my-6">خاضعة لإشراف ورقابة البنك المركزي السعودي</div>

            </div>
        </div>
    </div>
</body>
</html>