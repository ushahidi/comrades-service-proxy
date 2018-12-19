<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GrahamCampbell\Throttle\Facades\Throttle;
use Log;

class RunVeracityService extends RunProxyService
{
    /**
     *  Service Type
     * eventRelated, eventType, infoType
     */
    protected $request_type;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $remaining = config('options.veracity.request_per_time_block');
        $time = config('options.veracity.quota_reset');

        $minutes = $time / 60;

        $throttler = Throttle::get([
            'ip'    => 'ushahidi',
            'route' => 'veracity',
        ], $remaining, $minutes);

        if (!$throttler->check()) {
            $this->release($time);
            return;
        }
        $this->runService($this->post);
    }

    public function requestProcessing($text)
    {
        try {
            $client = new Client();
            $url = config('options.veracity.api.url');
            $response = $client->request('POST', $url,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'text/plain',
                    ],
                    'auth' => [
                        config('options.veracity.api.username'),
                        config('options.veracity.api.password')
                    ],
                    'body' => json_encode([$text])
                ]
            );
            return $response;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                Log::error(Psr7\str($e->getResponse()));
            }
        }
    }

    public function format_as_post($post, $response)
    {
        $json = json_decode($response->getBody(), true);
        if ($json['rumour_label'] == 'unverified') {
            $label = 'Unverified';
        } else if ($json['rumour_label'] == false) {
            $label = 'Rumor';
        } else {
            $label ='Not a rumor';
        }
        $tags = [
            ['value' => $label, 'confidence_score' => $json['confidence'] * 100]
        ];
        // At the moment it is important to only set fields that you intend to change
        // as Post updates are async it is possible to overwrite other user's data
        // by performing a full update with the complete object recevied
        return [
            'id' => $post['id'],
            'tags' => $tags,
            'values' => [],
            'webhook_uuid' => $post['webhook_uuid']
        ];
    }
}
