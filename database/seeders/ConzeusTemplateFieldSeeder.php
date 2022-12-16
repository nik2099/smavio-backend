<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TemplateField;

class ConzeusTemplateFieldSeeder extends Seeder
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
                'template_id' => 2
            ],
            
            [
                'name' => 'navbar text color',
                'value' => '#fff',
                'property' => 'color',
                'type' => 'css',
                'component' => 'navbar',
                'template_id' => 2
            ],
            
            [
                'name' => 'navbar active text color',
                'value' => '#f2745b',
                'property' => 'active color',
                'type' => 'css',
                'component' => 'navbar',
                'template_id' => 2
            ],
            [
                'name' => 'heading',
                'value' => 'Curology',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'welcome',
                'template_id' => 2
            ],
            
            [
                'name' => 'sub heading',
                'value' => 'Die maßgeschneiderte Hautpflege, die wirklich funktioniert. Überzeug dich selbst!',
                'type' => 'text',
                'property' => 'sub heading',
                'component' => 'welcome',
                'template_id' => 2
            ],
            
             [
                'name' => 'welcome image first',
                'value' => 'images/conzeus/1.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'welcome',
                'template_id' => 2
            ],
            

            
            [
                'name' => 'button3 text',
                'value' => 'Mehr erfahren',
                'type' => 'text',
                'property' => 'button3',
                'component' => 'welcome',
                'template_id' => 2
            ],
            
             [
                'name' => 'Common button text color',
                'value' => '#fff',
                'type' => 'css',
                'property' => 'button textcolor',
                'component' => 'common',
                'template_id' => 2
            ],
            
            [
                'name' => 'common button background',
                'value' => '#000',
                'type' => 'css',
                'property' => 'button background',
                'component' => 'common',
                'template_id' => 2
            ],
            
            [
                'name' => 'common background animation',
                'value' => 'circleanimation',
                'type' => 'text',
                'property' => 'animation',
                'component' => 'common',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image1 heading',
                'value' => 'Was Curology besonders macht',
                'type' => 'text',
                'property' => 'image1 heading',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image1 sub heading',
                'value' => 'Wir behandeln dich persönlich',
                'type' => 'text',
                'property' => 'image1 subheading',
                'component' => 'product',
                'template_id' => 2
            ],
            
            
            [
                'name' => 'product image1 description',
                'value' => 'Maßgeschneiderte Zutaten nur für dich. Kein Drogerieprodukt ist so individualisiert. Wir verwenden deine Fotos, deine Geschichte und deine Ziele, um leistungsstarke Wirkstoffe nur für dich auszuwählen. Von gelegentlichen Pickeln bis hin zu heftigen Pickeln – unsere einfache Creme zur täglichen Anwendung deckt Sie ab.',
                'type' => 'text',
                'property' => 'image1 description',
                'component' => 'product',
                'template_id' => 2
            ],
            
            
            [
                'name' => 'product image first',
                'value' => 'images/conzeus/2.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'product',
                'template_id' => 2
            ],
            
              
            [
                'name' => 'product image second',
                'value' => 'images/conzeus/3.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'product',
                'template_id' => 2
            ],
            
              [
                'name' => 'product image third',
                'value' => 'images/conzeus/4.jpg',
                'type' => 'image',
                'property' => 'image3',
                'component' => 'product',
                'template_id' => 2
            ],
            
   
            
            [
                'name' => 'gallery image first',
                'value' => 'images/conzeus/6.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'gallery image second',
                'value' => 'images/conzeus/7.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'gallery image third',
                'value' => 'images/conzeus/8.jpg',
                'type' => 'image',
                'property' => 'image3',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'gallery image fourth',
                'value' => 'images/conzeus/9.jpg',
                'type' => 'image',
                'property' => 'image4',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'gallery image fifth',
                'value' => 'images/conzeus/9.jpg',
                'type' => 'image',
                'property' => 'image5',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'heading',
                'value' => 'Genau die richtige Hautpflege',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'sub heading',
                'value' => 'Ganz egal ob Pickel oder Akne, unsere Cremes helfen bei Pickeln, Akne, Mitessern, Falten und vielem mehr.',
                'type' => 'text',
                'property' => 'sub heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'Image heading first',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image_first_heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
             [
                'name' => 'Image Sub heading first',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image_first_sub_heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
             [
                'name' => 'Image heading second',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image_second_heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
             [
                'name' => 'Image Sub heading second',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image_second_sub_heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'Image heading third',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image_third_heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
             [
                'name' => 'Image Sub heading third',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image_third_sub_heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
             [
                'name' => 'Image heading fourth',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image_fourth_heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
             [
                'name' => 'Image Sub heading fourth',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image_fourth_sub_heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
             [
                'name' => 'Image heading fifth',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image_fifth_heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
             [
                'name' => 'Image Sub heading fifth',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image_fifth_sub_heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'Contact heading',
                'value' => 'Mit diesen Tipps zu schöner Haut',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'contact',
                'template_id' => 2
            ],
            
         
        ]);
    }
}
