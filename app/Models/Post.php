<?php 

namespace App\Models;

use Illuminate\Database\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;
class Post
{

    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    public function __construct($title,$excerpt,$body, $date, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->body = $body;
        $this->date = $date;
        $this->slug = $slug;
    }

    public static function find($slug)
    {
       return static::all()->firstWhere('slug', $slug);
    }


    public static function all()
    {

        return collect(File::files(resource_path("posts")))
            ->map(fn($file) => YamlFrontMatter::parseFile($file))
            ->map(fn($document) => new Post(
                $document -> title,
                $document -> excerpt,
                $document -> date,
                $document -> body(),
                $document -> slug

            ));
    }
}