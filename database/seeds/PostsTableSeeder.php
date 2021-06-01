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


        for ($i = 0; $i < 5; $i++){

            $image_name = Str::random(40) . '.jpg';

            $newPost = new Post();

            $newPost->title = $faker->sentence();
            $newPost->slug = $slug = Str::slug($newPost->title, '-');
            $newPost->content = $faker-> text();
            $newPost->public = $faker->boolean();
            $newPost->date = $faker->date(); 

            if ( $this->saveRandomImage('public/storage/images/' . $image_name) ) {
                $newPost->image = 'images/' . $image_name;
            }
            
            $newPost->save();
        }

    }

    
    protected function saveRandomImage(string $absolutePath, int $width = 640, int $height = 480): bool
    {
        // Create a blank image:
        $im = imagecreatetruecolor($width, $height);
        // Add light background color:
        $bgColor = imagecolorallocate($im, rand(100, 255), rand(100, 255), rand(100, 255));
        imagefill($im, 0, 0, $bgColor);

        // Save the image:
        $isGenerated = imagejpeg($im, $absolutePath);

        // Free up memory:
        imagedestroy($im);

        return $isGenerated;
    }
}
