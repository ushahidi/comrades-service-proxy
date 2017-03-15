<?php

namespace App\Jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\AnnotationController;

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
    protected $text

    /**
     * The post id
     *
     * @var int
     */
    protected $post_id

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($text, $post_id)
    {
        $this->text = $text;
        $this->post_id = $post_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        AnnotationController::runAnnotation($this->post_id, $this->text));
    }
}
