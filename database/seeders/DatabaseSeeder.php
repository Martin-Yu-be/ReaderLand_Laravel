<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
                // TODO: Generate Categories
                $categories = [
                    '政治與評論',
                    '國際時事',
                    '電影戲劇',
                    '投資理財',
                    '職場產業',
                    '閱讀書評',
                    '創作',
                    'ACG',
                    '文化生活',
                    '旅行美食',
                    '音樂藝文',
                    '健康與情感',
                    '寵物',
                    '個人成長',
                    '親子與教育',
                    '運動',
                    '科學',
                    '心理',
                ];
                foreach($categories as $category){
                    \App\Models\Category::create([
                        'category' => $category
                    ]);
                }


        //TODO: Decode json data
        $json = file_get_contents(__DIR__.'/testcase.json');
        ["authors" => $authors, 'articles' => $articles] = json_decode($json, true);

        
        //TODO: Seed Authors info into users table
        foreach($authors as $key => $author){
            User::create([
                'email' => 'author_'.$key.'@ReaderLand.com',
                'password' => bcrypt('password'),
                ...$author,
            ]);
        }
        
        $users = User::all();
        foreach($users as $user){
            $userName_id[$user->name] = $user->id;
        }

        $title_categories = array();
        // TODO: Process Article
        for($i = 0; $i < count($articles); $i++){
            $articles[$i]['head'] = '0';
            // Processing Context
            $contextArr = explode('||', $articles[$i]['context']);
            $contextJson = array();
            foreach($contextArr as $key => $content){
                $next = $key == count($contextArr) - 1 ? null: (string) ($key+1);
                $contextJson[(string) $key] = [
                    'content' => $content,
                    'type' => 'stirng',
                    'next' => $next
                ];
            }
            $articles[$i]['context'] = json_encode($contextJson);

            // Setting userId
            $articles[$i]['user_id'] =  $userName_id[$articles[$i]['author']];
            unset($articles[$i]['author']);
            
            $readCounts = random_int(0, 100);
            $articles[$i]['read_counts'] = $readCounts;
            $articles[$i]['like_counts'] = random_int(0, $readCounts);
            $articles[$i]['comment_counts'] = random_int(0, $readCounts);

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

        // TODO: Organize categories into category => id array
        $category_id = array();
        $categories = Category::all();

        foreach($categories as ['category' => $cat, 'id' => $id]){
            $category_id[$cat] = $id;
        }

        // TODO: Turn cat string into cat id in $title_categories
        foreach($title_categories as $key => $cat){
            $title_categories[$key] = array_map(fn($category) => $category_id[$category], $cat);
        }
        // print_r($title_categories);

        // TODO: Insert article_categories
        $articles = Article::all(['id', 'title']);
        $articles->each(function($article) use($title_categories) {
            ['title' => $title, 'id' => $id] = $article;
            $article->categories()->attach($title_categories[$title]);
        });
        
        // \App\Models\User::factory(5)->create();



    }
}
