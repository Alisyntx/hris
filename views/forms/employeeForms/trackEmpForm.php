<?php
include '../../../database/conn.php';

$empId = $_POST['getId'] ?? null;
$emp = null;
$nextEvalDate = null;
$nextEvalType = 'N/A';
$status = 'Pending';

if ($empId) {
    // Fetch employee details and latest evaluation
    $stmt = $pdo->prepare("
        SELECT e.emp_id, e.emp_fname, e.emp_mname, e.emp_lname, e.emp_suffix, 
               e.emp_position, e.emp_department, e.emp_dateHire, 
               ev.empEval_date, ev.empEval_type, ev.empEval_status
        FROM employee e
        LEFT JOIN employee_evaluation ev ON e.emp_id = ev.empEval_emp_id
        WHERE e.emp_id = ?
        ORDER BY ev.empEval_date DESC LIMIT 1
    ");
    $stmt->execute([$empId]);
    $emp = $stmt->fetch();

    if ($emp) {
        $hireDate = new DateTime($emp['emp_dateHire']);
        $today = new DateTime();

        // Define evaluation periods
        $threeMonthEval = clone $hireDate;
        $threeMonthEval->modify('+3 months');

        $fiveMonthEval = clone $hireDate;
        $fiveMonthEval->modify('+5 months');

        $annualEval = clone $hireDate;
        $annualEval->modify('+1 year');

        // Determine the next evaluation
        if ($today < $threeMonthEval) {
            $nextEvalDate = $threeMonthEval->format('F j, Y');
            $nextEvalType = '3-Month Evaluation';
        } elseif ($today < $fiveMonthEval) {
            $nextEvalDate = $fiveMonthEval->format('F j, Y');
            $nextEvalType = '5-Month Evaluation';
        } elseif ($today < $annualEval) {
            $nextEvalDate = $annualEval->format('F j, Y');
            $nextEvalType = 'Annual Evaluation';
        } else {
            // If past all evaluations, set next annual evaluation
            $annualEval->modify('+1 year');
            $nextEvalDate = $annualEval->format('F j, Y');
            $nextEvalType = 'Annual Evaluation';
        }

        // Set evaluation status
        $status = $emp['empEval_status'] ?? 'Pending';
    }
}
?>

<dialog id="detailsEmp" class="modal">
    <div class="modal-box rounded-lg w-11/12 max-w-5xl shadow-xl p-6 bg-white font-popins">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="detailsEmp.close()">✕</button>
        <div class="text-center">
            <h3 class="text-xl font-semibold text-gray-800">Track Evaluation</h3>
            <p class="text-sm text-gray-500">Employee Track Evaluation</p>
            <button class="btn btn-xs bg-accentclr rounded-md text-primaryclr">View History</button>
        </div>
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Hire Date</th>
                        <th>Next Evaluation</th>
                        <th>Evaluation Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($emp): ?>
                        <tr>
                            <td><?= htmlspecialchars($emp['emp_fname'] . ' ' . $emp['emp_mname'] . ' ' . $emp['emp_lname'] . ' ' . $emp['emp_suffix']) ?></td>
                            <td><?= date('F j, Y', strtotime($emp['emp_dateHire'])) ?></td>
                            <td><?= $nextEvalDate ?></td>
                            <td><?= $nextEvalType ?></td>
                            <td id="status-<?= $emp['emp_id'] ?>"><?= $status ?></td>
                            <td>
                                <button class='btn btn-sm btn-primary mark-complete' id='<?= $emp['emp_id'] ?>'>
                                    Mark as Complete
                                </button>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No evaluation data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</dialog>