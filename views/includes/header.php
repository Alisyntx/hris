<?php
// Get the current page from the URL
$current_page = isset($_GET['page']) ? ucfirst($_GET['page']) : 'Dashboard';
?>
<div class="navbar bg-accentclr h-16 rounded-sm shadow-sm font-popins mr-1 mt-1 flex justify-between items-center flex-row">
    <div class="flex">
        <a class="btn btn-ghost text-xl text-primaryclr"><?= $current_page ?></a>



    </div>

    <div class=" flex gap-2">
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    <img
                        alt="Tailwind CSS Navbar component"
                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                </div>
            </div>
            <ul
                tabindex="0"
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
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