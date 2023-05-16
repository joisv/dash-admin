<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Episodes;
use App\Models\Genres;
use App\Models\Series;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'jois',
            'email' => 'animadmin@mail.com',
            'password' => bcrypt('password')
        ]);

        $titles = ['Naruto Shippuden', 'Death Note', 'Bleach', 'Pokemon', 'Dr Stone', ];
        $original = [' -ナルト- 疾風伝', '疾風伝', 'Bleach', 'Pokemon', 'Dr Stone', ];
        $slugs = ['naruto-shippuden', 'death-note', 'bleach', 'pokemon', 'dr-stone', ];
        $scores = ['8.9', '8', '9', '8.8', '8.5', ];
        $status = ['complete', 'complete', 'complete', 'complete', 'ongoing', ];
        $type = ['Tv', 'Tv', 'Tv', 'Tv', 'Tv', ];
        $genres = ['Actions', 'Comedy', 'Romance', 'School'];
        $genres_slug = ['actions', 'comedy', 'romance', 'school'];

        foreach ( $titles as $index => $title ) {
            Series::create([
                'title' => $title,
                'slug' => $slugs[$index],
                'score' => $scores[$index],
                'status' => $status[$index],
                'original_title' => $original[$index],
                'type' => $type[$index]
            ]);
        }

       foreach ($genres as $index => $title) {
            Genres::create([
                'names' => $title,
                'slug' => $genres_slug[$index]
            ]);
       }

        Episodes::create([
            'title' => 'death note episode 1',
            'series_id' => '2',
            'slug' => 'death-note-chapter-1'
        ]);
        Episodes::create([
            'title' => 'death note episode 2',
            'series_id' => '2',
            'slug' => 'death-note-episode-2'
        ]);
        Episodes::create([
            'title' => 'detektif connan episode 1',
            'series_id' => '4',
            'slug' => 'detektif-connan-episode-1'
        ]);
        Episodes::create([
            'title' => 'Episode 1',
            'series_id' => '3',
            'slug' => 'cobaa-1'
        ]);
    }
}
