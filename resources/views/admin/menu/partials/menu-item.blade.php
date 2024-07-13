<div class="d-flex align-items-center mb-1" data-id="{{ $menu->id }}">
    <div id="menu_{{ $menu->id }}" class="dragagble-menu-item w-100">
        <span>{{ $menu->name }}</span>
    </div>
    <div class="dragagble-menu-actions d-flex align-items-center">
        <button class="btn btn-delete" data-id="{{ $menu->id }}"><i class="fas fa-times text-white"></i></button>&nbsp;
        <button class="btn btn-edit" data-id="{{ $menu->id }}"><i class="fas fa-pencil-alt text-white"></i></button>
    </div>
</div>
