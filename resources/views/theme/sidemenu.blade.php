@php
    $user = ['type' => 'student'];
@endphp
<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="html/index.html" class="logo-link nk-sidebar-logo">
                <img class="logo-dark" style="height: 50px;" src="/logo.png" srcset="/logo.png 2x" alt="logo">
                <img class="logo-small logo-img logo-img-small" src="/logo.png" srcset="/logo.png 2x" alt="logo-small">
            </a>
        </div>
        <div class="nk-menu-trigger me-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                    class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex"
                data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-heading pt-3">
                        <h6 class="overline-title text-primary-alt">Menu</h6>
                    </li>

                    @php
                        $user_type = session('student_assign');
                        if (Auth::check()) {
                            $dsas = true;
                        } else {
                            $dsas = false;
                        }
                    @endphp

                    @if ($user_type == 'Suprime Student Counsel' || $dsas == true)
                        <li class="nk-menu-item">
                            <a href="/dashboard" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-qr"></em></span>
                                <span class="nk-menu-text">Dashboard</span>
                            </a>
                        </li>
                    @else
                        <li class="nk-menu-item">
                            <a href="/student/activity" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-qr"></em></span>
                                <span class="nk-menu-text">Dashboard</span>
                            </a>
                        </li>
                    @endif

                    @if ($user_type == 'Suprime Student Counsel' || $dsas == true)
                        <li class="nk-menu-heading pt-3">
                            <h6 class="overline-title text-primary-alt">Suprime Student Counsel</h6>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/ssc/events/new" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-edit"></em></span>
                                <span class="nk-menu-text">Event Management</span>
                            </a>
                        </li>
                    @endif


                    @if ($user_type == 'Student Body Organization' || $dsas == true)
                        <li class="nk-menu-heading pt-3">
                            <h6 class="overline-title text-primary-alt">Student Body Organization</h6>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/activity/list" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                                <span class="nk-menu-text">Activity Management</span>
                            </a>
                        </li>
                    @endif

                    <li class="nk-menu-heading pt-3">
                        <h6 class="overline-title text-primary-alt">Settings</h6>
                    </li>
                    @if ($dsas || $user_type == 'Suprime Student Counsel')
                        <li class="nk-menu-item">
                            <a href="/auth/assign/new" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                <span class="nk-menu-text">Account Management</span>
                            </a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="/reports" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-download"></em></span>
                                <span class="nk-menu-text">Generate Reports</span>
                            </a>
                        </li>
                    @endif

                    @if ($dsas)
                        <li class="nk-menu-item">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDefault" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                                <span class="nk-menu-text">Change Password</span>
                            </a>
                        </li>
                    @endif

                    <li class="nk-menu-item">
                        <a href="/logout" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-power"></em></span>
                            <span class="nk-menu-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
