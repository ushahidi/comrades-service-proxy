<?php

namespace App\Jobs;

use App\Jobs\UpdateUshahidiPost;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

use Log;

abstract class RunProxyService extends Job
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The post id
     *
     * @var int
     */
    protected $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->runService($this->post);
    }

    public function runService($post)
    {
      Log::debug(print_r($post, true));
      $source_field_uuid = $post['source_field_uuid'];
      $response = $this->requestProcessing($post['values'][$source_field_uuid]);

      $post = $this->format_as_post($post, json_decode($response->getBody()));

      dispatch(new UpdateUshahidiPost($post));
    }

    abstract protected function requestProcessing($text);

    abstract protected function format_as_post($post, $json);
}
