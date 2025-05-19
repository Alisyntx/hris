<div class=" w-full h-screen font-popins">
    <div class="w-full h-[5%] text-mainclr">
        <button class="btn btn-sm bg-accentclr text-primaryclr hover:bg-primaryclr hover:text-mainclr border-none " id="addOtRequest"> Request Overtime <i class='bx bx-message-square-add text-lg'></i></button>
        <button class="btn btn-sm bg-accentclr text-primaryclr hover:bg-primaryclr hover:text-mainclr border-none " id="viewOtHistory"> Overtime History <i class='bx bx-history text-lg'></i></button>
        <button class="btn btn-sm bg-accentclr text-primaryclr hover:bg-primaryclr hover:text-mainclr border-none " id="otExportBtn"> Export <i class='bx bx-printer text-lg'></i></button>
    </div>
    <div class="overflow-x-auto rounded-md shadow-md border-base-content/10 mt-2 border-[1px]">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Time</th>
                    <th>Reason</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="otRequestTableBody">

            </tbody>
        </table>
    </div>
</div>