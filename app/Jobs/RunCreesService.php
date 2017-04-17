<?php

namespace App\Jobs;

use App\Jobs\UpdateUshahidiPost;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

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

            $crees_api_url = config('options.crees.api.url') . $this->request_type;

            return $client->request('GET', $crees_api_url,
                [
                  'query' => ['text' => $text]
                ]
        		);

        } catch (CreesRequestFail $e) {

        }
    }

    public function format_as_post($post, $json)
    {
        $text = $json->label;
        $post['tags'] = $post['tags'].length ? $post['tags'].concat([$text]) : [$text];


        // Accuracy

        // Tag
        // Create Ushahidi Post structure

        // At the moment it is important to only set fields that you intend to change
        // as Post updates are async it is possible to overwrite other user's data
        // by performing a full update with the complete object recevied
        return [
            'id' => $post['id'],
            'tags' => $post['tags'],
            'webhook_uuid' => $post['webhook_uuid']
        ];
    }
}
