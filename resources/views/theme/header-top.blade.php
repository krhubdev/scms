@php
    $user = ['type' => 'admin', 'name' => 'Casino, Kent Russell', 'email' => 'kent@tcc.edu.ph'];
@endphp
<div class="nk-header nk-header-fixed is-light" style="border-top: 10px solid #b4543d">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ms-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em
                        class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <a href="html/index.html" class="logo-link">
                    <img class="logo-light logo-img" src="/logo.png" srcset="/logo.png 2x" alt="logo">
                    <img class="logo-dark logo-img" src="/logo.png" srcset="/logo.png 2x" alt="logo-dark">
                </a>
            </div>
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle me-n1" data-bs-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm" style="background-color: #b4543d">
                                    <em class="icon ni ni-user-alt"></em>
                                </div>
                                <div class="user-info d-none d-xl-block">
                                    <div class="user-status user-status-active"
                                        style="text-transform: uppercase; color: #b4543d">
                                        @if (Auth::user())
                                            {{ Auth::user()->email }}
                                        @else
                                            STUDENT ID #: {{ session('student_id') }}
                                        @endif

                                    </div>
                                    <div class="user-name " style="text-transform: uppercase">
                                        @if (Auth::user())
                                            {{ Auth::user()->name }}
                                        @else
                                            {{ session('student_name') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
