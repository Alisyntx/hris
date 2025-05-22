<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Define custom page titles
$page_titles = [
    'dashboard' => 'Dashboard',
    'employees' => 'Employee Management',
    'attendance' => 'Attendance Tracker',
    'dtrReport' => 'DTR Report',
    'reports' => 'Reports Overview',
    'settings' => 'System Settings',
    'department' => 'Department Management',
    'overtimeRequest' => 'Overtime Requests',
    'allowance' => 'Employee Incentive-Based Allowance'
];

// Use custom title or fallback
$current_page = $page_titles[$page] ?? ucfirst($page);
?>

<div class="navbar bg-accentclr h-16 rounded-sm shadow-sm font-popins mr-1 mt-1 flex justify-between items-center flex-row ">
    <div class="flex-none">
        <button id="menu-toggle" class="btn btn-square btn-ghost">
            <i class='bx bx-menu text-2xl text-primaryclr'></i>
        </button>
    </div>
    <div class="flex items-center gap-2">
        <a class="btn btn-ghost text-xl text-primaryclr"><?= $current_page ?></a>
    </div>
    <div class="flex gap-2">
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    <img
                        alt="User Avatar"
                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                </div>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-10 mt-3 w-52 p-2 shadow">
                <li><a href="login/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</div>