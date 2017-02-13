<?php

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        //truncate existing data
        DB::table('themes')->truncate();

        Theme::create([
            'name' => 'SMS happy',
            'menu_bg_color' => '#0f85ad',
            'menu_active_bg_color' => '#dd823b',
            'menu_active_border_right_color' => '#c2185b',
            'menu_color' => '#ffffff',
            'menu_active_color' => '#ffffff',
            'frontend_menu_bg_color' => '#347f99',
            'frontend_bg_color' => '#ffffff',
            'frontend_text_color' => '#c2185b',
            'frontend_link_color' => '#76abbc'
        ]);

        Theme::create([
            'name' => 'Default',
            'menu_bg_color' => '#333333',
            'menu_active_bg_color' => '#222222',
            'menu_active_border_right_color' => '#2ea2cc',
            'menu_color' => '#ffffff',
            'menu_active_color' => '#ffffff',
            'frontend_menu_bg_color' => '#333333',
            'frontend_bg_color' => '#ffffff',
            'frontend_text_color' => '#333333',
            'frontend_link_color' => '#2ea2cc'
        ]);

        Theme::create([
            'name' => 'Light',
            'menu_bg_color' => '#e5e5e5',
            'menu_active_bg_color' => '#999999',
            'menu_active_border_right_color' => '#04a4cc',
            'menu_color' => '#333333',
            'menu_active_color' => '#333333',
            'frontend_menu_bg_color' => '#e5e5e5',
            'frontend_bg_color' => '#ffffff',
            'frontend_text_color' => '#999999',
            'frontend_link_color' => '#04a4cc'
        ]);

        Theme::create([
            'name' => 'Blue',
            'menu_bg_color' => '#4796b3',
            'menu_active_bg_color' => '#096484',
            'menu_active_border_right_color' => '#74b6ce',
            'menu_color' => '#ffffff',
            'menu_active_color' => '#ffffff',
            'frontend_menu_bg_color' => '#4796b3',
            'frontend_bg_color' => '#ffffff',
            'frontend_text_color' => '#333333',
            'frontend_link_color' => '#4796b3'
        ]);

        Theme::create([
            'name' => 'Coffee',
            'menu_bg_color' => '#59524c',
            'menu_active_bg_color' => '#c7a589',
            'menu_active_border_right_color' => '#9ea476',
            'menu_color' => '#ffffff',
            'menu_active_color' => '#ffffff',
            'frontend_menu_bg_color' => '#59524c',
            'frontend_bg_color' => '#ffffff',
            'frontend_text_color' => '#59524c',
            'frontend_link_color' => '#c7a589'
        ]);

        Theme::create([
            'name' => 'Ectoplasm',
            'menu_bg_color' => '#413256',
            'menu_active_bg_color' => '#a3b745',
            'menu_active_border_right_color' => '#d46f15',
            'menu_color' => '#ffffff',
            'menu_active_color' => '#ffffff',
            'frontend_menu_bg_color' => '#413256',
            'frontend_bg_color' => '#ffffff',
            'frontend_text_color' => '#a3b745',
            'frontend_link_color' => '#d46f15'
        ]);

        Theme::create([
            'name' => 'Midnight',
            'menu_bg_color' => '#363b3f',
            'menu_active_bg_color' => '#e14d43',
            'menu_active_border_right_color' => '#69a8bb',
            'menu_color' => '#ffffff',
            'menu_active_color' => '#ffffff',
            'frontend_menu_bg_color' => '#363b3f',
            'frontend_bg_color' => '#ffffff',
            'frontend_text_color' => '#363b3f',
            'frontend_link_color' => '#69a8bb'
        ]);

        Theme::create([
            'name' => 'Ocean',
            'menu_bg_color' => '#738e96',
            'menu_active_bg_color' => '#9ebaa0',
            'menu_active_border_right_color' => '#aa9d88',
            'menu_color' => '#ffffff',
            'menu_active_color' => '#ffffff',
            'frontend_menu_bg_color' => '#738e96',
            'frontend_bg_color' => '#ffffff',
            'frontend_text_color' => '#738e96',
            'frontend_link_color' => '#9ebaa0'
        ]);

        Theme::create([
            'name' => 'Sunrise',
            'menu_bg_color' => '#cf4944',
            'menu_active_bg_color' => '#dd823b',
            'menu_active_border_right_color' => '#ccaf0b',
            'menu_color' => '#ffffff',
            'menu_active_color' => '#ffffff',
            'frontend_menu_bg_color' => '#cf4944',
            'frontend_bg_color' => '#ffffff',
            'frontend_text_color' => '#cf4944',
            'frontend_link_color' => '#dd823b'
        ]);

        Eloquent::reguard();
    }
}