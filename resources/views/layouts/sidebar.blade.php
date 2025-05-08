<nav id="sidebar">
    <div class="sidebar-header">
        <button id="toggle-btn" style="margin:0;">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <h4 class="logo">SJE</h4>
    </div>
    <ul>
        <li class="{{ request()->route()->parameter('page') === 'dashboard' || !request()->route()->parameter('page') ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'dashboard') }}">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="{{ in_array(request()->route()->parameter('page'), ['students', 'enrollment_form']) ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'students') }}">
                <i class="fas fa-users"></i>
                <span>Students</span>
            </a>
        </li>
        <li class="{{ in_array(request()->route()->parameter('page'), ['teachers', 'teacher_form', 'edit']) ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'teachers') }}">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Teachers</span>
            </a>
        </li>
        <li class="{{ request()->route()->parameter('page') === 'subject-section' ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'subject-section') }}">
                <i class="fas fa-book"></i>
                <span>Subject/Section</span>
            </a>
        </li>
        <li class="{{ request()->route()->parameter('page') === 'payment' ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'payment') }}">
                <i class="fas fa-dollar-sign"></i>
                <span>Payment Tracking</span>
            </a>
        </li>
        <li class="{{ request()->route()->parameter('page') === 'class_schedule' ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'class_schedule') }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Class Schedule</span>
            </a>
        </li>
        <li class="{{ request()->route()->parameter('page') === 'reports' ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'reports') }}">
                <i class="fas fa-chart-line"></i>
                <span>Reports</span>
            </a>
        </li>
        <li class="{{ request()->route()->parameter('page') === 'accounts' ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'accounts') }}">
                <i class="fa-solid fa-user"></i>
                <span>Account</span>
            </a>
        </li>
        <hr>
        <li>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Leave</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>