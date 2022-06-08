<?php 

namespace App\Models;

use Illuminate\Database\ModelNotFoundException;
use Illuminate\Support\Facades\File;

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
        
        if(! file_exists($path = resource_path("posts/{$slug}.html")))
        
        {
            throw new ModelNotFoundException();
        }

        return cache() -> remember("posts.{$slug}",1200, fn() => file_get_contents($path));

    }


    public static function all()
    {

        return collect(File::files(resource_path("posts")))
            ->map(fn($file) => YamlFontMatter::parseFile($file))
            ->map(fn($document)=> new Post(
                $document -> $title,
                $document -> $excerpt,
                $document -> $date,
                $document -> body(),
                $document -> $slug

            ));
    }
}