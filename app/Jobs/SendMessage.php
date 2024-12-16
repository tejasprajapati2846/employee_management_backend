<?php

namespace App\Jobs;

use Aws\Sqs\SqsClient;
use App\Models\SentMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    /**
     * Create a new job instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $queueUrl = env('SQS_SUFFIX') . '/' . env('SQS_PREFIX');
            $sqs = new SqsClient([
                'region' => env('AWS_DEFAULT_REGION'),
                'version' => 'latest',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
            
            $result = $sqs->sendMessage([
                'QueueUrl' => $queueUrl,
                'MessageBody' => $this->message,
            ]);

            SentMessage::create([
                'message_id' => $result->get('MessageId'),
                'message_body' => $this->message,
            ]);
            
            \Log::info('Message sent successfully !!');
        
        } catch (\Exception $e) {
            \Log::info('Something went wrong : '.$e->getMessage());
        }
    }
}
