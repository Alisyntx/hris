<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>

</head>

<body>
    <div class="w-auto h-svh rounded-sm mr-1 overflow-hidden  font-popins">
        <div class="w-full py-1 flex gap-4 px-2 items-center rounded-md border-b-[1px] border-primaryclr ">
            <!-- Start Date Picker -->
            <button popovertarget="cally-popover1" class="input input-border input-sm" id="cally1">
                Pick a start date
            </button>
            <div popover id="cally-popover1" class="dropdown bg-base-100 rounded-box shadow-lg">
                <calendar-date class="cally" id="start-date-picker">
                    <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M15.75 19.5 8.25 12l7.5-7.5"></path>
                    </svg>
                    <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                    </svg>
                    <calendar-month></calendar-month>
                </calendar-date>
            </div>

            <!-- End Date Picker -->
            <button popovertarget="cally-popover2" class="input input-border input-sm" id="cally2">
                Pick an end date
            </button>
            <div popover id="cally-popover2" class="dropdown bg-base-100 rounded-box shadow-lg">
                <calendar-date class="cally" id="end-date-picker">
                    <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M15.75 19.5 8.25 12l7.5-7.5"></path>
                    </svg>
                    <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                    </svg>
                    <calendar-month></calendar-month>
                </calendar-date>
            </div>

            <!-- Filters -->
            <select class="select select-bordered select-sm " id="departmentSelect">

            </select>
            <div class="relative">
                <input type="text" class="input input-sm input-bordered w-full" placeholder="Search Employee">
                <ul class="autocomplete-list absolute mt-2 rounded-md z-50 bg-primaryclr border text-sm border-mainclr w-full hidden"></ul>
            </div>

            <button class="btn btn-primary btnFilters btn-sm">Apply Filters</button>
            <button class="btn btn-primary btnFilters btn-sm flex items-center" id="exportExcelBtn">
                <i class='bx bx-export text-xl' style='color:#ffffff'></i> Export</button>
        </div>
        <div class="w-full h-full  px-4 mt-2 mb-2">
            <table class="table table-bordered overflow-hidden w-full" id="tableDTR">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Total Hours</th>
                        <th>Remarks</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="attendance-data">

                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.getElementById('start-date-picker').addEventListener('change', function() {
            document.getElementById('cally1').innerText = this.value;
        });

        document.getElementById('end-date-picker').addEventListener('change', function() {
            document.getElementById('cally2').innerText = this.value;
        });
    </script>
</body>

</html>