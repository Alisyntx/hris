<div class="flex flex-column w-full gap-2">
    <div class=" w-full  h-96 rounded-sm p-2 bg-amber-100">
        <div class=" text-lg flex items-center font-sembold"> <i class='bx bx-pie-chart-alt-2 mr-2'></i> Leave Utilization Summary </div>
        <div class="stats stats-vertical w-full">
            <div class="stat">
                <div class="stat-title">Total Employees</div>
                <div class="stat-value">10</div>
                <div class="stat-desc">Jan 1st - Feb 1st</div>
            </div>

            <div class="stat">
                <div class="stat-title">Average Leave Taken</div>
                <div class="stat-value">20.5 days</div>
                <div class="stat-desc">↗︎ 400 (22%)</div>
            </div>

            <div class="stat">
                <div class="stat-title">Department with Highest Usage</div>
                <div class="stat-value">Marketing</div>

            </div>
        </div>
    </div>
    <div class=" w-full bg-amber-100 h-96 rounded-sm ">
        <div class=" flex p-2 items-center text-lg">
            <i class='bx bx-down-arrow-circle text-lg mr-2'></i>
            Generate Reports
        </div>
        <div class="p-2">
            <fieldset class="fieldset w-full">
                <legend class="fieldset-legend">Report Type</legend>
                <select class="select w-full">
                    <option disabled selected>Pick Report Type</option>
                    <option>Monthly Leave Summary</option>
                    <option>Employee Leave Balance</option>
                    <option>Department Wise Report</option>
                    <option>Leave Trend Analysis</option>
                </select>
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">Date Range</legend>
                <div class="w-full flex gap-1.5">
                    <div class="flex flex-col w-full">
                        <input type="date" placeholder="Type here" class="input w-full" />
                        <span class="label">Start Date</span>
                    </div>
                    <div class="flex flex-col w-full">
                        <input type="date" placeholder="Type here" class="input w-full" />
                        <span class="label">End Date</span>
                    </div>
                </div>
            </fieldset>
            <button class="btn btn-primary mt-23 float-end ">
                <i class='bx bx-import text-lg mr-2'></i>
                Generate Report
            </button>




        </div>
    </div>
</div>