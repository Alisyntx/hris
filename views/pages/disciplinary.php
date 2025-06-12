<div class="w-full h-screen font-popins">
    <div class=" h-auto flex justify-between flex-row rounded-md ">
        <div class="w-auto flex">
            <button class="btn btn-sm btn-primary mr-1" id="leaveRequestBtn">
                <i class='bx bx-plus-circle text-lg'></i>
                Issue NTE
            </button>
            <button class="btn btn-sm mr-1" id="leaveRequestBtn">
                <i class='bx bx-import text-lg'></i>
                Download Reports
            </button>
            <label class="input input-sm ml-1 mr-1">
                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <g
                        stroke-linejoin="round"
                        stroke-linecap="round"
                        stroke-width="2.5"
                        fill="none"
                        stroke="currentColor">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </g>
                </svg>
                <input type="search" class="grow" placeholder="Search" />

            </label>

        </div>

    </div>
    <!-- name of each tab group should be unique -->
    <div class="tabs tabs-lift mt-2">
        <label class="tab">
            <input type="radio" name="my_tabs_4" checked="checked" />
            <i class='bx bx-chart text-lg mr-2'></i>
            Violation Trend
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <?php include "tabs/disciplinaryTabs/violationTrends.php" ?>
        </div>

        <label class="tab">
            <input type="radio" name="my_tabs_4" />
            <i class='bx bx-food-menu text-lg mr-2'></i>
            Incident Report
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-2">
            <?php include "tabs/disciplinaryTabs/leaveRequestContent.php" ?>
        </div>

        <label class="tab">
            <input type="radio" name="my_tabs_4" />
            <i class='bx bx-error-alt text-lg mr-2'></i>
            Notice to Explain (NTE)
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <?php include "tabs/disciplinaryTabs/UtilReportContent.php" ?>
        </div>

        <label class="tab">
            <input type="radio" name="my_tabs_4" />
            <i class='bx bxs-user-x text-lg mr-2'></i>
            Disciplinary Action
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <?php include "tabs/disciplinaryTabs/matLeaveContent.php" ?>
        </div>
    </div>
</div>