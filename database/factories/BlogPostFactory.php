<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
//use Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost::class;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{

   // protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(3, 8),  true);
        $txt   = $this->faker->realtext(rand(3000, 8000));
        $isPublished    = rand(1, 5) > 1;

        return [



            'category_id'   => rand(1, 11),
            'user_id'   => (rand(1, 5) == 5)    ? 1 : 2,
            'title'     => $title,
            'slug'  =>  Str::of($title)->slug(),
            'excerpt' => $this->faker->text(rand(40, 100)),
            'content_raw'   => $txt,
            'content_html'  => $txt,
            'is_published'  => $isPublished,
            'published_at'  => $isPublished ? $this->faker->dateTimeBetween('-2 months', '-1 days'): null,


        ];
    }
}
