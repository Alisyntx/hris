<?php
include '../../../database/conn.php';
$stmt = $pdo->query("SELECT dept_id, dept_name FROM departments");
$departments = $stmt->fetchAll();
?>
<dialog id="addEmp" class="modal">
    <div class="modal-box font-popins">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="addEmp.close()">✕</button>
        <h3 class="text-lg font-semibold text-center">Add Employee</h3>
        <form class="flex flex-col" id="addEmpFormBtn" method="post" enctype="multipart/form-data">
            <div class="avatar flex justify-center items-center flex-col relative">
                <div class="w-24 rounded-lg overflow-hidden border border-gray-300 cursor-pointer relative" id="imagePreview">
                    <img id="previewImg" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" class="w-full h-full object-cover" />

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
                <input type="text" placeholder="firstname" name="fname" class="input input-sm w-full mt-2" />
                <input type="text" placeholder="middlename" name="mname" class="input input-sm w-full mt-2" />
                <input type="text" placeholder="lastname" name="lname" class="input input-sm w-full mt-2" />
                <input type="text" placeholder="suffix" name="suffix" class="input input-sm w-full mt-2" />
            </div>

            <div class="w-full flex flex-row gap-2">
                <select name="gender" class="select select-sm w-full mt-2">
                    <option disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>

                <input type="text" placeholder="age" name="age" class="input input-sm w-full mt-2" />
            </div>
            <input type="text" placeholder="address" name="address" class="input input-sm w-full mt-2" />
            <input type="text" placeholder="Position" name="position" class="input input-sm w-full mt-2" />
            <label class="form-control w-full flex flex-col">
                <div class="label">
                    <span class="label-text text-sm">Select Department</span>
                </div>
                <select name="department" class="select select-info w-full select-sm" required>
                    <option disabled selected>Select Department</option>
                    <?php foreach ($departments as $dept): ?>
                        <option class="font-popins" value="<?= htmlspecialchars($dept['dept_name']) ?>">
                            <?= htmlspecialchars($dept['dept_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label for="hire date" class="mt-2 text-xs">Hire Date</label>
            <input type="date" placeholder="hire date" name="hireDate" class="input input-sm w-full" />

            <button class="btn mt-2 btn-sm float-right btn-primary "> Add<i class='bx bx-user-plus text-lg'></i> </button>
        </form>
    </div>
</dialog>
<script type="module" src="public/js/main.js"></script>