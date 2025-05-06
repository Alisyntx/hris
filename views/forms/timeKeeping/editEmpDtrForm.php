<?php
include '../../../database/conn.php';

$timeId = $_POST['getId'] ?? null;
$timeData = null;

if ($timeId) {
    $stmt = $pdo->prepare("
        SELECT t.*, e.emp_fname, e.emp_mname, e.emp_lname, e.emp_suffix, 
               e.emp_position, e.emp_department, e.emp_profPic
        FROM timekeeping t
        INNER JOIN employee e ON t.time_empId = e.emp_id
        WHERE t.time_id = ?
    ");
    $stmt->execute([$timeId]);
    $timeData = $stmt->fetch();
}
?>

<dialog id="dtrEmpEdit" class="modal">
    <div class="modal-box font-popins">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="dtrEmpEdit.close()">✕</button>

        <h3 class="text-lg font-semibold text-center mb-4">Update Daily Time Record</h3>

        <form id="editEmpDtrForm" method="post" enctype="multipart/form-data" class="space-y-1">
            <!-- Avatar Preview -->
            <div class="avatar flex justify-center items-center flex-col relative">
                <div class="w-24 rounded-full overflow-hidden border border-gray-300 shadow-sm cursor-pointer hover:shadow-md transition" id="imagePreview">
                    <img id="previewImg" src="http://localhost/hris/<?= $timeData['emp_profPic'] ?>" class="w-full h-full object-cover" />
                </div>
                <input type="file" id="profileImage" name="profileImage" class="hidden" accept="image/*" />
            </div>

            <!-- Hidden IDs -->
            <input type="hidden" name="time_id" value="<?= htmlspecialchars($timeData['time_id']) ?>" />
            <input type="hidden" name="emp_id" value="<?= htmlspecialchars($timeData['time_empId']) ?>" />
            <div class="flex flex-row w-full  gap-2">
                <div class=" w-full">
                    <!-- Name Display -->
                    <label class="text-xs font-medium text-gray-600">Employee Name</label>
                    <div class="p-2 text-sm bg-gray-100 border border-gray-300 rounded-md">
                        <?= htmlspecialchars($timeData['emp_fname'] . ' ' . $timeData['emp_mname'] . ' ' . $timeData['emp_lname'] . ' ' . $timeData['emp_suffix']) ?>
                    </div>
                </div>

                <div class="w-full">
                    <!-- Position -->
                    <label class="text-xs font-medium text-gray-600">Position</label>
                    <div class="p-2 text-sm  bg-gray-100 border border-gray-300 rounded-md">
                        <?= htmlspecialchars($timeData['emp_position']) ?>
                    </div>
                </div>

            </div>

            <!-- Department -->
            <label class="text-xs font-medium text-gray-600">Department</label>
            <div class="p-2 text-sm bg-gray-100 border border-gray-300 rounded-md">
                <?= htmlspecialchars($timeData['emp_department']) ?>
            </div>
            <!-- AM Section -->
            <div class="flex gap-1">
                <div class="flex w-full gap-1 flex-col">
                    <label class="text-xs font-medium text-gray-600">Am (Time In)</label>
                    <input type="time" name="am_timein" class="input input-sm w-full border-gray-300"
                        value="<?= htmlspecialchars($timeData['am_time_in']) ?>" />
                </div>
                <div class="flex w-full gap-1 flex-col">
                    <label class="text-xs font-medium text-gray-600">Am (Time Out)</label>
                    <input type="time" name="am_timeout" class="input input-sm w-full border-gray-300"
                        value="<?= htmlspecialchars($timeData['am_time_out']) ?>" />
                </div>
                <div class="flex w-full gap-1 flex-col">
                    <label class="text-xs font-medium text-gray-600">Am Remarks</label>
                    <select name="am_remarks" class="select input-sm w-full border-gray-300">
                        <option disabled <?php echo empty($timeData['am_time_remarks']) ? 'selected' : ''; ?>>Select AM Remark</option>
                        <option value="On Time" <?php echo ($timeData['am_time_remarks'] === 'On Time') ? 'selected' : ''; ?>>On Time</option>
                        <option value="On Time (Early Out)" <?php echo ($timeData['am_time_remarks'] === 'On Time (Early Out)') ? 'selected' : ''; ?>>On Time (Early Out)</option>
                        <option value="Late" <?php echo ($timeData['am_time_remarks'] === 'Late') ? 'selected' : ''; ?>>Late</option>
                        <option value="Half Day" <?php echo ($timeData['am_time_remarks'] === 'Half Day') ? 'selected' : ''; ?>>Half Day</option>
                        <option value="Absent" <?php echo ($timeData['am_time_remarks'] === 'Absent') ? 'selected' : ''; ?>>Absent</option>
                    </select>
                </div>

            </div>

            <!-- PM Section -->
            <div class="flex gap-1">
                <div class="flex w-full gap-1 flex-col">
                    <label class="text-xs font-medium text-gray-600">Pm (Time In)</label>
                    <input type="time" name="pm_timein" class="input input-sm w-full border-gray-300"
                        value="<?= htmlspecialchars($timeData['pm_time_in']) ?>" />
                </div>
                <div class="flex w-full gap-1 flex-col">
                    <label class="text-xs font-medium text-gray-600">Pm (Time Out)</label>
                    <input type="time" name="pm_timeout" class="input input-sm w-full border-gray-300"
                        value="<?= htmlspecialchars($timeData['pm_time_out']) ?>" />
                </div>
                <div class="flex w-full gap-1 flex-col">
                    <label class="text-xs font-medium text-gray-600">Pm Remarks</label>
                    <select name="pm_remarks" class="select input-sm w-full border-gray-300">
                        <option disabled <?php echo empty($timeData['pm_time_remarks']) ? 'selected' : ''; ?>>Select PM Remark</option>
                        <option value="On Time" <?php echo ($timeData['pm_time_remarks'] === 'On Time') ? 'selected' : ''; ?>>On Time</option>
                        <option value="On Time (Early Out)" <?php echo ($timeData['pm_time_remarks'] === 'On Time (Early Out)') ? 'selected' : ''; ?>>On Time (Early Out)</option>
                        <option value="Late" <?php echo ($timeData['pm_time_remarks'] === 'Late') ? 'selected' : ''; ?>>Late</option>
                        <option value="Half Day" <?php echo ($timeData['pm_time_remarks'] === 'Half Day') ? 'selected' : ''; ?>>Half Day</option>
                        <option value="Absent" <?php echo ($timeData['pm_time_remarks'] === 'Absent') ? 'selected' : ''; ?>>Absent</option>
                    </select>

                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="btn btn-sm btn-primary">
                    Update <i class='bx bx-user-plus text-lg ml-1'></i>
                </button>
            </div>
        </form>
    </div>
</dialog>

<script type="module" src="public/js/main.js"></script>