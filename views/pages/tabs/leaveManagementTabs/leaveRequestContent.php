<?php
require_once 'database/conn.php'; // Replace with actual filename

// Fetch leave requests along with employee info
$sql = "
    SELECT 
        lr.id,
        lr.leave_type,
        lr.start_date,
        lr.end_date,
        lr.status,
        e.emp_fname,
        e.emp_mname,
        e.emp_lname,
        e.emp_suffix
    FROM leave_request lr
    JOIN employee e ON lr.employee_id = e.emp_id
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$requests = $stmt->fetchAll();

// Query to count requests by status
$sqlCounts = "
    SELECT status, COUNT(*) as count 
    FROM leave_request
    GROUP BY status
";

$stmtCounts = $pdo->prepare($sqlCounts);
$stmtCounts->execute();
$counts = $stmtCounts->fetchAll(PDO::FETCH_KEY_PAIR);

// Helper to get count or 0 if missing
$pendingCount = $counts['pending'] ?? 0;
$approvedCount = $counts['approved'] ?? 0;
$rejectedCount = $counts['rejected'] ?? 0;

?>
<div class="">
    <div class="flex w-full h-32 gap-2 rounded-md ">
        <div class="w-full h-full bg-accentclr flex flex-col justify-between rounded-md p-4">
            <div class="flex text-xl items-center text-primaryclr">
                <i class='bx bx-time-five  mr-2'></i> Pending Request
            </div>
            <div class="text-primaryclr text-xl font-semibold"><?= $pendingCount ?></div>
            <div class="text-primaryclr text-md">Awaiting approval</div>
        </div>
        <div class="w-full h-full bg-accentclr flex flex-col justify-between rounded-md p-4">
            <div class="flex text-xl items-center text-primaryclr">
                <i class='bx bx-check-circle  mr-2'></i> Approved Requests
            </div>
            <div class="text-primaryclr text-2xl font-semibold"><?= $approvedCount ?></div>
            <div class="text-primaryclr text-md">This Month</div>
        </div>
        <div class="w-full h-full bg-accentclr flex flex-col justify-between rounded-md p-4">
            <div class="flex text-xl items-center text-primaryclr">
                <i class='bx bx-x-circle  mr-2'></i> Declined Requests
            </div>
            <div class="text-primaryclr text-xl font-semibold"><?= $rejectedCount ?></div>
            <div class="text-primaryclr text-md">This Month</div>
        </div>
    </div>
    <div class="overflow-x-auto rounded-box border border-base-content/5 mt-5 bg-base-100">
        <table class="table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Days</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $row):
                    // Format full name
                    $fullName = "{$row['emp_fname']} " .
                        (!empty($row['emp_mname']) ? substr($row['emp_mname'], 0, 1) . ". " : "") .
                        "{$row['emp_lname']}" .
                        (!empty($row['emp_suffix']) ? ", {$row['emp_suffix']}" : "");

                    // Calculate leave days (inclusive)
                    $start = new DateTime($row['start_date']);
                    $end = new DateTime($row['end_date']);
                    $days = $start->diff($end)->days + 1;

                    // Badge class based on status
                    $statusClass = match (strtolower($row['status'])) {
                        'pending' => 'badge-warning',
                        'approved' => 'badge-success',
                        'rejected' => 'badge-error',
                        default => 'badge-neutral'
                    };
                ?>
                    <tr>
                        <th><?= htmlspecialchars($fullName) ?></th>
                        <td><?= htmlspecialchars($row['leave_type']) ?></td>
                        <td><?= date('m/d/y', strtotime($row['start_date'])) ?></td>
                        <td><?= date('m/d/y', strtotime($row['end_date'])) ?></td>
                        <td><?= $days ?> day<?= $days > 1 ? 's' : '' ?></td>
                        <td>
                            <div class="badge <?= $statusClass ?> badge-sm"><?= htmlspecialchars($row['status']) ?></div>
                        </td>
                        <td>
                            <button class="btn btn-xs btn-decline" data-id="<?= $row['id'] ?>"><i class='bx bx-x-circle text-lg'></i></button>
                            <button class="btn btn-xs btn-approve" data-id="<?= $row['id'] ?>"><i class='bx bx-check-circle text-lg'></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>