<?php
include '../../../database/conn.php';

$empId = $_POST['getId'] ?? null;
$emp = null;


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
}
?>



<!-- Confirmation Modal -->
<dialog id="deleteEmp" class="modal">
    <div class="modal-box rounded-lg w-96 shadow-xl p-6 bg-white font-popins">
        <h3 class="text-lg font-semibold text-center text-red-600 flex items-center justify-center"><i class='bx bx-error text-2xl'></i> Warning!</h3>
        <p class="text-center mt-2">Are you sure you want to delete this employee? This action cannot be undone.</p>

        <form id="deleteEmpAction" class="flex justify-center gap-4 mt-5">
            <!-- Hidden Input for Employee ID -->
            <input type="hidden" name="emp_id" value="<?php echo $emp['emp_id']; ?>">

            <!-- Confirm Delete Button -->
            <button type="submit" class="btn btn-error btn-sm">Yes, Delete</button>

            <!-- Cancel Button to Close Modal -->
            <button type="button" class="btn btn-ghost btn-sm" onclick="this.closest('dialog').close();">Cancel</button>
        </form>

    </div>
</dialog>
<script src="public/js/main.js"></script>