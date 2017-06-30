<?php

namespace App\Jobs;

use App\Jobs\UpdateUshahidiPost;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

use Log;

class RunCreesService extends RunProxyService
{
    /**
      * Crees Service Type
      * eventRelated, eventType, infoType
      */
    protected $request_type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post, $request_type)
    {
        $this->post= $post;
        $this->request_type = $request_type;
    }

    public function requestProcessing($text)
    {
        try {
            $client = new Client();
            $crees_uris = [];
            $crees_reponses = [];

            if ($this->request_type === 'all') {
                array_push($crees_uris,
                    config('options.crees.api.url') . 'eventRelated',
                    config('options.crees.api.url') . 'eventType',
                    config('options.crees.api.url') . 'infoType'
                );
            } else {
                array_push($crees_uris,
                    config('options.crees.api.url') . $this->request_type
                );
            }

            foreach ($crees_uris as $uri) {
                $response = $client->request('GET', $uri,
                    [
                      'query' => ['text' => $text]
                    ]
                );
                array_push($crees_reponses, $response);
            }

            return $crees_reponses;

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                Log::error(Psr7\str($e->getResponse()));
            }
        }
    }

    public function format_as_post($post, $responses)
    {
        $tags = [];
        foreach ($responses as $response) {
            $json = json_decode($response->getBody());
            $text = $json->label;
            $tags = $tags ? array_merge($tags, [$text]) : [$text];
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
