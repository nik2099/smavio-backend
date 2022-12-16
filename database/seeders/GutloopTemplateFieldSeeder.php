<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TemplateField;

class GutloopTemplateFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TemplateField::insert([
   
             [
                'name' => 'navbar background color',
                'value' => '#434343d1',
                'property' => 'background',
                'type' => 'css',
                'component' => 'navbar',
                'template_id' => 3
            ],
            
            [
                'name' => 'navbar text color',
                'value' => '#fff',
                'property' => 'color',
                'type' => 'css',
                'component' => 'navbar',
                'template_id' => 3
            ],
            
            [
                'name' => 'navbar active text color',
                'value' => '#f2745b',
                'property' => 'active color',
                'type' => 'css',
                'component' => 'navbar',
                'template_id' => 3
            ],
              [
                'name' => 'heading',
                'value' => 'Jetzt 10€ Shopping Gutschein sichern',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'welcome',
                'template_id' => 3
            ],
            
            [
                'name' => 'sub heading',
                'value' => 'Beantworte drei kurze Fragen und erhalte einen 10€ Gutschein für deinen nächsten Einkauf bei uns.',
                'type' => 'text',
                'property' => 'sub heading',
                'component' => 'welcome',
                'template_id' => 3
            ],
            
             [
                'name' => 'welcome image first',
                'value' => 'images/gutloop/1.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'welcome',
                'template_id' => 3
            ],
            
            [
                'name' => 'welcome image second',
                'value' => 'images/gutloop/2.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'welcome',
                'template_id' => 3
            ],
            
            [
                'name' => 'welcome image third',
                'value' => 'images/gutloop/3.jpg',
                'type' => 'image',
                'property' => 'image3',
                'component' => 'welcome',
                'template_id' => 3
            ],
            
            [
                'name' => 'button3 text',
                'value' => 'Lass uns starten',
                'type' => 'text',
                'property' => 'button3',
                'component' => 'welcome',
                'template_id' => 3
            ],
            
            [
                'name' => 'question1 heading',
                'value' => 'Was ist deine Lieblings-Jahreszeit?',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'question1',
                'template_id' => 3
            ],
            
            [
                'name' => 'question1 image first',
                'value' => 'images/gutloop/4.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'question1',
                'template_id' => 3
            ],
            
            [
                'name' => 'question1 image second',
                'value' => 'images/gutloop/5.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'question1',
                'template_id' => 3
            ],
            
            [
                'name' => 'question1 image first button text',
                'value' => 'Sommer',
                'type' => 'text',
                'property' => 'button1',
                'component' => 'question1',
                'template_id' => 3
            ],
            
            [
                'name' => 'question1 image second button text',
                'value' => 'Winter',
                'type' => 'text',
                'property' => 'button2',
                'component' => 'question1',
                'template_id' => 3
            ],
            
            [
                'name' => 'question2 heading',
                'value' => 'Welche Schmuckfarbe trägst du lieber?',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'question2',
                'template_id' => 3
            ],
            
            [
                'name' => 'question2 image first',
                'value' => 'images/gutloop/6.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'question2',
                'template_id' => 3
            ],
            
            [
                'name' => 'question2 image second',
                'value' => 'images/gutloop/7.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'question2',
                'template_id' => 3
            ],
            
            [
                'name' => 'question2 image first button text',
                'value' => 'Gold',
                'type' => 'text',
                'property' => 'button1',
                'component' => 'question2',
                'template_id' => 3
            ],
            
            [
                'name' => 'question2 image second button text',
                'value' => 'Silber',
                'type' => 'text',
                'property' => 'button2',
                'component' => 'question2',
                'template_id' => 3
            ],
            
            [
                'name' => 'question3 heading',
                'value' => 'Nach was für Produkten suchst du am meisten?',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'question3',
                'template_id' => 3
            ],
            
            [
                'name' => 'question3 image first',
                'value' => 'images/gutloop/8.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'question3',
                'template_id' => 3
            ],
            
            [
                'name' => 'question3 image second',
                'value' => 'images/gutloop/9.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'question3',
                'template_id' => 3
            ],
            
            [
                'name' => 'question3 image first button text',
                'value' => 'Schmuck',
                'type' => 'text',
                'property' => 'button1',
                'component' => 'question3',
                'template_id' => 3
            ],
            
            [
                'name' => 'question3 image second button text',
                'value' => 'Accessoires',
                'type' => 'text',
                'property' => 'button2',
                'component' => 'question3',
                'template_id' => 3
            ],
             [
                'name' => 'Common button text color',
                'value' => '#fff',
                'type' => 'css',
                'property' => 'button textcolor',
                'component' => 'common',
                'template_id' => 3
            ],
            
            [
                'name' => 'common button background',
                'value' => '#000',
                'type' => 'css',
                'property' => 'button background',
                'component' => 'common',
                'template_id' => 3
            ],
            
            [
                'name' => 'common background animation',
                'value' => 'circleanimation',
                'type' => 'text',
                'property' => 'animation',
                'component' => 'common',
                'template_id' => 3
            ],
            
          
            [
                'name' => 'Contact heading',
                'value' => 'Du hast es geschafft',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'contact',
                'template_id' => 3
            ],
           
      
           
        ]);
    }
}
