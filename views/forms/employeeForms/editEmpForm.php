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
        <form id="editEmpFormBtn" method="post" enctype="multipart/form-data">
            <div class="avatar flex justify-center items-center flex-col relative">
                <div class="w-24 rounded-lg overflow-hidden border border-gray-300 cursor-pointer relative" id="imagePreview">
                    <img id="previewImg" src="http://localhost/hris/<?php echo $emp['emp_profPic']; ?>" class="w-full h-full object-cover" />
                    <!-- Camera Icon Overlay -->
                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition duration-200">
                        <i class="bx bx-camera text-white text-2xl"></i>
                    </div>
                </div>
                <!-- Hidden File Input -->
                <input type="file" id="profileImage" name="profileImage" class="hidden" accept="image/*" />
                <!-- Hint Text -->
                <p class="text-xs text-gray-500 mt-1">Click to upload a profile picture</p>
            </div>
            <div class="w-full flex flex-row gap-2">
                <input type="hidden" name="emp_id" value="<?= htmlspecialchars($emp['emp_id'] ?? '') ?>" />
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
            <label for="promotion" class="mt-2 text-xs">Change Department?</label>
            <input type="text" placeholder="Department" name="department" value="<?= htmlspecialchars($emp['emp_department'] ?? '') ?>" class="input input-sm w-full" />

            <label for="hireDate" class="mt-2 text-xs">Hire Date</label>
            <input type="date" id="hireDate" name="hireDate" class="input input-sm w-full" value="<?= isset($emp['emp_dateHire']) ? date('Y-m-d', strtotime($emp['emp_dateHire'])) : '' ?>" />

            <!-- Fix duplicate department input -->
            <label for="promotion" class="mt-2 text-xs">Promote This Employee?</label>
            <input type="text" id="promotion" placeholder="Promotion" name="promotion" value="<?= htmlspecialchars($emp['emp_promotion'] ?? '') ?>" class="input input-sm w-full" />

            <button class="btn mt-2 btn-sm float-right btn-primary"> Update <i class='bx bx-user-plus text-lg'></i> </button>
        </form>
    </div>
</dialog>
<script>
    document.getElementById("imagePreview").addEventListener("click", function() {
        document.getElementById("profileImage").click();
    });

    document.getElementById("profileImage").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("previewImg").src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
<script type="module" src="public/js/main.js"></script>