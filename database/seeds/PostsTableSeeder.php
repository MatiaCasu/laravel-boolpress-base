<?php

use Illuminate\Database\Seeder;
use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++){
        $newPost = new Post();

        $newPost->title = $faker->sentence();
        $newPost->slug = $slug = Str::slug($newPost->title, '-');
        $newPost->content = $faker-> text();
        $newPost->public = $faker->boolean();
        $newPost->image = $faker-> imageUrl(360, 360, null, true);
        $newPost->date = $faker->date(); 
        
        $newPost->save();
        }
    }
}
