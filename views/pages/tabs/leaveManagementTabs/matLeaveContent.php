<div class="w-full h-[400px] rounded-md flex gap-2 ">
    <div class=" w-full bg-amber-100 rounded-md">
        <div class="text-lg p-2">
            <i class='bx bx-calendar text-lg'></i>
            Maternity Leave Calendar
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>

                        <th>Name</th>
                        <th>Start Date</th>
                        <th>Expected Return</th>
                        <th> Status</th>
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
                                    <div class="font-bold">Arone Sanchez</div>
                                    <div class="text-sm opacity-50">Office</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            06/15/25
                        </td>
                        <td> 06/30/25</td>
                        <th>
                            <div class="badge badge-sm badge-warning">Upcoming</div>
                        </th>
                    </tr>
                    <!-- row 2 -->
                    <tr>

                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle h-12 w-12">
                                        <img
                                            src="https://img.daisyui.com/images/profile/demo/3@94.webp"
                                            alt="Avatar Tailwind CSS Component" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">John Hinollan</div>
                                    <div class="text-sm opacity-50">Office</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            06/15/25
                        </td>
                        <td> 06/30/25</td>
                        <th>
                            <div class="badge badge-sm badge-accent">Active</div>
                        </th>
                    </tr>

            </table>
        </div>
    </div>
    <div class=" w-full flex flex-col bg-amber-100 rounded-md px-2">
        <div class="text-lg py-2"><i class='bx bx-stats text-lg'></i> Maternity Leave Summary</div>
        <div class="flex items-center w-full h-46  rounded-md">
            <div class="flex w-full flex-col lg:flex-row">
                <div class="card bg-base-300 rounded-box grid h-32 grow p-2">
                    Current on Leave
                    <div class="text-[2rem] font-semibold text-center">
                        4
                    </div>
                </div>
                <div class="divider lg:divider-horizontal"></div>
                <div class="card bg-base-300 rounded-box grid h-32 grow p-2">
                    Upcoming This Year
                    <div class="text-[2rem] font-semibold text-center">
                        4
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>