<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use AfricasTalking\SDK\AfricasTalking;
use Twilio\Rest\Client;

class SendSms
{
    /**
     * @param $event
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function handle($event)
    {
        $recipients = $event->user->employee->phone;
        $message    = setting('notify_templates');

        if(setting('sms_gateway') == 'twilio') {
            // Your Account SID and Auth Token from twilio.com/console
            $sid = setting('twilio_sid');
            $token = setting('twilio_token');
            $client = new Client($sid, $token);
            // Use the client to do fun stuff like send text messages!
            $client->messages->create(
                // the number you'd like to send the message to
                $recipients,
                array(
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => setting('twilio_phone'),
                    // the body of the text message you'd like to send
                    'body' => $message
                )
            );
        } else {
            $username = setting('api_username'); // use 'sandbox' for development in the test environment
            $apiKey   = setting('api_key'); // use your sandbox app API key for development in the test environment
            $AT       = new AfricasTalking($username, $apiKey);

            // Get one of the services
            $sms        = $AT->sms();
            $sms->send([
                'to'      => $recipients,
                'message' => $message,
            ]);
        }
    }
}
