<?php

namespace App\Jobs;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

use ComradesYodieProxy\Models\Setting;

class UpdateUshahidiPost extends Job
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The object representing the post to be sent to the Ushahidi Platform API
     *
     * @var request
     */
    protected $post
    /**
     * Guzzle Http client to be used to make outbound Http requests
     *
     * @var GuzzleHttp::Client
     */
    $client
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
        $this->client = new GuzzleHttp\Client();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ushahidi_platform_url = Setting::find('ushahidi_platform_url');
        $ushahidi_platform_secret = Setting::find('ushahidi_platform_secret');
        $request = new Request('POST', $ushahidi_platform_url, $this->post);
        $response = $this->client->send($request);
    }
}
