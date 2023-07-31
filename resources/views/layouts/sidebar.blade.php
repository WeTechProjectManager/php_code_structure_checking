<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

<!-- -------------------------------------------Main/Dashboard----------------------------------------------------- -->
                @if (Auth::user()->type=='Admin')
                <li> <a href="{{ route('home') }}" class="noti-dot active"><i class="la la-dashboard">
                            </i> <span> Dashboard</span></a>
                </li>
                @endif

<!-----------------------------------------User Controller------------------------------------------ -->
                @if (Auth::user()->type=='Admin')
                <li class="pl-1" style="color: #bdb8b8"> <span>Users</span>
                    <li class="submenu">
                        <a href="#">
                            <i class="la la-user-secret"></i> <span> User Management</span> <span class="menu-arrow"></span>
                        </a>
                        <ul style="display: none;">
                            <li><a href="{{ route('userManagement') }}">Real Users</a></li>
                            <li><a href="{{ route('userManagement.fakeUser') }}">Fake Users</a></li>
                        </ul>
                    </li>
                <li> <a href="{{ route('user.analytics') }}" class=""><i class="la la-chart-bar">
                        </i> <span> Analytics Report</span></a>
                </li>
                    <li> <a href="{{ route('user.payment_report.index') }}" class=""><i class="la la-chart-area">
                            </i> <span> Payment Report</span></a>
                    </li>
                @endif

<!-- -------------------------------------------Marketer------------------------------------------------------->
                @if (Auth::user()->type=='Admin')
                <li class="pl-1" style="color: #bdb8b8"> <span>Marketers</span>
                <li> <a href="{{ route('marketer') }}" class=""><i class="la la-user-friends">
                        </i> <span> Marketers</span></a>
                </li>
                @endif
                <!-- Commission Setup -->
                @if (Auth::user()->type=='Admin')
                    <li> <a href="{{ route('marketer.commission_setup.index') }}" class=""><i class="la la-list">
                            </i> <span> Commission Setup</span></a>
                    </li>
                @endif
                <!-- Commission Report -->
                @if (Auth::user()->type=='Admin')
                    <li> <a href="{{ route('marketer.commission_report.index') }}" class=""><i class="la la-chart-bar">
                            </i> <span> Commission Report</span></a>
                    </li>
                @endif

<!-- -------------------------------------------Post------------------------------------------------------->
                @if (Auth::user()->type=='Admin')
                    <li class="pl-1" style="color: #bdb8b8"> <span>Post</span>
                    <li> <a href="{{ route('post.index') }}" class=""><i class="la la-list-alt">
                            </i> <span> Posts</span></a>
                    </li>
                    <li> <a href="{{ route('post.increaseViewSetup') }}" class=""><i class="la la-adjust">
                            </i> <span> Increase View Setup</span></a>
                    </li>
                @endif

<!-- -------------------------------------------Payment setup----------------------------------------------------- -->
                @if (Auth::user()->type=='Admin')
                    <li class="pl-1" style="color: #bdb8b8"> <span>Setup</span>
                    <li> <a href="{{ route('user.payment_setup.index') }}" class=""><i class="la la-list">
                            </i> <span> Payment Setup</span></a>
                    </li>
                @endif

<!-- -------------------------------------------Default Comment setup----------------------------------------------------- -->
                @if (Auth::user()->type=='Admin')
                    <li> <a href="{{ route('defaultComment.index') }}" class=""><i class="la la-list-alt">
                            </i> <span> Default Comment Setup</span></a>
                    </li>
                @endif

<!-- -------------------------------------------Banner Ad setup----------------------------------------------------- -->
                @if (Auth::user()->type=='Admin')
                    <li> <a href="{{ route('banner_ad.index') }}" class=""><i class="la la-ad">
                            </i> <span> Banner Ad</span></a>
                    </li>
                @endif

<!-- -------------------------------------------Admin Notification----------------------------------------------------- -->
                @if (Auth::user()->type=='Admin')
                    <li> <a href="{{ route('admin_notification.index') }}" class=""><i class="fa fa-bell">
                            </i> <span> Notification</span></a>
                    </li>
                @endif

<!-- -------------------------------------------About us----------------------------------------------------- -->
                @if (Auth::user()->type=='Admin')
                <li> <a href="{{ route('about.edit') }}" class=""><i class="la la-address-card">
                        </i> <span> About Us</span></a>
                </li>
                @endif

<!-- -------------------------------------------privacy policy----------------------------------------------------- -->
                @if (Auth::user()->type=='Admin')
                <li> <a href="{{ route('privacy_policy.edit') }}" class=""><i class="la la-list-alt">
                        </i> <span> Privacy policy</span></a>
                </li>
                @endif

<!-- -------------------------------------------terms and condition ----------------------------------------------------- -->
                @if (Auth::user()->type=='Admin')
                <li> <a href="{{ route('term_condition.edit') }}" class=""><i class="la la-list">
                        </i> <span> Terms & Conditions</span></a>
                </li>
                @endif

<!-- -------------------------------------------help and support ----------------------------------------------------- -->
                @if (Auth::user()->type=='Admin')
                    <li> <a href="{{ route('help_support.index') }}" class=""><i class="la la-list">
                            </i> <span> Help & Support</span></a>
                    </li>
                @endif


<!-- -------------------------------------------Marketer ----------------------------------------------------- -->

<!-- -------------------------------------------Marketer Dashboard----------------------------------------------------- -->
                @if (Auth::user()->type=='Marketer')
                <li> <a href="{{ route('home') }}" class="noti-dot active"><i class="la la-dashboard">
                        </i> <span> Dashboard</span></a>
                </li>
                @endif

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->

