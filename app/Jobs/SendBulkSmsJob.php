<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBulkSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $smsBody;
    public $phoneNumbers;

    /**
     * Create a new job instance.
     *
     * @param string $smsBody
     * @param array|string $phoneNumbers
     */
    public function __construct($smsBody, $phoneNumbers)
    {
        $this->smsBody = $smsBody;
        $this->phoneNumbers = $phoneNumbers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_array($this->phoneNumbers)) {
            $this->phoneNumbers = implode(', ', array_unique($this->phoneNumbers));
        }

        if (!empty($this->phoneNumbers)) {
            single_msg_bulk_send($this->smsBody, $this->phoneNumbers);
        }
    }
}
