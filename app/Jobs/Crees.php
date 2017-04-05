<?php

namespace App\Jobs;

use App\Jobs\UpdateUshahidiPost;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

use Log;

class Crees extends Job
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;
    /**
     * The text to be annotated
     *
     * @var string
     */
    protected $text;

    /**
     * The post id
     *
     * @var int
     */
    protected $post_id;

    protected $request_type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post_id, $text, $request_type)
    {
        $this->post_id = $post_id;
        $this->text = $text;
        $this->request_type = $request_type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->runCrees($this->post_id, $this->text);
    }

    public function runCrees($post_id, $text)
    {
      $response = $this->requestLabeling($text);;
      $post = $this->format_labeling_as_post($post_id, json_decode($response->getBody()));
      Log::info(print_r(json_decode($response->getBody()),true));
      //dispatch(new UpdateUshahidiPost($post));
    }

    public function requestLabeling($text)
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

    public function format_labeling_as_post($post_id, $json)
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
