export function handleDepartments() {
    $(document).ready(function () {
        // add department modal
        $(document).on("click", "#addDepartment", function () {
            $.get(
                "views/forms/timeKeeping/addDepartmentForm.php",
                function (data) {
                    $("#loadAddDept").html(data);
                    addDept.showModal();
                }
            );
        });

        $(document).on("click", ".editDeptBtn", function () {
            var url = "views/forms/timeKeeping/editDepartmentForm.php";
            var deptId = $(this).attr("id");
            $.post(url, { getId: deptId }, function (response) {
                $("#loadEditDept").html(response);
                editDept.showModal();
                bindEditDepartment();
            });
        });

        $(document).on("click", ".deleteDeptBtn", function () {
            const deptId = $(this).attr("id");

            Swal.fire({
                title: "Are you sure?",
                text: "This department will be permanently deleted.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ef4444", // red-500
                cancelButtonColor: "#6b7280", // gray-500
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "api/timeKeeping/delete_department.php",
                        type: "POST",
                        data: { dept_id: deptId },
                        success: function (response) {
                            if (response.status === "success") {
                                Swal.fire(
                                    "Deleted!",
                                    response.message,
                                    "success"
                                ).then(() => {
                                    fetchDepartments(); // refresh list
                                });
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function () {
                            Swal.fire(
                                "Error!",
                                "Something went wrong.",
                                "error"
                            );
                        },
                    });
                }
            });
        });

        bindAddDepartmentForm();
        fetchDepartments();
    });
}

function bindAddDepartmentForm() {
    $(document)
        .off("submit", "#addDeptFormBtn")
        .on("submit", "#addDeptFormBtn", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "api/timeKeeping/add_department.php",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Department Added!",
                            text: response.message,
                            confirmButtonColor: "#10b981", // Tailwind green-500
                        }).then(() => {
                            location.reload();
                        });
                        addDept.close();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Add Failed",
                            text: response.message || "An error occurred.",
                            confirmButtonColor: "#ef4444", // Tailwind red-500
                        });
                        addDept.close();
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    Swal.fire({
                        icon: "error",
                        title: "Server Error",
                        text: "Something went wrong while adding.",
                        confirmButtonColor: "#ef4444",
                    });
                },
            });
        });
}

function fetchDepartments() {
    $.ajax({
        url: "api/timeKeeping/get_department.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                let rows = "";
                response.data.forEach((dept) => {
                    // Format break duration (e.g., 1.5 → "1 hr 30 mins")
                    const breakHours = Math.floor(dept.dept_break_time);
                    const breakMinutes = Math.round(
                        (dept.dept_break_time - breakHours) * 60
                    );
                    const breakTimeFormatted = `${
                        breakHours > 0 ? breakHours + " hr" : ""
                    }${
                        breakMinutes > 0 ? " " + breakMinutes + " mins" : ""
                    }`.trim();

                    rows += `
                        <tr class="hover:bg-base-300">
                            <td class="font-medium">${dept.dept_name}</td>
                            <td>
                                <div class="text-xs leading-tight">
                                    <div><b>AM In:</b> ${dept.dept_amtime_in}</div>
                                    <div><b>AM Out:</b> ${dept.dept_amtime_out}</div>
                                </div>
                            </td>
                            <td>
                                <div class="text-xs leading-tight">
                                    <div><b>PM In:</b> ${dept.dept_pmtime_in}</div>
                                    <div><b>PM Out:</b> ${dept.dept_pmtime_out}</div>
                                </div>
                            </td>
                            <td class="text-xs">${breakTimeFormatted}</td>
                            <td>
                                <button class="text-mainclr btn btn-ghost btn-sm btn-circle editDeptBtn" id="${dept.dept_id}">
                                    <i class='bx bxs-edit-alt text-lg'></i>
                                </button>
                                <button class="text-mainclr btn btn-ghost btn-sm btn-circle deleteDeptBtn" id="${dept.dept_id}">
                                    <i class='bx bx-trash text-lg'></i>
                                </button>
                            </td>
                        </tr>`;
                });
                $("#departmentTableBody").html(rows);
            } else {
                console.error("Fetch failed:", response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        },
    });
}

// helper to convert 24h time to 12h format
function formatTime(time) {
    const [hour, minute] = time.split(":");
    const h = parseInt(hour);
    const ampm = h >= 12 ? "PM" : "AM";
    const adjustedHour = h % 12 || 12;
    return `${adjustedHour}:${minute} ${ampm}`;
}

function bindEditDepartment() {
    $(document)
        .off("submit", "#editDeptFormBtn")
        .on("submit", "#editDeptFormBtn", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "api/timeKeeping/edit_department.php", // your PHP edit handler
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Department Updated!",
                            text: response.message,
                            confirmButtonColor: "#10b981",
                        }).then(() => {
                            location.reload();
                        });
                        editDept.close();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Update Failed",
                            text: response.message || "An error occurred.",
                            confirmButtonColor: "#ef4444",
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    Swal.fire({
                        icon: "error",
                        title: "Server Error",
                        text: "Something went wrong while updating.",
                        confirmButtonColor: "#ef4444",
                    });
                },
            });
        });
}
