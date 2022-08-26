<?php

namespace Database\Seeders;

use App\Models\Posts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post1Title = 'Leuke dingen doen';
        $post1Content = 'Word jij onze nieuw logistiek topper? Of kom je ons kantoor versterken als één van onze developmen specialisten?';

        $post2Title = 'Medior PHP Developer';
        $post2Content = 'Wij zoeken een PHP devel(t)op(p)er die meer kan en wil dan alleen maar webshops bouwen. Onze webshop is namelijk al lang niet meer "de webshop".';

        $post3Title = 'Medior Magento Developer';
        $post3Content = 'Met 2 awards op zak voor de beste webwinkel in de categorie Tuin én nummer 1 in de lijst van snelstgroeiende e-commerce bedrijven gaan we lekker met onze webshop!';

        Posts::create([
            'slug' => strtolower(str_replace(' ', '-', $post1Title)),
            'title' => $post1Title,
            'content' => $post1Content,
            'enabled' => -1
        ]);

        Posts::create([
            'slug' => strtolower(str_replace(' ', '-', $post2Title)),
            'title' => $post2Title,
            'content' => $post2Content,
            'enabled' => 0
        ]);

        Posts::create([
            'slug' => strtolower(str_replace(' ', '-', $post3Title)),
            'title' => $post3Title,
            'content' => $post3Content,
            'enabled' => -1
        ]);
    }
}
