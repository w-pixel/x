<?php

// Define the URL
$url = "https://www.web2pdfconvert.com/api/convert/web/to/pdf?storefile=true&filename=pdf-x";

// Define the form data
$data = [
    'url' => 'https://contract.aram-invest.com/pdf-receipts/public/receipt/14?wre=r',
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

// Initialize cURL session
$ch = curl_init();

$headers = [
    'User-Agent: python-requests/2.31.0',
];
// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);

// Execute cURL session and get the response
$response = curl_exec($ch);

// Check the response and status code
if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
    echo "Request was successful!";
    // You can print or process the response content here
    echo $response;
} else {
    echo "Request failed with status code " . curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

// Close cURL session
curl_close($ch);
