<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $baseUrl = 'http://localhost:3001/api';

    public function sendDocument($number, $text, $fileUrl, $fileName)
    {
        try {
            $response = Http::post("{$this->baseUrl}/send-message", [
                'number'    => $number,
                'type'      => 'document',
                'text'      => $text,
                'file_url'  => $fileUrl,
                'file_name' => $fileName,
            ]);

            return $response->json();
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}