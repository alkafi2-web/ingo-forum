<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'has_sub_menu',
        'parent_id',
        'type',
        'page_id',
        'route',
        'url',
        'media',
        'content',
        'position',
        'visibility',
    ];

    /**
     * Get the page associated with the menu.
     */
    public function page()
    {
        return $this->hasOne(Page::class, 'id', 'page_id');
    }
    
    /**
     * Check if the page has a menu.
     *
     * @return bool
     */
    public function hasMenu()
    {
        return $this->menu()->exists();
    }
    
    /**
     * get submenu.
     *
     * @return array
     */
    public function subMenus()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('position');
    }
}
