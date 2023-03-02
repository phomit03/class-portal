<!---Site Header-->
<header id="site-header" class="site-header">
    <div class="container site-header-container">

        <div id="site-logo" class="site-logo">
            <a href="{{ url('/home') }}" rel="home"><img src="{{ asset('uploads/logo/logo1.png') }}" class="mg-r-15" alt="logo"></a>
        </div>
        <div class="wrap-site-nav">
            <input type="checkbox" id="mobile-menu-cb" name="mobile-menu-cb">
            <label class="hamburger-button" for="mobile-menu-cb">
                <span class="hamburger-icon"></span>
            </label>
            <label class="hamburger-menu-mask la la-times" for="mobile-menu-cb"></label>
            <nav id="site-nav" class="site-nav">
                <ul class="site-menu none-list heading-font">
                    @if (Auth::user())
                        <li class="menu-item home {{request()->segment(1) == 'home' ? 'active' : '' }}">
                            <a class="" href="{{ url('/home') }}" title="Home">
                                <i class="las la-home"></i>  Home
                            </a>
                        </li>
                        <!-- Display appropriate links based on the user's role -->
                        @if (Auth::user()->role == 'teacher')
                            <li class="menu-item home {{request()->segment(2) == 'create' ? 'active' : '' }}">
                                <a class="" href="{{ url('/class/create') }}" title="Add Class">
                                    <i class="las la-home"></i>  Add Class
                                </a>
                            </li>
                        @endif
                        <li class="menu-item list-slots {{request()->segment(1) == 'subjects' ? 'active' : '' }}">
                            <a class="" href="{{ route('subjects.show_all') }}" title="Subjects">
                                <i class="las la-book"></i> Subjects
                            </a>
                        </li>
                        <li class="menu-item list-assignments {{request()->segment(1) == 'assignments' ? 'active' : '' }}">
                            <a class="" href="{{ Auth::user()->role == 'student' ? route('student.assignment.show_all') : route('teacher.assignment.index') }}" title="Assignments">
                                <i class="la la-question"></i> Assignments
                            </a>
                        </li>
                        <!-- Display appropriate links based on the user's role -->
                        @if (Auth::user()->role == 'student')
                            <li class="menu-item home">
                                <a data-toggle="modal" data-target="#userJoinCode" href="" title="Join Class">
                                    <i class="la la-share-square-o"></i>  Join +
                                </a>
                            </li>
                        @endif
                        <li class="menu-item user-guide-link">
                            <a href="" data-toggle="modal" data-target="#userSupportModal" title="Support">
                                <i class="la la-support"></i> Support
                            </a>
                        </li>
                        <li class="menu-item user-guide-link">
                            <a class="" href="{{ asset('uploads/user-guide/userguide_classportal.pdf') }}" target="_blank" title="User Guide"><i class="las la-school"></i> User Guide</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
        <ul id="header-account" class="header-account none-list">
            <li class="user-support-link">
                <a class="support" data-toggle="modal" data-target="#userSupportModal" title="Support">
                    <h3 class="fs-16 mg-b-0 mg-r-4">Support</h3>
                </a>
            </li>
            <li class="user-guide-link">
                <a class="" href="{{ asset('uploads/user-guide/userguide_classportal.pdf') }}" target="_blank" title="User Guide">User Guide</a>
            </li>
            <li class="user-chat">
                <div class="chat-icon">
                    <a href="{{ url('/message') }}">
                        <span class="total-message"></span>
                        <i class="las la-comments"></i> Chat
                    </a>
                </div>
            </li>
            @if(Auth::user()->role == 'student')
                <li class="user-chat">
                    <div class="chat-icon">
                        <a href="" data-toggle="modal" data-target="#userJoinCode">
                            <span class="total-message"></span>
                            <i class="la la-plus"></i>
                        </a>
                    </div>
                </li>
            @endif
            <li class="user-notify">
                <input type="checkbox" id="user-notify-cb" class="hidden" />
                <div class="overlay-notify"><i class="las la-times"></i></div>
                <label for="user-notify-cb" class="account-notify has-notify"><i class="la la-bell"></i><span class="total-notify" style="display:none"></span></label>
                <div class="wrap-user-notify-content">
                    <div class="heading-user-notify">
                        <div class="wrap-actions text-semibold text-uppercase">
                            <a href="#" class="not-read" title="Unread">Unread</a>
                            <a href="#" class="all-notify" title="All">All</a>
                        </div>
                    </div>
                    <ul class="list-user-notify">
                    </ul>
                    <span class="notify-load-more" style="display:none">Load more</span>
                </div>
            </li>
            <li class="user-section">
                <div class="user-acc">
                    <input style="display:none;" type="checkbox" id="toggle-user-block" name="toggle-user-block" />
                    <label class="label-user" for="toggle-user-block">
                        <span class="avatar-place-holder v4">
                            <img src="{{(Auth::user()->avatar) ? asset('uploads/avatar/'.Auth::user()->avatar) : asset('uploads/avatar/user-default.png') }}" alt="avatar user" class="w-px-40 h-auto rounded-circle" />
                        </span>
                    </label>
                    <ul class="user-action-box ui-v4">
                        <li class="overlay">
                            <i class="la la-times"></i>
                        </li>
                        <li>
                            <a href="{{ url('/profile') }}" title="{{ Auth::user()->email }}">
                                <div class="user-box">
                                    <span class="avatar-place-holder in-action-box">
                                        <img src="{{(Auth::user()->avatar) ? asset('uploads/avatar/'.Auth::user()->avatar) : asset('uploads/avatar/user-default.png') }}"
                                             alt="avatar user" class="w-px-40 h-auto rounded-circle" style="border-radius: 50%"
                                        />
                                    </span>
                                    <div class="right">
                                        <p class="user-name">
                                            <span>{{ Auth::user()->email }}</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="break-line-item"></li>
                        <li>
                            <a class="item logout-site" href="" title="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="la la-sign-in-alt"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-none">
                                @csrf
                                @method("post")
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</header>
<!---End Site Header-->




