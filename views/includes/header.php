<?php
// Get the current page from the URL
$current_page = isset($_GET['page']) ? ucfirst($_GET['page']) : 'Dashboard';
?>
<div class="navbar bg-accentclr h-16 rounded-sm shadow-sm font-popins mr-1 mt-1 flex justify-between items-center flex-row">
    <div class="flex items-center gap-2">
        <a class="btn btn-ghost text-xl text-primaryclr"><?= $current_page ?></a>

        <!-- Attendance Dropdown (ONLY SHOWS ON ATTENDANCE PAGE) -->
        <?php if (isset($_GET['page']) && $_GET['page'] == 'attendance'): ?>
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost  hover:bg-mainclr hover:text-white text-primaryclr">
                    Attendance ▼
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box mt-3 font-popins w-52 p-2 shadow z-10">
                    <li><a href="?page=attendance_report">Attendance Report</a></li>
                    <li><a href="?page=absence_report">Absence Report</a></li>
                    <li><a href="?page=overtime_request">Overtime Request</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <div class="flex gap-2">
        <!-- Profile Dropdown -->
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    <img
                        alt="User Avatar"
                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                </div>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-10 mt-3 w-52 p-2 shadow">
                <li>
                    <a class="justify-between">
                        Profile
                        <span class="badge">New</span>
                    </a>
                </li>
                <li><a>Settings</a></li>
                <li><a>Logout</a></li>
            </ul>
        </div>
    </div>
</div>