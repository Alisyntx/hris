<?php
include 'database/conn.php';

try {
    $stmt = $pdo->query("SELECT `emp_id`, `emp_fname`, `emp_mname`, `emp_lname`, `emp_suffix`, `emp_age`, `emp_gender`, `emp_address`, `emp_position`, `emp_department`, `emp_promotion`, `emp_profPic`, `emp_dateHire` FROM `employee`");

    while ($row = $stmt->fetch()) {
        $fullName = $row['emp_fname'] . ' ' . $row['emp_mname'] . ' ' . $row['emp_lname'] . ' ' . $row['emp_suffix'];
        echo '
        <div class="w-full flex justify-evenly flex-col rounded-md h-64 mt-1 bg-slate-100 px-2 drop-shadow-lg">
            <div>
                <div class=" text-lg font-semibold">' . htmlspecialchars($fullName) . '</div>
                <div class="text-sm text-gray-500">' . htmlspecialchars($row['emp_id']) . ' • ' . htmlspecialchars($row['emp_department']) . ' • ' . htmlspecialchars($row['emp_position']) . '</div>
            </div>

            <div class="w-full mt-1 gap-1 h-20 flex ">
                <div class="w-full flex flex-col bg-amber-100 rounded-md items-center justify-center">
                    <span class="text-2xl font-semibold text-blue-600">20%</span>
                    <span class="text-sm text-gray-500">Attendance rate</span>
                </div>
                <div class="w-full flex flex-col bg-amber-100 rounded-md items-center justify-center">
                    <span class="text-2xl font-semibold text-blue-600">20%</span>
                    <span class="text-sm text-gray-500">Overtime Hours</span>
                </div>
                <div class="w-full flex flex-col bg-amber-100 rounded-md items-center justify-center">
                    <span class="text-2xl font-semibold text-blue-600">20%</span>
                    <span class="text-sm text-gray-500">KPI score</span>
                </div>
                <div class="w-full flex flex-col bg-amber-100 rounded-md items-center justify-center">
                    <span class="text-2xl font-semibold text-blue-600">20%</span>
                    <span class="text-sm text-gray-500">Total Allowance</span>
                </div>
            </div>

            <div class="w-full ">
                <div>Allowance Breakdown: </div>
                <ul class="list-disc text-gray-500 pl-5">
                    <li class="text-sm">Perfect Attendance Bonus: $20</li>
                    <li class="text-sm">Overtime Incentive (2.5 hrs): $37.50</li>
                    <li class="text-sm">KPI Achievement Bonus: $147.50</li>
                </ul>
            </div>
        </div>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
