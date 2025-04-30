<dialog id="addDept" class="modal">
    <div class="modal-box font-popins">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="addDept.close()">✕</button>
        <h3 class="text-lg font-semibold text-center">Add Department</h3>
        <form id="addDeptFormBtn">
            <div class="w-full flex flex-col mt-2">
                <label class="text-sm flex items-center font-medium text-gray-600">Department Name</label>
                <input name="dept_name" required class="p-2 text-sm bg-gray-100 border border-gray-300 rounded-md mt-1" />
                <label class="text-sm flex items-center font-medium text-gray-600 mt-2">AM Time-In/Time-Out <i class='ml-1 bx bx-time'></i></label>
                <div class="flex w-full gap-1">
                    <input type="time" name="dept_amtime_in" required class="w-full p-2 text-sm bg-gray-100 border border-gray-300 rounded-md mt-1" />
                    <input type="time" name="dept_amtime_out" required class="w-full p-2 text-sm bg-gray-100 border border-gray-300 rounded-md mt-1" />
                </div>
                <label class="text-sm flex items-center font-medium text-gray-600 mt-2">PM Time-In/Time-Out <i class='ml-1 bx bx-time'></i></label>
                <div class="flex w-full gap-1">
                    <input type="time" name="dept_pmtime_in" required class="w-full p-2 text-sm bg-gray-100 border border-gray-300 rounded-md mt-1" />
                    <input type="time" name="dept_pmtime_out" required class="w-full p-2 text-sm bg-gray-100 border border-gray-300 rounded-md mt-1" />
                </div>


                <label class="text-sm flex font-medium text-gray-600 items-center mt-2">Break Duration (in hours) <i class='ml-1 bx bx-time'></i></label>
                <input
                    type="number"
                    step="0.1"
                    min="0"
                    max="10"
                    name="dept_break_duration"
                    class="p-2 text-sm bg-gray-100 border border-gray-300 rounded-md mt-1 w-full"
                    required
                    placeholder="e.g., 1.0 for 1 hour or 0.5 for 30 mins" />
                <small class="text-xs text-gray-500 mt-1 block">
                    ⏳ Enter total break duration in hours. This will be subtracted from working hours in attendance reports.
                </small>
            </div>
            <button type="submit" class="btn mt-4 btn-sm float-right btn-primary">Add</button>
        </form>
    </div>
</dialog>