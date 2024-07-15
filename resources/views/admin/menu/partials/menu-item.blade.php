<li data-id="{{ $menu->id }}" id="menu-{{ $menu->id }}" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded">
    <div class="draggable-menu-item">
        <span class="draggable-menu-name"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i> <strong>{{ $menu->name }}</strong>&nbsp; 
            <label class="ms-5">
                @switch($menu->type)
                    @case('page')
                    <u>Page:</u> {{ $menu->page->title }}
                    @break
                    @case('route')
                    <u>Route Name:</u> {{ $menu->route }}
                    @break
                    @default
                    <u>Custom URL Name:</u> {{ $menu->url }}
                @endswitch
            </label>
        </span>
        <div>
            <button class="border-0 bg-transparent" id="{{ $menu->visibility==1?'menuEnableBtn':'menuDisableBtn' }}"><i class="far fa-eye{{ $menu->visibility==1?' text-info':'-slash' }} "></i></button>
            <button class="border-0 bg-transparent" id="editBtn" data-id="{{ $menu->id }}"><i class="fas fa-edit text-primary"></i></button>
            <button class="border-0 bg-transparent" id="deleteBtn" data-id="{{ $menu->id }}"><i class="fas fa-trash-alt text-danger"></i></button>
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
