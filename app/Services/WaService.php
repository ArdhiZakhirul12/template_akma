<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use Twilio\Rest\Client;

class WaService
{
    protected $token;
    protected $tokenFonnte;
    protected $sid;

    public function __construct()
    {
        $this->token = env('TWILIO_TOKEN');
        $this->tokenFonnte = env('FONNTE_TOKEN');
        $this->sid = env('SID_TOKEN');
    }

    // Update the path below to your autoload.php,
    // see https://getcomposer.org/doc/01-basic-usage.md
    
    
    
    public function sendMessage($to, $msg)
    {
        $sid    = $this->sid;
    $token  = $this->token;
    $twilio = new Client($sid, $token);
    $cleanNumber = preg_replace('/[^0-9]/', '', $to);
    
    // Handle semua kemungkinan format:
    if (str_starts_with($cleanNumber, '0')) {
        $formattedTo = 'whatsapp:+62' . substr($cleanNumber, 1);
    } elseif (str_starts_with($cleanNumber, '62')) {
        $formattedTo = 'whatsapp:+' . $cleanNumber;
    } else {
        $formattedTo = 'whatsapp:+' . $cleanNumber; // Untuk format internasional lain
    }
//     var_dump($formattedTo);
//     $message = $twilio->messages
//       ->create($formattedTo, // to
//         [
//             "from" => "whatsapp:+14155238886",
//             "body" => $msg
//         ]
//       );

// print($message->sid);

        $response = Http::withHeaders([
            'Authorization' => $this->tokenFonnte,
        ])->post('https://api.fonnte.com/send', [
            'target' => $to, // Contoh: 6281234567890
            'message' => $msg,
            'countryCode' => '62',
        ]);

        return $response->json();
    }
}

    