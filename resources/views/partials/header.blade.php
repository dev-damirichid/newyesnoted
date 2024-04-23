<header class="top-header">
    <nav class="navbar navbar-expand gap-3">
        <div class="mobile-toggle-icon fs-3">
            <i class="bi bi-list"></i>
        </div>
        <form class="searchbar">
            <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>
            <input class="form-control" type="text" placeholder="Type here to search">
            <div class="position-absolute top-50 translate-middle-y search-close-icon"><i class="bi bi-x-lg"></i></div>
        </form>
        <div class="top-navbar-right ms-auto">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item search-toggle-icon">
                    <a class="nav-link" href="#">
                        <div class="">
                            <i class="bi bi-search"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item dropdown dropdown-user-setting">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                        data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center">
                            @if (auth()->user()->photo)
                                <img src="{{ asset('storage/photos/' . auth()->user()->photo) }}" class="user-img"
                                    alt="">
                            @else
                                <img src="{{ asset('assets/images/empty-user.png') }}" class="user-img" alt="">
                            @endif
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    @if (auth()->user()->photo)
                                        <img src="{{ asset('storage/photos/' . auth()->user()->photo) }}" id="img"
                                            class="rounded-circle" width="54" height="54" alt="">
                                    @else
                                        <img src="{{ asset('assets/images/empty-user.png') }}" class="rounded-circle"
                                            width="54" height="54" alt="">
                                    @endif
                                    <div class="ms-3">
                                        <h6 class="mb-0 dropdown-user-name">{{ auth()->user()->name }}</h6>
                                        <div style="font-size: 10px" class="fw-bold">{{ auth()->user()->email }}</div>
                                        <div style="font-size: 10px" class="fw-bold mt-1">{{ auth()->user()->company }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-person-fill"></i></div>
                                    <div class="ms-3"><span>Profile</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form id="logout" action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <div class="d-flex align-items-center">
                                        <div class=""><i class="bi bi-lock-fill"></i></div>
                                        <div class="ms-3"><span>Logout</span></div>
                                    </div>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                {{-- <li class="nav-item dropdown dropdown-large">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                        data-bs-toggle="dropdown">
                        <div class="projects">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="row row-cols-3 gx-2">
                            <div class="col">
                                <a href="{{ route('board.index') }}">
                                    <div class="apps p-2 radius-10 text-center">
                                        <div class="apps-icon-box mb-1 text-white bg-gradient-purple">
                                            <i class="bi bi-clipboard-fill"></i>
                                        </div>
                                        <p class="mb-0 apps-name">Boards</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </li> --}}
                {{-- <li class="nav-item dropdown dropdown-large">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                        data-bs-toggle="dropdown">
                        <div class="messages">
                            <span class="notify-badge">0</span>
                            <i class="bi bi-chat-right-fill"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-0">
                        <div class="p-2 border-bottom m-2">
                            <h5 class="h5 mb-0">Messages</h5>
                        </div>
                        <div class="header-message-list p-2">
                            <div class="text-center pt-5">
                                <h6 class="mb-0 dropdown-msg-user">No message</h6>
                            </div>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('') }}assets/images/avatars/avatar-3.png" alt=""
                                        class="rounded-circle" width="50" height="50">
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 dropdown-msg-user">Katherine Pechon <span
                                                class="msg-time float-end text-secondary">2 h</span></h6>
                                        <small
                                            class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">Making
                                            this the first true</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="p-2">
                            <div>
                                <hr class="dropdown-divider">
                            </div>
                            <a class="dropdown-item" href="#">
                                <div class="text-center">View All Messages</div>
                            </a>
                        </div>
                    </div>
                </li> --}}
                {{-- <li class="nav-item dropdown dropdown-large">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                        data-bs-toggle="dropdown">
                        <div class="notifications">
                            <span class="notify-badge">0</span>
                            <i class="bi bi-bell-fill"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-0">
                        <div class="p-2 border-bottom m-2">
                            <h5 class="h5 mb-0">Notifications</h5>
                        </div>
                        <div class="header-notifications-list p-2">
                            <div class="text-center pt-5">
                                <h6 class="mb-0 dropdown-msg-user">No notification</h6>
                            </div>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="notification-box bg-light-primary text-primary"><i
                                            class="bi bi-basket2-fill"></i></div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 dropdown-msg-user">New Orders <span
                                                class="msg-time float-end text-secondary">1 m</span></h6>
                                        <small
                                            class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">You
                                            have recived new orders</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="p-2">
                            <div>
                                <hr class="dropdown-divider">
                            </div>
                            <a class="dropdown-item" href="#">
                                <div class="text-center">View All Notifications</div>
                            </a>
                        </div>
                    </div>
                </li> --}}
            </ul>
        </div>
    </nav>
</header>
