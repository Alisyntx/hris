<?php $current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/output.css">
    <title>Document</title>
</head>

<body>
    <nav class="bg-accentclr p-4 h-screen w-[20%] rounded-r-md">
        <div class="flex flex-col space-y-4 font-popins">
            <div class="h-20 w-full mb-14 flex justify-center items-center">
                <img src="public/image/logo.png" class="max-w-full h-auto object-contain" alt="Logo">
            </div>


            <a href="index.php?page=dashboard"
                class="p-2 rounded-sm flex items-center z-10 transition-all duration-300 ease-in-out
          <?= $current_page == 'dashboard' ? 'text-primaryclr bg-mainclr ' : 'text-accentclr bg-primaryclr' ?>
          hover:text-primaryclr hover:bg-mainclr">
                <i class='bx bxs-dashboard text-2xl mr-2'></i>
                Dashboard
            </a>

            <a href="index.php?page=employees"
                class="p-2 rounded-sm flex items-center transition-all duration-300 ease-in-out
          <?= $current_page == 'employees' ? 'text-primaryclr bg-mainclr ' : 'text-accentclr bg-primaryclr' ?>
          hover:text-primaryclr hover:bg-mainclr">
                <i class='bx bxs-user text-2xl mr-2'></i>
                Employees
            </a>
            <a href="index.php?page=attendance"
                class="p-2 rounded-sm flex items-center transition-all duration-300 ease-in-out
          <?= $current_page == 'attendance' ? 'text-primaryclr bg-mainclr ' : 'text-accentclr bg-primaryclr' ?>
          hover:text-primaryclr hover:bg-mainclr">
                <i class='bx bx-calendar-check text-2xl mr-2'></i>
                attendance
            </a>
            <a href="index.php?page=payroll" class="  p-2 rounded-sm  <?= $current_page == 'dashboard' ? 'text-accentclr bg-secondaryclr ' : 'text-accentclr' ?>">Payroll</a>
            <a href="index.php?page=reports" class="  p-2 rounded-sm  <?= $current_page == 'dashboard' ? 'text-accentclr bg-secondaryclr ' : 'text-accentclr' ?>">Reports</a>
            <a href="index.php?page=settings" class="  p-2 rounded-sm  <?= $current_page == 'dashboard' ? 'text-accentclr bg-secondaryclr ' : 'text-accentclr' ?>">Settings</a>
        </div>
    </nav>
</body>

</html>