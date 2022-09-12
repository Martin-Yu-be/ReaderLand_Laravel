<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{

    public function definition()
    {
        $users = \App\Models\User::all(['id'])->toArray();

        $context = [];
        $length = random_int(5, 10);
        for($i=0; $i<$length; $i++){
            if($i === $length-1){
                $next = null;
            } else {
                $next = (string) $i+1;
            }

            $context[(string) $i] = [
                'next' => $next,
                'type' => 'string',
                'content' => fake()->paragraph(random_int(2, 4)),
            ];
        }

        return [
            'user_id' => $users[array_rand($users, 1)]['id'],
            'title' => fake()->sentence(),
            'context' => json_encode($context),
            'head' => 0,
            'preview' => fake()->paragraph(1),
            'read_counts' => 0,
            'like_counts' => 0,
            'comment_counts' => 0,
        ];
    }
}
