<?php

namespace App\Jobs;

use App\Security\RequestValidator;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Log;

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
        $ushahidi_platform_url = config('options.ushahidi.platform_api_url') . $this->post['id'];
        $requestValidator = new RequestValidator(config('options.ushahidi.shared_secret'));

        $this->post['api_key'] = config('options.ushahidi.platform_api_key');

        $signature = $requestValidator->sign($ushahidi_platform_url, json_encode($this->post));

        $client = new Client();
        try {
            $response = $client->request('PUT', $ushahidi_platform_url, [
                'headers' => [
                     'Accept' => 'application/json',
                     'X-Ushahidi-Signature' => $signature,
                ],
                'json' => $this->post
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                Log::error(Psr7\str($e->getResponse()));
            }
        }
    }
}
