
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\Annotate;
use App\Jobs\UpdateUshahidiPlatform;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class AnnotationController extends Controller
{

    public function annotate(Request $request)
    {
        $source_field = config('survey_source_field');
        dispatch(new Annotate($request->input('id'), $request->input($source_field)));

        return;
    }

    public function runAnnotation($post_id, $text)
    {
      $response = $this->requestAnnotation($text);
      $post = $this->format_annotation_as_post($post_id, $response)

      dispatch(new UpdateUshahidiPlatform($post));
    }

    public function requestAnnotation($text)
    {
        try {

            $client = new GuzzleHttp\Client();

            $yodie_api_url = config('yodie.api_url');
            $yodie_api_key = config('yodie.api.key');
            $yodie_api_secret = config('yodie.api.secret');
            $request = new Request('POST', $yodie_api_url, $text, ['auth' => [$yodie_api_key, $yodie_api_secret]);

            return $this->client->send($request);

        } catch (YodieRequestFail $e) {

        }
    }

    public function format_annotation_as_post($post_id, $data)
    {
        $yodie_post_field = config('ushahidi.survey_destination_field');

        // Currently return raw JSON
        $yodie_text = $data;

        return json_encode(array(
            'id' => $post_id,
            $yodie_post_field => $yodie_text
        ));
    }
}
