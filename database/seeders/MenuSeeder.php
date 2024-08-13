<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::truncate(); // Optional: Clears existing data

        $menus = [
            [
                'name' => 'About Us',
                'type' => 'url',
                'url' => '#',
                'children' => [
                    ['name' => 'Why INGO Forum', 'type' => 'url', 'url' => '#'],
                    ['name' => 'What we do.', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Governance and structure', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Values and principles', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Executive Committee members', 'type' => 'url', 'url' => '#'],
                    ['name' => 'FAQs', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Contact us', 'type' => 'url', 'url' => '#'],
                ],
            ],
            [
                'name' => 'Members',
                'type' => 'url',
                'url' => '#',
                'children' => [
                    ['name' => 'Our members', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Membership Criteria', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Become a member/ Join us', 'type' => 'url', 'url' => '#'],
                ],
            ],
            [
                'name' => 'Press and Media',
                'type' => 'url',
                'url' => '#',
                'children' => [
                    ['name' => 'Latest News', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Photos Gallery', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Video Gallery', 'type' => 'url', 'url' => '#'],
                    ['name' => 'National Events (calendar type)', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Blogs', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Forum', 'type' => 'url', 'url' => '#'],
                ],
            ],
            [
                'name' => 'Resources',
                'type' => 'url',
                'url' => '#',
                'children' => [
                    ['name' => 'Policy/ Strategies', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Reports', 'type' => 'url', 'url' => '#'],
                    ['name' => 'Publications', 'type' => 'url', 'url' => '#'],
                ],
            ],
            [
                'name' => 'Contact',
                'type' => 'url',
                'url' => '#',
                'children' => [],
            ],
        ];

        $menuIds = $this->insertMenus($menus);

        // Update parent_id for submenus
        $this->updateMenuParents($menus, $menuIds);
    }

    private function insertMenus(array $menus, $parentId = 0)
    {
        $menuIds = [];
        foreach ($menus as $index => $menuData) {
            $menu = Menu::create([
                'name' => $menuData['name'],
                'parent_id' => $parentId, // Initially set to null for top-level menus
                'type' => $menuData['type'],
                'url' => $menuData['url'],
                'position' => $index,
                'visibility' => 1,
            ]);

            $menuIds[$menuData['name']] = $menu->id;

            if (!empty($menuData['children'])) {
                $menuIds = array_merge($menuIds, $this->insertMenus($menuData['children'], $menu->id));
            }
        }
        return $menuIds;
    }

    private function updateMenuParents(array $menus, array $menuIds, $parentId = 0)
    {
        foreach ($menus as $menuData) {
            $menu = Menu::find($menuIds[$menuData['name']]);
            $menu->parent_id = $parentId;
            $menu->has_sub_menu = !empty($menuData['children']) ? 1 : 0;
            $menu->save();

            if (!empty($menuData['children'])) {
                $this->updateMenuParents($menuData['children'], $menuIds, $menu->id);
            }
        }
    }
}
