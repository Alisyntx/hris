<?php $current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <nav class="bg-accentclr p-1 h-screen w-[20%] rounded-r-md">

        <div class="flex flex-col font-popins">
            <div class="h-20 w-full mb-14 flex justify-center items-center mt-2">
                <img src="public/image/logo.png" class="max-w-full h-auto object-contain" alt="Logo">
            </div>
            <ul class="menu  rounded-box space-y-2 w-full">
                <li>
                    <a href="index.php?page=dashboard"
                        class="p-2 rounded-sm flex items-center z-10 transition-all duration-300 ease-in-out
          <?= $current_page == 'dashboard' ? 'text-primaryclr bg-mainclr ' : 'text-accentclr bg-primaryclr' ?>
          hover:text-primaryclr hover:bg-mainclr">
                        <i class='bx bxs-dashboard text-2xl mr-2'></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php?page=employees"
                        class="p-2 rounded-sm flex items-center transition-all duration-300 ease-in-out
          <?= $current_page == 'employees' ? 'text-primaryclr bg-mainclr ' : 'text-accentclr bg-primaryclr' ?>
          hover:text-primaryclr hover:bg-mainclr">
                        <i class='bx bxs-user text-2xl mr-2'></i>
                        Employees
                    </a>
                </li>
                <li>
                    <details open>
                        <summary class="hover:text-primaryclr hover:bg-mainclr p-2 bg-primaryclr text-accentclr"><i class='bx bx-time text-2xl'></i> Time Keeping</summary>
                        <ul>
                            <a href="index.php?page=attendance"
                                class="p-1 mt-2 rounded-sm flex items-center transition-all duration-300 ease-in-out
          <?= $current_page == 'attendance' ? 'text-primaryclr bg-mainclr ' : 'text-accentclr bg-primaryclr' ?>
          hover:text-primaryclr hover:bg-mainclr">
                                <i class='bx bx-calendar-check text-lg mr-2'></i>
                                Dtr Records
                            </a>
                            <a href="index.php?page=dtrReport"
                                class="p-1 mt-2 rounded-sm flex items-center transition-all duration-300 ease-in-out
          <?= $current_page == 'dtrReport' ? 'text-primaryclr bg-mainclr ' : 'text-accentclr bg-primaryclr' ?>
          hover:text-primaryclr hover:bg-mainclr">
                                <i class='bx bxs-report text-lg mr-2'></i>
                                Dtr Reports
                            </a>
                        </ul>
                    </details>

                </li>
                <li>
                </li>
            </ul>

        </div>
    </nav>
</body>

</html>