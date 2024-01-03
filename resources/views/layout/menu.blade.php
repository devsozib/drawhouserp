  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- <a href="{{ url('welcome') }}" class="brand-link" style="padding: 10px;">
      <img src="{{ url('images/favicon-32x32.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ Config::get('rmconf.apps_name') }}</span>
    </a> -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <?php
            $modulename = getArrayData(Request::segments(), 0);
            $modulesdata = Request::session()->get('modules');
            $menusdata = Request::session()->get('menus');
            $childmenusdata = Request::session()->get('childmenus');
            $moduleid = collect($modulesdata)->where('Slug',$modulename)->pluck('id')->first();
            $menus = collect($menusdata)->where('ModuleID',$moduleid)->sortBy('SeqNo')->all();
            $childmenusdataall = collect($childmenusdata)->where('ModuleID',$moduleid)->sortBy('SeqNo')->all();
          ?>
          <li class="nav-item">
            <a href="{{ url($modulename.'/dashboard') }}" class="nav-link {{ setActive($modulename.'/dashboard') }}"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a>
          </li>
          @foreach ($menus as $menu)
            @if($menu->Childable=='Y')
              <?php $childmenus = collect($childmenusdataall)->where('MenuID',$menu->id)->sortBy(function ($item){ return $item->SeqNo . $item->id; })->all(); //dd(setActive($menu->URL.'*')); ?>
              <li class="nav-item {!! sizeOf($childmenus) && (setActive($menu->URL.'*') != '') ? 'menu-is-opening menu-open' : '' !!}">
                <a href="{!! url($menu->URL) !!}" class="nav-link {{ setActive($menu->URL.'*') }}"><i class="nav-icon fas fa-copy"></i><p>{!! $menu->Name !!}<i class="fas fa-angle-left right"></i><span class="badge badge-info right">{!! sizeOf($childmenus) !!}</span></p></a>
                <ul class="nav nav-treeview {{ setActive($menu->URL.'*') }}" style="{!! sizeOf($childmenus) && (setActive($menu->URL.'*') != '') ? 'display: block' : 'display: none' !!}">
                  @foreach ($childmenus as $childmenu)
                  <li class="nav-item"><a href="{!! url($childmenu->URL) !!}" class="nav-link {{ (Request::segment(3) == $childmenu->Slug) ? 'active' : '' }}"><i class="fas fa-shapes nav-icon"></i><p>{!! $childmenu->Name !!}</p></a></li>
                  @endforeach
                </ul>
              </li>
            @else
              <li class="nav-item"><a href="{!! url($menu->URL) !!}" class="nav-link {{ setActive($menu->URL.'*') }}"><i class="nav-icon fas fa-user-circle"></i><p>{!! $menu->Name !!}</p></a></li>
            @endif
          @endforeach
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
