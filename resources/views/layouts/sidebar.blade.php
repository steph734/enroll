<nav id="sidebar">
    <div class="sidebar-header">
        <button id="toggle-btn" style="margin:0;">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <h4 class="logo">SJE</h4>
    </div>
    <ul>
        <li
            class="{{ ($activePage ?? 'dashboard') === 'dashboard' || is_null($activePage ?? 'dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="{{ in_array($activePage ?? 'dashboard', ['students', 'enrollment_form']) ? 'active' : '' }}">
            <a href="{{ route('enrollment.show','students') }}">
                <i class="fas fa-users"></i>
                <span>Students</span>
            </a>
        </li>
        <li class="{{ in_array($activePage ?? 'dashboard', ['teachers', 'teacher_form', 'edit']) ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'teachers') }}">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Teachers</span>
            </a>
        </li>
        <li
            class="{{ in_array($activePage ?? 'dashboard', ['subject-section', 'subjectform', 'subjectedit']) ? 'active' : '' }}">
            <a href="{{ route('subject.index') }}">
                <i class="fas fa-book"></i>
                <span>Subject/Section</span>
            </a>
        </li>
        <li class="{{ ($activePage ?? 'dashboard') === 'payment' ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'payment') }}">
                <i class="fas fa-receipt"></i>
                <span>Payment Tracking</span>
            </a>
        </li>
        <li class="{{ ($activePage ?? 'dashboard') === 'schedule' ? 'active' : '' }}">
            <a href="{{ route('schedule.index') }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Class Schedule</span>
            </a>
        </li>
        <li class="{{ ($activePage ?? 'dashboard') === 'reports' ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'reports') }}">
                <i class="fas fa-chart-line"></i>
                <span>Reports</span>
            </a>
        </li>
        <li
            class="{{ ($activePage ?? 'dashboard') === 'accounts' || ($activePage ?? 'dashboard') === 'login' || ($activePage ?? 'dashboard') === 'register' ? 'active' : '' }}">
            <a href="{{ route('enrollment.show', 'accounts') }}">
                <i class="fa-solid fa-user"></i>
                <span>Account</span>
            </a>
        </li>
        <hr>
        <li>
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="{{ ($activePage ?? 'dashboard') === 'logout' ? 'active' : '' }}">
                <i class="fas fa-sign-out-alt"></i>
                <span>Log out</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>