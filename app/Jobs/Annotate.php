<?php

namespace App\Jobs;

use App\Jobs\UpdateUshahidiPost;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

use Log;

class Annotate extends Job
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post_id, $text)
    {
        $this->post_id = $post_id;
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->runAnnotation($this->post_id, $this->text);
    }

    public function runAnnotation($post_id, $text)
    {
      $response = $this->requestAnnotation($text);;
      $post = $this->format_annotation_as_post($post_id, json_decode($response->getBody()));

      dispatch(new UpdateUshahidiPost($post));
    }

    public function requestAnnotation($text)
    {
        try {
            $client = new Client();

            $yodie_api_url = config('options.yodie.api.url');
            $yodie_api_key = config('options.yodie.api.key');
            $yodie_api_secret = config('options.yodie.api.secret');

            return $client->request('POST', $yodie_api_url, [
          			'headers' => [
          			     'Accept' => 'application/json',
                     'Content-type' => 'text/plain'
          			],
                'auth' => [
                      $yodie_api_key,
                      $yodie_api_secret
                ],
          			'body' => $text
        		]);

        } catch (YodieRequestFail $e) {

        }
    }

    public function replaceTextWithMD($indices, $link, $text)
    {
        $start = $indices[0];
        $length = $indices[1] - $indices[0];

        $string = substr($text, $start, $length);
        $md_string = '[' . $string . '](' . $link .')';

        return array(
          $string => $md_string
        );
    }

    public function format_annotation_as_post($post_id, $json)
    {
        $yodie_post_field = config('options.ushahidi.survey_destination_field');


        $text = $json->text;

        $replacement_strings = [];
        foreach ($json->entities as $entity)
        {
            foreach ($entity as $mention)
            {
                if ($mention->indices && $mention->inst)
                {
                    // Duplicate words should only be replaced once
                    $replacement_strings = array_replace(
                                              $replacement_strings,
                                              $this->replaceTextWithMD(
                                                  $mention->indices,
                                                  $mention->inst,
                                                  $text
                                              )
                                            );
                }
            }
        }

        foreach($replacement_strings as $replace => $value)
        {
            $text = str_replace($replace, $value, $text);
        }

        // Currently return raw JSON
        $yodie_text = $text;

        return array(
            'id' => $post_id,
            $yodie_post_field => $yodie_text
        );
    }
}
