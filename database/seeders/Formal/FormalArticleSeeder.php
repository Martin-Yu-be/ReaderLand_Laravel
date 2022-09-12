<?php

namespace Database\Seeders\Formal;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FormalArticleSeeder extends Seeder
{
    public function run()
    {
        $json = file_get_contents(__DIR__.'/testcase.json');
        ['articles' => $articles] = json_decode($json, true);

        //TODO: Get AuthorName => id mapping
        $userName_id = [];
        $users = User::select(['id', 'name'])->orderBy('id')->limit(10)->get();
        foreach($users as $user){
            $userName_id[$user->name] = $user->id;
        }

        //TODO: Processing Articles
        $title_categories = [];
        for($i = 0; $i < count($articles); $i++){
            $articles[$i]['head'] = '0';

            //TODO: Processing Context
            $contextArr = explode('||', $articles[$i]['context']);
            // context example:
            // "This is paragraph 1.||This is paragraph 2.||This is paragraph 3."

            // Processing context string to json form string
            $contextJson = array();
            for($contextIdx = 0; $contextIdx < count($contextArr); $contextIdx++){
                if($contextIdx === count($contextArr) - 1){  // last paragraph doesn't have next paragraph
                    $next = null;
                } else {
                    $next = (string) ($contextIdx+1);
                }

                $contextJson[(string) $contextIdx] = [
                    'content' => $contextArr[$contextIdx],
                    'type' => 'string',
                    'next' => $next
                ];
            }
            $articles[$i]['context'] = json_encode($contextJson);

            // Setting userId
            $articles[$i]['user_id'] =  $userName_id[$articles[$i]['author']];
            unset($articles[$i]['author']);
            
            // Setting count
            $readCounts = random_int(0, 100);
            $articles[$i]['read_counts'] = $readCounts;
            $articles[$i]['like_counts'] = random_int(0, $readCounts);
            $articles[$i]['comment_counts'] = random_int(0, $readCounts);

            // Setting Category
            $title_categories[$articles[$i]['title']] = $articles[$i]['category'];
            unset($articles[$i]['category']);
        }

        // TODO: Insert Article
        shuffle($articles);
        $days = 10;
        $daysInSeconds = $days * 60 * 60 * 24;
        $fakeTime = time() - $daysInSeconds;
        $timeInterval = (int) $daysInSeconds / count($articles);

        foreach($articles as $article){
            Article::create([
                ...$article,
                'created_at' => $fakeTime,
                'updated_at' => $fakeTime
            ]);
            $fakeTime += $timeInterval;
        }

        //TODO: Fetch category_id mapping
        $category_id = [];
        $categories = Category::all();
        for($i = 0; $i < count($categories); $i++){
            ['id' => $id, 'category' => $category] = $categories[$i];
            $category_id[$category] = $id;
        }
        

        // TODO: Insert article_categories
        $articles = Article::all(['id', 'title']);
        $articles->each(function(Article $article) use($title_categories, $category_id) {
            ['title' => $title] = $article;
            
            $categoryIdArr = array_map(function($catElem) use($category_id){
                return $category_id[$catElem];
            }, $title_categories[$title]);

            $article->categories()->attach($categoryIdArr);
        });    
    }
}
