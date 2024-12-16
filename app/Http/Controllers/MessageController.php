<?php

namespace App\Http\Controllers;

use Aws\Sqs\SqsClient;
use App\Models\SentMessage;
use Illuminate\Http\Request;
use App\Models\ReceivedMessage;

class MessageController extends Controller
{
    protected $sqs;
    protected $queueUrl;

    /**
     * Class constructor.
     *
     * Initializes the queue URL and SQS client for sending messages to AWS SQS.
     */
    public function __construct()
    {
        $this->queueUrl = env('SQS_SUFFIX') . '/' . env('SQS_PREFIX');
        $this->sqs = new SqsClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    /**
     * Send Message form function to return view
     *
     * @return View
     */
    public function showSendMessageForm()
    {
        return view('welcome');
    }

    /**
     * Send Message to AWS SQS function
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|min:5',
            ]);

            $result = $this->sqs->sendMessage([
                'QueueUrl' => $this->queueUrl,
                'MessageBody' => $request->message,
            ]);


            SentMessage::create([
                'message_id' => $result->get('MessageId'),
                'message_body' => $request->message,
            ]);

            return redirect()->back()->with('message', 'Message sent successfully !!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!!');
        }
    }

    /**
     * Receive Message from AWS SQS Queue
     *
     * @return View
     */
    public function showReceivedMessages()
    {
        try {
            $messages = [];
            while (true) {
                $result = $this->sqs->receiveMessage([
                    'QueueUrl' => $this->queueUrl,
                    'MaxNumberOfMessages' => 10,
                    'VisibilityTimeout' => 60,
                ]);
            
                if ($result->hasKey('Messages')) {
                    foreach ($result->get('Messages') as $message) {
                        $messageBody = $message['Body'];
                        $messages[] = $messageBody;
            
                        ReceivedMessage::create([
                            'message_id' => $message['MessageId'],
                            'message_body' => $messageBody,
                        ]);
            
                        // Uncomment this if you want to delete the message after processing
                        /*
                        $this->sqs->deleteMessage([
                            'QueueUrl' => $this->queueUrl,
                            'ReceiptHandle' => $message['ReceiptHandle'],
                        ]);
                        */
                    }
                } else {
                    break;
                }
            }
            if (!empty($messages)) {
                return view('messages')->with('message', 'Message(s) received successfully!!')->with('messages', $messages);
            } else {
                return view('messages')->with('message', 'No new message received!!')->with('messages', $messages);
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return view('messages')->with('message', 'Something went wrong!!')->with('messages', $messages);
        }
    }
}
