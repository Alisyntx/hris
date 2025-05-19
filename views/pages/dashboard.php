<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
</head>

<body>
    <div class="w-full h-screen font-popins flex gap-1">
        <div class="w-[50%] h-full rounded-sm flex gap-2 flex-col ">
            <div class="w-full h-[20%] flex flex-col gap-1 ">
                <div class="flex h-full flex-row gap-1 justify-evenly ">
                    <div class="w-full  rounded-sm bg-accentclr items-center flex flex-col justify-evenly p-2">
                        <div class="text-lg text-primaryclr px-10 text-center">20</div>
                        <div class="w-full h-[1px] bg-primaryclr"></div>
                        <div class="text-md text-primaryclr px-10">Active</div>
                    </div>
                    <div class="w-full  rounded-sm bg-accentclr items-center flex flex-col justify-evenly p-2">
                        <div class="text-lg text-primaryclr px-10 text-center">20</div>
                        <div class="w-full h-[1px] bg-primaryclr"></div>
                        <div class="text-md text-primaryclr px-10">On Leave</div>
                    </div>
                    <div class="w-full  rounded-sm bg-accentclr flex flex-col items-center justify-evenly p-2">
                        <div class="text-lg text-primaryclr px-10 text-center">20</div>
                        <div class="w-full h-[1px] bg-primaryclr"></div>
                        <div class="text-md text-primaryclr px-10">Resigned</div>
                    </div>
                </div>
                <div class="w-full">
                    <div class=" flex-row flex justify-between gap-1 text-sm">
                        <button id="addEmployee" class="hover:bg-mainclr transition shadow-lg flex items-center justify-evenly p-2 w-full bg-accentclr text-primaryclr font-normal rounded-md"><i class='bx bx-message-square-add text-lg'></i> Add employee</button>

                        <a href="index.php?page=employees" class="hover:bg-mainclr transition shadow-lg flex items-center justify-evenly  p-2 w-full bg-accentclr text-primaryclr font-normal rounded-md"><i class='bx bx-message-square-edit text-lg'></i> Update employee
                        </a>

                        <button class="hover:bg-mainclr transition shadow-lg flex items-center justify-evenly  p-2 w-full bg-accentclr text-primaryclr font-normal rounded-md" id="addOtRequest"><i class='bx bx-timer text-lg'></i> Request Overtime</button>
                    </div>
                </div>
            </div>
            <!-- latest HR Announcements & Memos -->
            <div class="w-full h-auto">
                <div class="bg-primaryclr p-4 shadow-lg rounded-lg h-full flex flex-col">
                    <h2 class="text-lg font-semibold mb-3">📌 Latest HR Announcements & Memos</h2>
                    <!-- Scrollable List -->
                    <div class="overflow-y-auto flex-1 pr-2" style="max-height: 340px;">
                        <ul class="divide-y divide-gray-300">
                            <li class="py-2">
                                <h3 class="font-medium text-md">🚀 Company Meeting</h3>
                                <p class="text-sm text-gray-600">Friday at 2 PM. Attendance required.</p>
                                <span class="text-xs text-gray-400">March 17, 2025</span>
                            <li class="py-2">
                                <h3 class="font-medium text-md">📢 Dress Code Update</h3>
                                <p class="text-sm text-gray-600">New policy starts next week.</p>
                                <span class="text-xs text-gray-400">March 15, 2025</span>
                            </li>
                            <li class="py-2">
                                <h3 class="font-medium text-md">📢 Policy Changes</h3>
                                <p class="text-sm text-gray-600">New guidelines for remote work.</p>
                                <span class="text-xs text-gray-400">March 12, 2025</span>
                            </li>
                            <li class="py-2">
                                <h3 class="font-medium text-md">📢 New Office Hours</h3>
                                <p class="text-sm text-gray-600">Office hours are now 8 AM - 5 PM.</p>
                                <span class="text-xs text-gray-400">March 10, 2025</span>
                            </li>
                            <li class="py-2">
                                <h3 class="font-medium text-md">📢 New Office Hours</h3>
                                <p class="text-sm text-gray-600">Office hours are now 8 AM - 5 PM.</p>
                                <span class="text-xs text-gray-400">March 10, 2025</span>
                            </li>
                            <li class="py-2">
                                <h3 class="font-medium text-md">📢 New Office Hours</h3>
                                <p class="text-sm text-gray-600">Office hours are now 8 AM - 5 PM.</p>
                                <span class="text-xs text-gray-400">March 10, 2025</span>
                            </li>
                        </ul>
                    </div>
                    <!-- View All Button -->
                    <button class="mt-2 w-[20%] bg-accentclr text-white py-1 text-sm rounded-lg hover:bg-mainclr transition">
                        View All
                    </button>
                </div>
            </div>
        </div>
        <!-- Attendance Summary -->
        <div class="flex flex-col w-[50%] h-full gap-1">
            <div class="w-full p-1 h-[28%] bg-primaryclr rounded-md flex flex-col">
                <div class=" text-center text-lg text-mainclr font-semibold">Attendance Summary</div>
                <div class="flex flex-col w-full h-full gap-1">
                    <div class="flex flex-row w-full mt-2 h-full gap-1">
                        <div class="bg-accentclr justify-evenly h-full flex-1 rounded-sm flex p-2 flex-col items-center">
                            <div class="text-md text-primaryclr ">On Time</div>
                            <div class="w-full h-[1px] bg-primaryclr"></div>
                            <div class="flex gap-2">
                                <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                                    <span class="text-sm font-light">am</span>
                                    <div class="w-px h-5 bg-primaryclr"></div>
                                    <span id="presentAM">0</span>
                                </div>
                                <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                                    <span class="text-sm font-light">pm</span>
                                    <div class="w-px h-5 bg-primaryclr"></div>
                                    <span id="presentPM">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-accentclr h-full flex-1 rounded-sm">
                            <div class="bg-accentclr justify-evenly h-full flex-1 rounded-sm flex p-2 flex-col items-center">
                                <div class="text-md text-primaryclr px-10">Late</div>
                                <div class="w-full h-[1px] bg-primaryclr"></div>
                                <div class="flex gap-2">
                                    <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                                        <span class="text-sm font-light">am</span>
                                        <div class="w-px h-5 bg-primaryclr"></div>
                                        <span id="lateAM">0</span>
                                    </div>
                                    <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                                        <span class="text-sm font-light">pm</span>
                                        <div class="w-px h-5 bg-primaryclr"></div>
                                        <span id="latePM">0</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="bg-accentclr justify-evenly h-full flex-1 rounded-sm flex p-2 flex-col items-center">
                            <div class="text-md text-primaryclr px-10">Absent</div>
                            <div class="w-full h-[1px] bg-primaryclr"></div>
                            <div class="flex gap-2">
                                <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                                    <span class="text-sm font-light">am</span>
                                    <div class="w-px h-5 bg-primaryclr"></div>
                                    <span id="absentAM">0</span>
                                </div>
                                <div class="text-xl font-bold flex items-center gap-1 text-primaryclr text-center">
                                    <span class="text-sm font-light">pm</span>
                                    <div class="w-px h-5 bg-primaryclr"></div>
                                    <span id="absentPM">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-[29%]  h-full bg-accentclr flex-col items-center justify-evenly flex rounded-md p-1">
                            <div class="text-lg text-primaryclr">50</div>
                            <div class="w-full h-[1px] bg-primaryclr"></div>
                            <div class="text-md text-primaryclr">On Leave</div>
                        </div>
                    </div>
                    <div class="w-full h-full flex gap-1">
                        <div class="h-[50%] w-full rounded-md flex text-primaryclr justify-evenly items-center bg-accentclr">
                            2
                            <div class="w-[1px] h-full bg-primaryclr"></div>
                            Pending Leave
                        </div>
                        <div class="h-[50%] w-full rounded-md flex text-primaryclr justify-evenly items-center bg-accentclr">
                            2
                            <div class="w-[1px] h-full bg-primaryclr"></div>
                            Overtime Request
                        </div>
                    </div>
                </div>
            </div>
            <!--  Disciplinary Action Report -->
            <div class="w-full h-[40%] ">
                <div id="disciplinary" class="tab-content bg-primaryclr p-4 shadow-lg rounded-lg h-[350px] flex flex-col">
                    <h2 class="text-lg font-semibold mb-3 text-red-600">⚠️ Disciplinary Action Report</h2>
                    <div class="overflow-y-auto flex-1 pr-2" style="max-height: 250px;">
                        <ul class="divide-y divide-gray-300">
                            <li class="py-2">
                                <h3 class="font-medium text-md text-red-600">⛔ Tardiness</h3>
                                <p class="text-sm text-gray-600">Employee X has been late 3 times this month.</p>
                                <span class="text-xs text-gray-400">March 16, 2025</span>
                            </li>
                            <li class="py-2">
                                <h3 class="font-medium text-md text-red-600">⛔ Tardiness</h3>
                                <p class="text-sm text-gray-600">Employee X has been late 3 times this month.</p>
                                <span class="text-xs text-gray-400">March 16, 2025</span>
                            </li>
                            <li class="py-2">
                                <h3 class="font-medium text-md text-red-600">⛔ Tardiness</h3>
                                <p class="text-sm text-gray-600">Employee X has been late 3 times this month.</p>
                                <span class="text-xs text-gray-400">March 16, 2025</span>
                            </li>
                        </ul>
                    </div>
                    <button class="mt-2 w-[20%] bg-accentclr text-white py-1 text-sm rounded-lg hover:bg-mainclr transition">
                        View All
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full h-full  font-popins">
        <div class="p-2 bg-primaryclr shadow-lg overflow-x-auto rounded-box border border-base-content/5">
            <h2 class="text-lg font-bold mb-4">Performance Evaluation Reminders</h2>
            <table class="table ">
                <thead>
                    <tr class="bg-gray-200 text-gray-600">
                        <th>Name</th>
                        <th>Position</th>
                        <th>Days Since Hired</th>
                        <th>Evaluation Type</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 3-Month Evaluation -->
                    <tr class=" bg-yellow-100">
                        <td>John Doe</td>
                        <td>Software Developer</td>
                        <td>90 days</td>
                        <td class="font-bold text-yellow-700">3-Month Evaluation</td>
                    </tr>
                    <!-- 5-Month Probationary -->
                    <tr class=" bg-orange-100">
                        <td>Jane Smith</td>
                        <td>HR Assistant</td>
                        <td>150 days</td>
                        <td class="font-bold text-orange-700">5-Month Probationary Review</td>
                    </tr>
                    <!-- Annual Evaluation -->
                    <tr class=" bg-blue-100">
                        <td>Mark Wilson</td>
                        <td>Senior Manager</td>
                        <td>365 days</td>
                        <td class="font-bold text-blue-700">Annual Evaluation</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- incentive-based allowance -->
        <div class="p-2 bg-primaryclr shadow-lg overflow-x-auto rounded-box border border-base-content/5 font-popins mt-2">
            <h2 class="text-lg font-bold mb-4">💰 Incentive-Based Allowance Summary</h2>
            <!-- Total Incentives Overview -->
            <div class="flex justify-between items-center bg-green-100 p-4 rounded-lg shadow-sm">
                <h3 class="text-md font-bold text-green-700">Total Incentives Distributed</h3>
                <p class="text-2xl font-bold text-green-800">₱50,000</p>
            </div>

            <!-- Breakdown Table -->
            <table class="table w-full mt-4 border">
                <thead>
                    <tr class="bg-gray-200 text-gray-600">
                        <th>Name</th>
                        <th>Attendance (%)</th>
                        <th>Performance Score</th>
                        <th>Allowance (₱)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td>John Doe</td>
                        <td>98%</td>
                        <td>Excellent</td>
                        <td class="font-bold text-green-700">₱5,000</td>
                    </tr>
                    <tr class="">
                        <td>Jane Smith</td>
                        <td>95%</td>
                        <td>Very Good</td>
                        <td class="font-bold text-green-700">₱4,500</td>
                    </tr>
                    <tr class="">
                        <td>Mark Wilson</td>
                        <td>90%</td>
                        <td>Good</td>
                        <td class="font-bold text-green-700">₱3,800</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>