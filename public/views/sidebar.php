<!-- <?php
        session_start();
        if (!isset($_SESSION['username'])) {
            header("Location: ../resource/login.php");
            exit();
        }
        $current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $subjects_active = in_array($current_page, ['subjects', 'sections']) ? 'active' : '';
        ?> -->

<nav id="sidebar">
    <div class="sidebar-header">
        <span class="logo">Enrollment System</span>
        <button id="toggle-btn">
            <i class="fa-solid fa-bars-staggered"></i> <!-- Keeping your original FontAwesome bars icon -->
        </button>
    </div>
    <ul>
        <!-- Dashboard -->
        <li class="<?= ($current_page == 'dashboard') ? 'active' : '' ?>">
            <a href="../layout/web-layout.php?page=dashboard">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- Students -->
        <li class="<?= ($current_page == 'students' || $current_page == 'enrollment_form') ? 'active' : '' ?>">
            <a href="../layout/web-layout.php?page=students">
                <i class="fas fa-users"></i>
                <span>Students</span>
            </a>
        </li>
        <!-- Teachers -->
        <li class="<?= ($current_page == 'teachers' || $current_page == 'teacher_form') ? 'active' : '' ?>">
            <a href="../layout/web-layout.php?page=teachers">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Teachers</span>
            </a>
        </li>
        <!-- Subject/Section with modal trigger -->
        <li class="<?= ($current_page == 'subject-section') ? 'active' : '' ?>">
            <a href="../layout/web-layout.php?page=subject-section">
                <i class="fas fa-book"></i>
                <span>Subject/Section</span>
            </a>
        </li>
        <!-- Payment Tracking -->
        <li class="<?= ($current_page == 'payment') ? 'active' : '' ?>">
            <a href="../layout/web-layout.php?page=payment">
                <i class="fas fa-dollar-sign"></i>
                <span>Payment Tracking</span>
            </a>
        </li>
        <!-- Class Schedule -->
        <li class="<?= ($current_page == 'class_schedule') ? 'active' : '' ?>">
            <a href="../layout/web-layout.php?page=class_schedule">
                <i class="fas fa-calendar-alt"></i>
                <span>Class Schedule</span>
            </a>
        </li>
        <!-- Reports -->
        <li class="<?= ($current_page == 'reports') ? 'active' : '' ?>">
            <a href="../layout/web-layout.php?page=reports">
                <i class="fas fa-chart-line"></i>
                <span>Reports</span>
            </a>
        </li>
        <!-- Account -->
        <li class="<?= ($current_page == 'accounts') ? 'active' : '' ?>">
            <a href="../layout/web-layout.php?page=accounts">
                <i class="fa-solid fa-user"></i>
                <span>Account</span>
            </a>
        </li>
        <hr>
        <!-- Logout -->
        <li>
            <a href="../logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Leave</span>
            </a>
        </li>
    </ul>
</nav>

<!-- Modal for Subject/Section selection -->
<div id="subjectSectionModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="hideModal()">&times;</span>
        <h3>Select an Option</h3>
        <ul>
            <li><a href="../layout/web-layout.php?page=subjects">Subjects</a></li>
            <li><a href="../layout/web-layout.php?page=sections">Sections</a></li>
        </ul>
    </div>
</div>