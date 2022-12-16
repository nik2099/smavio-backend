<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TemplateField;

class TemplateFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TemplateField::insert([
        	// dotup
        	
            [
                'name' => 'navbar background color',
                'value' => '#434343d1',
                'property' => 'background',
                'type' => 'css',
                'component' => 'navbar',
                'template_id' => 1
            ],
            
            [
                'name' => 'navbar text color',
                'value' => '#fff',
                'property' => 'color',
                'type' => 'css',
                'component' => 'navbar',
                'template_id' => 1
            ],
            
            [
                'name' => 'navbar active text color',
                'value' => '#f2745b',
                'property' => 'active color',
                'type' => 'css',
                'component' => 'navbar',
                'template_id' => 1
            ],
            [
                'name' => 'heading',
                'value' => 'Bist du analog oder digital?',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'welcome',
                'template_id' => 1
            ],
            
            [
                'name' => 'sub heading',
                'value' => 'Welche Uhr gefällt dir besser? Stimme jetzt ab und gewinne mit etwas Glück das Abenteuer deines Lebens.',
                'type' => 'text',
                'property' => 'sub heading',
                'component' => 'welcome',
                'template_id' => 1
            ],
            
             [
                'name' => 'welcome image first',
                'value' => 'images/dotup/schuh1.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'welcome',
                'template_id' => 1
            ],
            
            [
                'name' => 'welcome image second',
                'value' => 'images/dotup/schuh2-unsplash.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'welcome',
                'template_id' => 1
            ],
            
              [
                'name' => 'button1 text',
                'value' => 'Analog, was sonst',
                'type' => 'text',
                'property' => 'button1',
                'component' => 'welcome',
                'template_id' => 1
            ],
            
              [
                'name' => 'button2 text',
                'value' => 'Digital ist mein Ding',
                'type' => 'text',
                'property' => 'button2',
                'component' => 'welcome',
                'template_id' => 1
            ],
            
            [
                'name' => 'Common button text color',
                'value' => '#fff',
                'type' => 'css',
                'property' => 'button textcolor',
                'component' => 'common',
                'template_id' => 1
            ],
            
          
            [
                'name' => 'common button background',
                'value' => '#000',
                'type' => 'css',
                'property' => 'button background',
                'component' => 'common',
                'template_id' => 1
            ],
            
            [
                'name' => 'common background animation',
                'value' => 'circleanimation',
                'type' => 'text',
                'property' => 'animation',
                'component' => 'common',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image1 heading',
                'value' => 'G-Shock analog',
                'type' => 'text',
                'property' => 'image1 heading',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image1 sub heading',
                'value' => 'Abenteuer',
                'type' => 'text',
                'property' => 'image1 subheading',
                'component' => 'product',
                'template_id' => 1
            ],
            
            
            [
                'name' => 'product image1 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image1 description',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image2 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image2 subheading',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image2 sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image2 title',
                'component' => 'product',
                'template_id' => 1
            ],
            
            
            [
                'name' => 'product image2 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image2 description',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image3 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image3 heading',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image3 sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image3 subheading',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image3 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image3 description',
                'component' => 'product',
                'template_id' => 1
            ],
            
             [
                'name' => 'product image4 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image4 heading',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image4 sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image4 subheading',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image4 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image4 description',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image first',
                'value' => 'images/dotup/schuh1.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image second',
                'value' => 'images/dotup/schuh3.png',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image third',
                'value' => 'images/dotup/schuh4.png',
                'type' => 'image',
                'property' => 'image3',
                'component' => 'product',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image fourth',
                'value' => 'images/dotup/schuh5.jpg',
                'type' => 'image',
                'property' => 'image4',
                'component' => 'product',
                'template_id' => 1
            ],
            
             [
                'name' => 'product image1 heading',
                'value' => 'G-Shock analog',
                'type' => 'text',
                'property' => 'image1 heading',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image1 sub heading',
                'value' => 'Abenteuer',
                'type' => 'text',
                'property' => 'image1 subheading',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            
            [
                'name' => 'product image1 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image1 description',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image2 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image2 subheading',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image2 sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image2 title',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            
            [
                'name' => 'product image2 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image2 description',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image3 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image3 heading',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image3 sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image3 subheading',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image3 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image3 description',
                'component' => 'product2',
                'template_id' => 1
            ],
            
             [
                'name' => 'product image4 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image4 heading',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image4 sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image4 subheading',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image4 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image4 description',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image first',
                'value' => 'images/dotup/schuh2-unsplash.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image second',
                'value' => 'images/dotup/schuh3.png',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image third',
                'value' => 'images/dotup/schuh4.png',
                'type' => 'image',
                'property' => 'image3',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'product image fourth',
                'value' => 'images/dotup/schuh5.jpg',
                'type' => 'image',
                'property' => 'image4',
                'component' => 'product2',
                'template_id' => 1
            ],
            
            [
                'name' => 'gallery image first',
                'value' => 'images/dotup/schuh1.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'gallery',
                'template_id' => 1
            ],
            
            [
                'name' => 'gallery image second',
                'value' => 'images/dotup/schuh2-unsplash.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'gallery',
                'template_id' => 1
            ],
            
            [
                'name' => 'gallery image third',
                'value' => 'images/dotup/schuh3.jpg',
                'type' => 'image',
                'property' => 'image3',
                'component' => 'gallery',
                'template_id' => 1
            ],
            
            [
                'name' => 'gallery image fourth',
                'value' => 'images/dotup/schuh4.jpg',
                'type' => 'image',
                'property' => 'image4',
                'component' => 'gallery',
                'template_id' => 1
            ],
            
            [
                'name' => 'gallery image fifth',
                'value' => 'images/dotup/schuh5.jpg',
                'type' => 'image',
                'property' => 'image5',
                'component' => 'gallery',
                'template_id' => 1
            ],
            
     
            
            [
                'name' => 'Contact heading',
                'value' => 'Challenge accepted?',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'contact',
                'template_id' => 1
            ],
           
            // presentation
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
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'welcome',
                'template_id' => 2
            ],
            
            [
                'name' => 'sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'sub heading',
                'component' => 'welcome',
                'template_id' => 2
            ],
            
             [
                'name' => 'welcome image first',
                'value' => 'images/schuh1.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'welcome',
                'template_id' => 2
            ],
            
            [
                'name' => 'welcome image second',
                'value' => 'images/schuh2.jpg',
                'type' => 'image',
                'property' => 'image2',
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
                'name' => 'product image1 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image1 heading',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image1 sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image1 subheading',
                'component' => 'product',
                'template_id' => 2
            ],
            
            
            [
                'name' => 'product image1 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image1 description',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image2 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image2 subheading',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image2 sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image2 title',
                'component' => 'product',
                'template_id' => 2
            ],
            
            
            [
                'name' => 'product image2 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image2 description',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image3 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image3 heading',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image3 sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image3 subheading',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image3 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image3 description',
                'component' => 'product',
                'template_id' => 2
            ],
            
             [
                'name' => 'product image4 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image4 heading',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image4 sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image4 subheading',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image4 description',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'image4 description',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image first',
                'value' => 'images/schuh1.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image second',
                'value' => 'images/schuh2.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image third',
                'value' => 'images/schuh3.jpg',
                'type' => 'image',
                'property' => 'image3',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'product image fourth',
                'value' => 'images/schuh4.jpg',
                'type' => 'image',
                'property' => 'image4',
                'component' => 'product',
                'template_id' => 2
            ],
            
            [
                'name' => 'gallery image first',
                'value' => 'images/dotup/schuh1.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'gallery image second',
                'value' => 'images/dotup/schuh2.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'gallery image third',
                'value' => 'images/dotup/schuh3.png',
                'type' => 'image',
                'property' => 'image3',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'gallery image fourth',
                'value' => 'images/dotup/schuh4.png',
                'type' => 'image',
                'property' => 'image4',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'gallery image fifth',
                'value' => 'images/schuh5.jpg',
                'type' => 'image',
                'property' => 'image5',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'gallery',
                'template_id' => 2
            ],
            
            [
                'name' => 'sub heading',
                'value' => 'Finde den perfekten Schuh',
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
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'contact',
                'template_id' => 2
            ],
            
            
            // umfrage
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
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'welcome',
                'template_id' => 3
            ],
            
            [
                'name' => 'sub heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'sub heading',
                'component' => 'welcome',
                'template_id' => 3
            ],
            
             [
                'name' => 'welcome image first',
                'value' => 'images/schuh1.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'welcome',
                'template_id' => 3
            ],
            
            [
                'name' => 'welcome image second',
                'value' => 'images/schuh2.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'welcome',
                'template_id' => 3
            ],
            
            [
                'name' => 'welcome image third',
                'value' => 'images/schuh2.jpg',
                'type' => 'image',
                'property' => 'image3',
                'component' => 'welcome',
                'template_id' => 3
            ],
            
            
            [
                'name' => 'question1 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'question1',
                'template_id' => 3
            ],
            
            [
                'name' => 'question1 image first',
                'value' => 'images/schuh2.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'question1',
                'template_id' => 3
            ],
            
            [
                'name' => 'question1 image second',
                'value' => 'images/schuh2.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'question1',
                'template_id' => 3
            ],
            
            [
                'name' => 'question1 image first button text',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'button1',
                'component' => 'question1',
                'template_id' => 3
            ],
            
            [
                'name' => 'question1 image second button text',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'button2',
                'component' => 'question1',
                'template_id' => 3
            ],
            
            [
                'name' => 'question2 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'question2',
                'template_id' => 3
            ],
            
            [
                'name' => 'question2 image first',
                'value' => 'images/schuh2.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'question2',
                'template_id' => 3
            ],
            
            [
                'name' => 'question2 image second',
                'value' => 'images/schuh2.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'question2',
                'template_id' => 3
            ],
            
            [
                'name' => 'question2 image first button text',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'button1',
                'component' => 'question2',
                'template_id' => 3
            ],
            
            [
                'name' => 'question2 image second button text',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'button2',
                'component' => 'question2',
                'template_id' => 3
            ],
            
            [
                'name' => 'question3 heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'question3',
                'template_id' => 3
            ],
            
            [
                'name' => 'question3 image first',
                'value' => 'images/schuh2.jpg',
                'type' => 'image',
                'property' => 'image1',
                'component' => 'question3',
                'template_id' => 3
            ],
            
            [
                'name' => 'question3 image second',
                'value' => 'images/schuh2.jpg',
                'type' => 'image',
                'property' => 'image2',
                'component' => 'question3',
                'template_id' => 3
            ],
            
            [
                'name' => 'question3 image first button text',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'button1',
                'component' => 'question3',
                'template_id' => 3
            ],
            
            [
                'name' => 'question3 image second button text',
                'value' => 'Finde den perfekten Schuh',
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
                'name' => 'Contact heading',
                'value' => 'Finde den perfekten Schuh',
                'type' => 'text',
                'property' => 'heading',
                'component' => 'contact',
                'template_id' => 3
            ],
           
      
           
        ]);
    }
}
