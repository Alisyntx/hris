<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- tailwind -->
    <link rel="stylesheet" href="public/css/output.css">
    <!-- icons -->
    <link rel="stylesheet" href="node_modules/boxicons/css/boxicons.min.css">
    <!-- jquery -->
    <script src="public/js/jquery.js"></script>
    <script type="module" src="public/js/main.js"></script>
    <!-- datatables -->
    <link rel="stylesheet" href="node_modules/datatables.net-dt/css/dataTables.dataTables.css">
    <!-- sweatalert -->
    <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">

    <title>index</title>
</head>

<body class="select-none">
    <div class="h-screen w-full flex flex-row gap-1 overflow-x-hidden">
        <?php
        include 'views/includes/navbar.php';
        ?>
        <div class="w-full flex flex-col">
            <?php
            include 'views/includes/header.php';
            ?>
            <!-- al contents here -->
            <div class="overflow-y-auto mt-1 rounded-sm">
                <div class="toast toast-top toast-end font-popins" id="toastAlertMessage">
                </div>
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                $allowed_pages = ['dashboard', 'employees', 'attendance', 'dtrReport', 'reports', 'settings'];

                if (in_array($page, $allowed_pages)) {
                    include "views/pages/$page.php";
                } else {
                    include "views/404.php"; // Handle unknown pages
                }
                ?>
                <?php include "views/modalContainer/allModalContainer.php" ?>

            </div>
        </div>
    </div>

</body>

</html>