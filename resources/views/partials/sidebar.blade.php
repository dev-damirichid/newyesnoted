<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('') }}assets/images/logo.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            {{-- <h4 class="logo-text">YesNoted</h4> --}}
            <img src="{{ asset('') }}assets/images/brand.png" class="logo-icon2" alt="logo icon">
        </div>
        <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class="{{ Request::routeIs('dashboard.index') ? 'mm-active' : '' }}">
            <a href="{{ route('dashboard.index') }}">
                <div class="parent-icon"><i class="bi bi-house-fill"></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li
            class="{{ Request::routeIs('board.index', 'board.create', 'board.show', 'board.show.user', 'list-card.index', 'list-card.create', 'card.index', 'card.create', 'card.edit.description', 'checklist-detail.index', 'checklis-detail.create', 'checklist.create') ? 'mm-active' : '' }}">
            <a href="{{ route('board.index') }}">
                <div class="parent-icon">
                    <i class="bi bi-clipboard-fill"></i>
                </div>
                <div class="menu-title">Board</div>
            </a>
        </li>
        <li class="">
            <a href="{{ route('calendar') }}">
                <div class="parent-icon">
                    <i class="bi bi-clipboard-fill"></i>
                </div>
                <div class="menu-title">Calendar</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</aside>
