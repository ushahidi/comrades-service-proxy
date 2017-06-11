<?php

namespace App\Jobs;

use App\Jobs\UpdateUshahidiPost;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

use GrahamCampbell\Throttle\Facades\Throttle;

use Log;

class RunYodieService extends RunProxyService
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $remaining = config('options.yodie.request_per_time_block');
        $time = config('options.yodie.quota_reset');

        $minutes = $time / 60;

        $throttler = Throttle::get([
                'ip'    => 'ushahidi',
                'route' => 'yodie',
            ], $remaining, $minutes);

        if (!$throttler->check()) {
            $this->release($time);
            return;
        }

        $this->runService($this->post);
    }

    public function requestProcessing($text)
    {
        try {
            $client = new Client();

            $yodie_api_url = config('options.yodie.api.url');
            $yodie_api_key = config('options.yodie.api.key');
            $yodie_api_secret = config('options.yodie.api.secret');

            $response = $client->request('POST', $yodie_api_url, [
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

            return $response;

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                Log::error(Psr7\str($e->getResponse()));
            }
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

    public function format_as_post($post, $response)
    {
        $json = json_decode($response->getBody());
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

        $yodie_text = $text;

        $destination_field_key = $post['destination_field_key'];

        $data = [
            'id' => $post['id'],
            'webhook_uuid' => $post['webhook_uuid'],
            'values' =>[]
        ];

        array_set($data, $destination_field_key, [$yodie_text]);

        return $data;
    }
}
