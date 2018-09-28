<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GrahamCampbell\Throttle\Facades\Throttle;
use Log;

class RunActionabilityService extends RunProxyService
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
        $remaining = config('options.actionability.request_per_time_block');
        $time = config('options.actionability.quota_reset');

        $minutes = $time / 60;

        $throttler = Throttle::get([
            'ip'    => 'ushahidi',
            'route' => 'actionability',
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
            $url = config('options.actionability.api.url');
            $response = $client->request('POST', $url,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'text/plain',
                    ],
                    'auth' => [
                        config('options.actionability.api.username'),
                        config('options.actionability.api.password')
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
        $tags = [];
        $json = json_decode($response->getBody(), true);

        if ($json['informative'] == false) {
            array_push($tags, ['value' => 'Not informative']);
        } else {
            array_push($tags, ['value' => 'Informative']);
            foreach ($json['action_categories'] as $category) {
                array_push($tags, ['value' => $category['desc']]);
            }
        }
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
