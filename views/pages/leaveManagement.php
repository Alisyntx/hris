<div class="w-full h-screen font-popins">
    <div class=" h-auto flex justify-between flex-row rounded-md ">
        <div class="w-auto flex">
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
            <button class="btn btn-sm mr-20">
                <i class='bx bxs-check-circle text-lg'></i>
                Accept/Reject Leave
            </button>
        </div>

    </div>
    <!-- name of each tab group should be unique -->
    <div class="tabs tabs-lift mt-2">
        <label class="tab">
            <input type="radio" name="my_tabs_4" checked="checked" />
            <i class='bx bx-hdd text-lg mr-2'></i>
            Leave Balances
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <div class="overflow-x-auto">
                <div class="font-semibold flex items-center"><i class='text-2xl bx mr-1 text-blue-500 bxs-user-account'></i>
                    Available Leave Credits per Employee </div>
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>

                            <th>Employee</th>
                            <th>Department</th>
                            <th>Total Leave</th>
                            <th>Used</th>
                            <th>Remaining</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- row 1 -->
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle h-12 w-12">
                                            <img
                                                src="https://img.daisyui.com/images/profile/demo/2@94.webp"
                                                alt="Avatar Tailwind CSS Component" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">Hart Hagerty</div>
                                        <div class="text-sm opacity-50">Web Developer</div>
                                    </div>
                                </div>
                            </td>

                            <td>Office</td>
                            <td><span class="badge badge-outline badge-primary badge-sm"> 25 Days</span></td>
                            <td><span class="badge badge-outline badge-info badge-sm"> 19 Days</span></td>
                            <td><span class="badge badge-outline badge-warning badge-sm"> 22 Days</span></td>
                            <td><span class="badge badge-outline badge-accent badge-sm"> 25 Days</span></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <label class="tab">
            <input type="radio" name="my_tabs_4" />
            <i class='bx bx-time text-lg mr-2'></i>

            Leave Requests
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-6">Tab content 2</div>

        <label class="tab">
            <input type="radio" name="my_tabs_4" />
            <i class='bx bx-objects-horizontal-left text-lg mr-2'></i>

            Utilization Report
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-6">Tab content 3</div>
        <label class="tab">
            <input type="radio" name="my_tabs_4" />
            <i class='bx bx-calendar text-lg mr-2'></i>

            Maternity Leave Calendar
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-6">Tab content 3</div>
    </div>
</div>