<?php
include '../../../database/conn.php';

$empId = $_POST['getId'] ?? null;
$emp = null;

if ($empId) {
    $stmt = $pdo->prepare("SELECT * FROM employee WHERE emp_id = ?");
    $stmt->execute([$empId]);
    $emp = $stmt->fetch();
}
?>

<dialog id="detailsEmp" class="modal">
    <div class="modal-box rounded-lg shadow-xl p-6 bg-white font-popins">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="detailsEmp.close()">✕</button>

        <div class="text-center">
            <h3 class="text-xl font-semibold text-gray-800">Employee Details</h3>
            <p class="text-sm text-gray-500">View employee information</p>
        </div>

        <?php if ($emp): ?>
            <div class="mt-4 space-y-3 border-t border-gray-200 pt-4">
                <div class="flex items-center mt-2">
                    <span class="font-medium text-gray-700 w-24">Name: </span>
                    <span class="text-gray-900"> <?php echo htmlspecialchars($emp['emp_fname'] . ' ' . $emp['emp_mname'] . ' ' . $emp['emp_lname'] . ' ' . $emp['emp_suffix']); ?></span>
                </div>
                <div class="flex items-center">
                    <span class="font-medium text-gray-700 w-24">Age: </span>
                    <span class="text-gray-900"><?php echo htmlspecialchars($emp['emp_age']); ?></span>
                </div>
                <div class="flex items-center">
                    <span class="font-medium text-gray-700 w-24">Gender: </span>
                    <span class="text-gray-900"><?php echo htmlspecialchars($emp['emp_gender']); ?></span>
                </div>
                <div class="flex items-start">
                    <span class="font-medium text-gray-700 w-24">Address: </span>
                    <span class="text-gray-900"><?php echo htmlspecialchars($emp['emp_address']); ?></span>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center text-red-500 font-medium mt-4">No data found for this employee.</p>
        <?php endif; ?>

        <div class="modal-action">
            <button class="btn rounded-lg btn-sm bg-red-500 text-gray-100" onclick="alert('Are you sure ypu want to remove this employee'); detailsEmp.close()">Deactivate</button>
        </div>
    </div>
</dialog>