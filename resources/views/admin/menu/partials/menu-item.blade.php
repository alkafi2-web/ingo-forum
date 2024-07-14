<li id="menu-{{ $menu->id }}" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded">
    <div class="draggable-menu-item">
        <span class="draggable-menu-name">{{ $menu->name }}</span>
        <div>
            <button class="btn btn-danger btn-sm">x</button>
            <button class="btn btn-success btn-sm">edit</button>
        </div>
    </div>
    @if ($menu->subMenus->count())
        <ul class="draggable-sub-menu-container">
            @foreach ($menu->subMenus as $subMenu)
                @include('admin.menu.partials.menu-item', ['menu' => $subMenu])
            @endforeach
        </ul>
    @endif
</li>
