<?php

namespace App\Jobs;

use App\Jobs\UpdateUshahidiPost;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

use Log;

class RunCreesService extends ProxyService
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

        } catch (YodieRequestFail $e) {

        }
    }

    public function format_as_post($post, $json)
    {
        $post_field = config('options.ushahidi.survey_destination_field');


        $text = $json['label'];


        // Accuracy

        // Tag
        // Create Ushahidi Post structure
        return array(
            'id' => $post_id,
            'tags' => [
                ''
            ]
        );
    }
}
