<div class="w-full h-screen font-popins">
    <div class="w-full h-10 mt-1 ">
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

        <button class="btn btn-sm">
            <i class='bx bx-filter-alt text-lg'></i>
            Filter
        </button>
    </div>
    <div class="w-full grid grid-cols-2 gap-2  h-auto pb-15">

        <?php include 'api/timeKeeping/fetch_allowance_emp.php' ?>


    </div>
</div>