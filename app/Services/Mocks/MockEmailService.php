<?php

namespace App\Services\Mocks;

class MockEmailService
{
    /**
     * Send a mock email (logs to storage/logs/laravel.log)
     */
    public function send($to, $subject, $content)
    {
        \Log::info('Mock Email Sent', [
            'to' => $to,
            'subject' => $subject,
            'content' => $content,
            'timestamp' => now(),
        ]);
        
        return true;
    }
}
