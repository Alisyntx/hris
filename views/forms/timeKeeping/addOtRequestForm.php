<dialog id="addOtReq" class="modal">
    <div class="modal-box font-popins">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="addOtReq.close()">✕</button>
        <h3 class="text-lg font-semibold text-center">Overtime Request</h3>
        <form id="addOtFormBtn">
            <div class="w-full flex flex-col mt-2">
                <label class="text-sm flex items-center font-medium text-gray-600">Employe Name</label>
                <input name="otEmpName" required class="input input-primary w-full p-2 text-sm bg-gray-100 border border-gray-300 rounded-md mt-1" list="employeeList" />
                <datalist id="employeeList">
                    <?php include '../../../api/timeKeeping/fetch_employe_dp.php'; ?>
                </datalist>
                <label class="text-sm flex items-center font-medium text-gray-600 mt-2">Time<i class='ml-1 bx bx-time'></i></label>
                <div class="flex w-full gap-2 items-center">
                    <input type="time" name="ot_start_time" required class="w-full p-2 text-sm bg-gray-100 border border-gray-300 rounded-md mt-1" />
                    <div class="text-sm text-gray-600">To</div>
                    <input type="time" name="ot_end_time" required class="w-full p-2 text-sm bg-gray-100 border border-gray-300 rounded-md mt-1" />
                </div>
                <label class="text-sm flex font-medium text-gray-600 items-center mt-2">Date <i class=' ml-1 bx bx-time'></i></label>
                <input type="date" name="otDate" required class="p-2 text-sm bg-gray-100 border border-gray-300 rounded-md mt-1" />

                <label class="text-sm flex font-medium text-gray-600 items-center mt-2">Reason</label>
                <textarea
                    type="text"
                    name="otReason" class="text-sm textarea textarea-primary mt-1 bg-gray-100 border border-gray-300 rounded-md w-full">
                </textarea>
            </div>
            <button type="submit" class="btn mt-4 btn-sm float-right btn-primary">Add</button>
        </form>
    </div>
</dialog>