<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

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
                        'ushahidi',
                        'Xh!07_1grAv6eo]Sekx1'
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
            $tags = array_merge($tags, ['not informative']);
        } else {
            $tags = array_merge($tags, ['informative']);
            foreach ($json['action_categories'] as $category) {
                array_push($tags, $category['desc']);
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
