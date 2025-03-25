<?php include '../../../database/conn.php';

$empId = $_POST['getId'] ?? null;
$emp = null;

if ($empId) {
    $stmt = $pdo->prepare("SELECT * FROM employee WHERE emp_id = ?");
    $stmt->execute([$empId]);
    $emp = $stmt->fetch();
}
?>

<dialog id="editEmp" class="modal">
    <div class="modal-box font-popins">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="editEmp.close()">✕</button>
        <h3 class="text-lg font-semibold text-center">Edit Employee</h3>
        <form id="editEmpFormBtn" method="post">
            <div class="w-full flex flex-row gap-2">
                <input type="text" placeholder="First Name" value="<?= htmlspecialchars($emp['emp_fname'] ?? '') ?>" name="fname" class="input input-sm w-full mt-2" />
                <input type="text" placeholder="Middle Name" value="<?= htmlspecialchars($emp['emp_mname'] ?? '') ?>" name="mname" class="input input-sm w-full mt-2" />
                <input type="text" placeholder="Last Name" value="<?= htmlspecialchars($emp['emp_lname'] ?? '') ?>" name="lname" class="input input-sm w-full mt-2" />
                <input type="text" placeholder="Suffix" value="<?= htmlspecialchars($emp['emp_suffix'] ?? '') ?>" name="suffix" class="input input-sm w-full mt-2" />
            </div>

            <div class="w-full flex flex-row gap-2">
                <!-- Replacing Gender text input with a dropdown -->
                <select name="gender" class="select select-sm w-full mt-2">
                    <option value="Male" <?= isset($emp['emp_gender']) && $emp['emp_gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= isset($emp['emp_gender']) && $emp['emp_gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= isset($emp['emp_gender']) && $emp['emp_gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>

                <input type="number" placeholder="Age" name="age" value="<?= htmlspecialchars($emp['emp_age'] ?? '') ?>" class="input input-sm w-full mt-2" />
            </div>

            <input type="text" placeholder="Address" name="address" value="<?= htmlspecialchars($emp['emp_address'] ?? '') ?>" class="input input-sm w-full mt-2" />
            <input type="text" placeholder="Position" name="position" value="<?= htmlspecialchars($emp['emp_position'] ?? '') ?>" class="input input-sm w-full mt-2" />
            <input type="text" placeholder="Department" name="department" value="<?= htmlspecialchars($emp['emp_department'] ?? '') ?>" class="input input-sm w-full mt-2" />

            <label for="hireDate" class="mt-2 text-xs">Hire Date</label>
            <input type="date" id="hireDate" name="hireDate" class="input input-sm w-full" value="<?= isset($emp['emp_dateHire']) ? date('Y-m-d', strtotime($emp['emp_dateHire'])) : '' ?>" />

            <!-- Fix duplicate department input -->
            <label for="promotion" class="mt-2 text-xs">Promote This Employee?</label>
            <input type="text" id="promotion" placeholder="Promotion" name="promotion" class="input input-sm w-full" />

            <button class="btn mt-2 btn-sm float-right btn-primary"> Update <i class='bx bx-user-plus text-lg'></i> </button>
        </form>
    </div>
</dialog>

<script type="module" src="public/js/main.js"></script>