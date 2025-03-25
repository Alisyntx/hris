<dialog id="addEmp" class="modal">
    <div class="modal-box font-popins">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="addEmp.close()">✕</button>
        <h3 class="text-lg font-semibold text-center">Add Employee</h3>
        <form id="addEmpFormBtn" method="post">
            <div class="w-full flex flex-row gap-2">
                <input type="text" placeholder="firstname" name="fname" class="input input-sm w-full mt-2" />
                <input type="text" placeholder="middlename" name="mname" class="input input-sm w-full mt-2" />
                <input type="text" placeholder="lastname" name="lname" class="input input-sm w-full mt-2" />
                <input type="text" placeholder="suffix" name="suffix" class="input input-sm w-full mt-2" />
            </div>

            <div class="w-full flex flex-row gap-2">
                <input type="text" placeholder="gender" name="gender" class="input input-sm w-full mt-2" />
                <input type="text" placeholder="age" name="age" class="input input-sm w-full mt-2" />
            </div>
            <input type="text" placeholder="address" name="address" class="input input-sm w-full mt-2" />
            <input type="text" placeholder="Position" name="position" class="input input-sm w-full mt-2" />
            <input type="text" placeholder="Department" name="department" class="input input-sm w-full mt-2" />

            <label for="hire date" class="mt-2 text-xs">Hire Date</label>
            <input type="date" placeholder="hire date" name="hireDate" class="input input-sm w-full" />

            <button class="btn mt-2 btn-sm float-right btn-primary "> Add<i class='bx bx-user-plus text-lg'></i> </button>
        </form>
    </div>
</dialog>
<script type="module" src="public/js/main.js"></script>