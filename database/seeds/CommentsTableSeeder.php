<?php

use Illuminate\Database\Seeder;
use App\Comment;
use Faker\Generator as Faker; // Alias
use App\Post;


class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $publicPost= Post::where('public', true)->get();

        foreach ($publicPost as $post){

            for ($i=0; $i < rand(0, 5); $i++) { 
                $newComment = new Comment();

                if (rand(0,1)) {
                    $newComment->author = $faker->name();
                }
                $newComment->content = $faker->text();
                $newComment->post_id = $post->id;    

                $newComment->save();
            }
        }
    }
}
