<?php

namespace App\Jobs;

use App\Jobs\UpdateUshahidiPost;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

use Log;

class RunYodieService extends RunProxyService
{

    public function requestProcessing($text)
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

    public function format_as_post($post, $json)
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

        $yodie_text = $text;

        $destination_field_uuid = $post['destination_field_uuid'];

        $post['values'][$destination_field_uuid] = $yodie_text;

        return $post;
    }
}