<?php
include 'database/conn.php';

$dateToday = date('Y-m-d'); // Get today's date

$query = "SELECT 
            t.*, 
            e.emp_fname, e.emp_mname, e.emp_lname, e.emp_suffix, 
            e.emp_age, e.emp_gender, e.emp_address, e.emp_position, 
            e.emp_department, e.emp_promotion, e.emp_profPic, e.emp_dateHire,
            d.dept_time_in AS dept_sched_in,
            d.dept_time_out AS dept_sched_out,
            d.dept_break_time
          FROM timekeeping t
          INNER JOIN employee e ON t.time_empId = e.emp_id
          LEFT JOIN departments d ON e.emp_department = d.dept_name
          WHERE t.time_dateAdd = :dateToday";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':dateToday', $dateToday);
$stmt->execute();
$dtrRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
</head>

<body>
    <div class="w-auto h-screen rounded-sm mr-1 overflow-hidden  font-popins">
        <div class="w-full flex flex-row gap-1 h-18 ">
            <div class="bg-accentclr justify-evenly h-full flex-1 rounded-sm flex p-2 flex-col items-center">
                <div class="flex gap-2">
                    <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                        <span class="text-sm font-light">am</span>
                        <div class="w-px h-5 bg-primaryclr"></div>
                        <span id="presentAM">0</span>
                    </div>
                    <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                        <span class="text-sm font-light">pm</span>
                        <div class="w-px h-5 bg-primaryclr"></div>
                        <span id="presentPM">0</span>
                    </div>
                </div>
                <div class="w-full h-[1px] bg-primaryclr"></div>
                <div class="text-md text-primaryclr px-10">Present</div>
            </div>
            <!-- late -->
            <div class="bg-accentclr h-full flex-1 rounded-sm">
                <div class="bg-accentclr justify-evenly h-full flex-1 rounded-sm flex p-2 flex-col items-center">
                    <div class="flex gap-2">
                        <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                            <span class="text-sm font-light">am</span>
                            <div class="w-px h-5 bg-primaryclr"></div>
                            <span id="lateAM">0</span>
                        </div>
                        <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                            <span class="text-sm font-light">pm</span>
                            <div class="w-px h-5 bg-primaryclr"></div>
                            <span id="latePM">0</span>
                        </div>
                    </div>
                    <div class="w-full h-[1px] bg-primaryclr"></div>
                    <div class="text-md text-primaryclr px-10">Late</div>
                </div>
            </div>
            <!-- absent -->
            <div class="bg-accentclr h-full w-1/6 rounded-sm">
                <div class="bg-accentclr justify-evenly h-full flex-1 rounded-sm flex p-2 flex-col items-center">
                    <div class="flex gap-2">
                        <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                            <span class="text-sm font-light">am</span>
                            <div class="w-px h-5 bg-primaryclr"></div>
                            <span id="absentAM">0</span>
                        </div>
                        <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                            <span class="text-sm font-light">pm</span>
                            <div class="w-px h-5 bg-primaryclr"></div>
                            <span id="absentPM">0</span>
                        </div>
                    </div>
                    <div class="w-full h-[1px] bg-primaryclr"></div>
                    <div class="text-md text-primaryclr px-10">Absent</div>
                </div>
            </div>
            <div class="bg-accentclr h-full w-1/6 rounded-sm">
                <div class="bg-accentclr justify-evenly h-full flex-1 rounded-sm flex p-2 flex-col items-center">
                    <div class="text-xl font-bold text-primaryclr px-10 text-center">0</div>
                    <div class="w-full h-[1px] bg-primaryclr"></div>
                    <div class="text-sm text-primaryclr text-center">On Leave</div>
                </div>
            </div>
            <div class="bg-accentclr h-full w-1/6 rounded-sm">
                <div class="bg-accentclr justify-evenly h-full flex-1 rounded-sm flex p-2 flex-col items-center">
                    <div class="text-xl font-bold text-primaryclr px-10 text-center">0</div>
                    <div class="w-full h-[1px] bg-primaryclr"></div>
                    <div class="text-sm text-primaryclr text-center">Pending Leave</div>
                </div>
            </div>
            <div class="bg-accentclr h-full w-1/6 rounded-sm">
                <div class="bg-accentclr h-full flex-1 rounded-sm justify-evenly flex p-2 flex-col items-center">
                    <div class="text-xl font-bold text-primaryclr px-10 text-center">20</div>
                    <div class="w-full h-[1px] bg-primaryclr"></div>
                    <div class="text-sm text-primaryclr text-center">Overtime Request</div>
                </div>
            </div>
        </div>
        <div class="w-full flex flex-col mt-1">
            <div class="w-full h-9 flex flex-row items-center ml-1">
                <!-- Search Bar -->
                <label class="input input-sm flex items-center border border-gray-300 rounded-md px-2 focus-within:ring-0 focus-within:border-gray-400">
                    <i class='bx bx-search-alt text-mainclr text-[20px]'></i>
                    <input type="search" id="searchEmployee" class="grow px-2 focus:outline-none" placeholder="search">
                </label>
                <!-- Add New Employee Button -->
                <a class="px-2 py-1 ml-2 font-popins text-sm rounded-sm flex items-center transition-all duration-300 ease-in-out 
                   text-primaryclr bg-accentclr hover:text-mainclr hover:bg-primaryclr active:scale-95 active:opacity-80" id="downloadDTR">
                    <i class='bx bx-download text-xl mr-2'></i>
                    Download DTR Template
                </a>
                <div class="tooltip tooltip-info tooltip-top" data-tip="Only the downloaded DTR template is accepted.">
                    <label for="fileInput" class="cursor-pointer px-2 py-1 ml-2 font-popins text-sm rounded-sm flex items-center transition-all duration-300 ease-in-out 
                   text-primaryclr bg-accentclr hover:text-mainclr hover:bg-primaryclr active:scale-95 active:opacity-80">
                        <i class='bx bx-upload text-xl mr-2'></i>
                        Import
                    </label>
                </div>
                <input type="file" id="fileInput" accept=".xlsx,.xls" class="hidden">
                <!-- Save Button -->
                <button id="saveFile" class="px-2 py-1 ml-2 font-popins text-sm rounded-sm items-center transition-all duration-300 ease-in-out 
                   text-white bg-green-500 hover:bg-green-700 active:scale-95 active:opacity-80 hidden">
                    <i class='bx bx-save text-xl mr-2'></i>
                    Save Data
                </button>
            </div>
            <div class="overflow-x-auto">
                <!-- the script of this is on ../../public/js/timeKeeping/searchInput.js -->
                <table class="table" id="timeTable">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Am</th>
                            <th>Pm</th>
                            <th>Total Hours</th> <!-- Added this column -->
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="timeTable">
                        <?php foreach ($dtrRecords as $dtr): ?>
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle h-12 w-12">
                                                <img src="http://localhost/hris/<?php echo $dtr['emp_profPic']; ?>" alt="Employee Image" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">
                                                <?= htmlspecialchars($dtr['emp_fname'] . ' ' . $dtr['emp_mname'] . ' ' . $dtr['emp_lname'] . ' ' . $dtr['emp_suffix']); ?>
                                            </div>
                                            <div class="text-sm opacity-50"><?= htmlspecialchars($dtr['emp_position']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($dtr['emp_department']); ?></td>

                                <!-- AM Column -->
                                <td>
                                    <div class="flex flex-col">
                                        <span>Time In: <?= ($dtr['am_time_in'] && $dtr['am_time_in'] != '00:00:00') ? date("g:i A", strtotime($dtr['am_time_in'])) : '--'; ?> </span>
                                        <span>Time Out: <?= ($dtr['am_time_out'] && $dtr['am_time_out'] != '00:00:00') ? date("g:i A", strtotime($dtr['am_time_out'])) : '--'; ?></span>

                                    </div>
                                </td>

                                <!-- PM Column -->
                                <td>
                                    <div class="flex flex-col">
                                        <span>Time In: <?= ($dtr['pm_time_in'] && $dtr['pm_time_in'] != '00:00:00') ? date("g:i A", strtotime($dtr['pm_time_in'])) : '--'; ?> </span>
                                        <span>Time Out: <?= ($dtr['pm_time_out'] && $dtr['pm_time_out'] != '00:00:00') ? date("g:i A", strtotime($dtr['pm_time_out'])) : '--'; ?></span>

                                    </div>
                                </td>

                                <!-- Total Hours -->
                                <td class="text-center font-semibold">
                                    <?php
                                    $totalSeconds = 0;
                                    if (!empty($dtr['am_time_in']) && !empty($dtr['am_time_out'])) {
                                        $amIn = strtotime($dtr['am_time_in']);
                                        $amOut = strtotime($dtr['am_time_out']);
                                        if ($amOut > $amIn) {
                                            $totalSeconds += ($amOut - $amIn);
                                        }
                                    }
                                    if (!empty($dtr['pm_time_in']) && !empty($dtr['pm_time_out'])) {
                                        $pmIn = strtotime($dtr['pm_time_in']);
                                        $pmOut = strtotime($dtr['pm_time_out']);
                                        if ($pmOut > $pmIn) {
                                            $totalSeconds += ($pmOut - $pmIn);
                                        }
                                    }
                                    $breakHours = isset($dtr['dept_break_time']) ? floatval($dtr['dept_break_time']) : 0;
                                    $totalHours = ($totalSeconds / 3600) - $breakHours;

                                    echo ($totalHours > 0) ? number_format($totalHours, 2) : '--';
                                    ?>
                                </td>

                                <!-- Status -->
                                <td>
                                    <div class="flex flex-col">
                                        <span class="flex items-center">
                                            <div class="badge-xs badge badge-outline badge-warning mr-1">am </div>
                                            <?= htmlspecialchars($dtr['am_time_remarks'] ?? '--') ?>
                                        </span>
                                        <span>
                                            <div class="badge-xs badge badge-outline badge-error ">pm</div>
                                            <?= htmlspecialchars($dtr['pm_time_remarks'] ?? '--') ?>
                                        </span>
                                    </div>
                                </td>

                                <!-- Action -->
                                <td>
                                    <button class="btn btn-xs btn-circle empDtrEditBtn" id="<?= $dtr['time_id']; ?>">
                                        <i class='bx bx-edit-alt text-lg'></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</body>

</html>