<dialog id="leaveReq" class="modal">
    <div class="modal-box font-poppins">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <div class="text-lg mb-10 font-semibold font-popins text-center">Create Leave Request</div>
        <form id="saveRequestForm">
            <label class="select w-full">
                <span class="label">Employee</span>
                <select name="employee_id" required>
                    <?php
                    include '../../../database/conn.php';

                    $stmt = $pdo->query("SELECT emp_id, emp_fname, emp_mname, emp_lname, emp_suffix FROM employee");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $fullName = $row['emp_fname'] . ' ' .
                            ($row['emp_mname'] ? $row['emp_mname'][0] . '.' : '') . ' ' .
                            $row['emp_lname'] . ' ' .
                            ($row['emp_suffix'] ?? '');

                        echo '<option value="' . $row['emp_id'] . '">' . trim($fullName) . '</option>';
                    }
                    ?>
                </select>
            </label>
            <label class="floating-label mt-2 w-full">
                <span>Leave Type</span>
                <input type="text" name="leave_type" placeholder="Leave Type" class="input input-md w-full" required />
            </label>

            <label class="input w-full mt-2">
                <span class="label">Start date</span>
                <input type="date" name="start_date" required />
            </label>

            <label class="input w-full mt-2">
                <span class="label">End date</span>
                <input type="date" name="end_date" required />
            </label>

            <div class="mt-2 float-right">
                <button class="btn btn-sm btn-primary" type="submit">Save</button>
            </div>
        </form>

    </div>
</dialog>