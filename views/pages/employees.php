<?php
include 'database/conn.php';

// Prepare and execute the query
$query = "SELECT * FROM employee WHERE 1";
$stmt = $pdo->query($query);
$employees = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Data</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="w-full h-9 flex flex-row items-center mt-2 ml-1">
        <!-- Search Bar -->
        <label class="input input-sm flex items-center border border-gray-300 rounded-md px-2 focus-within:ring-0 focus-within:border-gray-400">
            <i class='bx bx-search-alt text-mainclr text-[20px]'></i>
            <input type="search" id="searchInput" class="grow px-2 focus:outline-none" placeholder="search">
        </label>

        <!-- Add New Employee Button -->
        <a class="px-2 py-1 ml-2 font-popins text-sm rounded-sm flex items-center transition-all duration-300 ease-in-out 
        text-primaryclr bg-accentclr hover:text-mainclr hover:bg-primaryclr active:scale-95 active:opacity-80" id="addEmployee">
            <i class='bx bxs-user-plus text-2xl mr-2'></i>
            Add New Employee
        </a>
    </div>

    <div class="w-[1123px] h-screen overflow-x-auto">
        <table class="table table-zebra w-full text-sm pt-2 font-popins">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Promotion</th>
                    <th>Date Hired</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="employeeTabled">
                <?php if ($employees): ?>
                    <?php foreach ($employees as $employee): ?>
                        <tr id="employeeRow_<?= htmlspecialchars($employee['emp_id']); ?>">
                            <td><?= htmlspecialchars($employee['emp_id']); ?></td>
                            <td><?= htmlspecialchars($employee['emp_fname']) . ' ' . htmlspecialchars($employee['emp_mname']) . ' ' . htmlspecialchars($employee['emp_lname']) . ' ' . htmlspecialchars($employee['emp_suffix']); ?></td>
                            <td><?= htmlspecialchars($employee['emp_position']); ?></td>
                            <td><?= htmlspecialchars($employee['emp_department']); ?></td>
                            <td><?= htmlspecialchars($employee['emp_promotion']); ?></td>
                            <td><?= htmlspecialchars($employee['emp_dateHire']); ?></td>
                            <td>
                                <button class="empDetailsBtn btn btn-xs btn-circle" id="<?= htmlspecialchars($employee['emp_id']); ?>">
                                    <i class='bx bx-info-circle text-[15px]'></i>
                                </button>
                                <button class="empTrackBtn btn btn-xs btn-circle" id="<?= htmlspecialchars($employee['emp_id']); ?>">
                                    <i class='bx bx-line-chart-down text-[15px]'></i>
                                </button>
                                <button class="empEditBtn btn btn-xs btn-circle" id="<?= htmlspecialchars($employee['emp_id']); ?>">
                                    <i class='bx bx-edit-alt text-[15px]'></i>
                                </button>
                                <button class="empDeleteBtn btn btn-xs btn-circle" id="<?= htmlspecialchars($employee['emp_id']); ?>">
                                    <i class='bx bx-trash text-[15px]'></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="noResultsRow">
                        <td colspan="7" class="text-center">No employee data found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
    <script>
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                var rows = $("#employeeTabled tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    return $(this).text().toLowerCase().indexOf(value) > -1;
                });

                // Show "No results found" message if all rows are hidden
                if (rows.length === 0) {
                    if ($("#noResultsRow").length === 0) {
                        $("#employeeTabled").append('<tr id="noResultsRow"><td colspan="7" class="text-center">No results found.</td></tr>');
                    }
                } else {
                    $("#noResultsRow").remove();
                }
            });
        });
    </script>

</body>

</html>