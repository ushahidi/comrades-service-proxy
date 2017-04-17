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

      $source_field_key = $post['source_field_key'];
      $response = $this->requestProcessing(array_get($post, $source_field_key));

      $post = $this->format_as_post($post, json_decode($response->getBody()));

      dispatch(new UpdateUshahidiPost($post));
    }

    abstract protected function requestProcessing($text);

    abstract protected function format_as_post($post, $json);
}
