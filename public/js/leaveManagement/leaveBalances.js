export function handleLeaveBalances() {
  $(document).ready(function () {
    $.ajax({
      url: "api/leaveManagement/fetch_leave_credits.php",
      method: "get",
      dataType: "json",
      success: function (data) {
        const tbody = $("#creditsTable");
        tbody.empty(); // clear old rows
        $.each(data, function (index, emp) {
          const fullName = `${emp.emp_fname} ${emp.emp_mname} ${emp.emp_lname}`;
          const position = emp.emp_position || "";
          const department = emp.emp_department || "";
          const total = emp.emp_total_leave;
          const used = emp.emp_used_leave;
          const remaining = emp.remaining;
          const profilePic =
            emp.emp_profPic ||
            "https://img.daisyui.com/images/profile/demo/2@94.webp";

          const row = `
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle h-12 w-12">
                                        <img src="${profilePic}" alt="Profile" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">${fullName}</div>
                                    <div class="text-sm opacity-50">${position}</div>
                                </div>
                            </div>
                        </td>
                        <td>${department}</td>
                        <td><span class="badge badge-outline badge-neutral badge-sm">${total} Days</span></td>
                        <td><span class="badge badge-outline badge-neutral badge-sm">${used} Days</span></td>
                        <td><span class="badge badge-outline badge-neutral badge-sm">${remaining} Days</span></td>
                        <td><span class="badge badge-outline badge-primary badge-sm"> Active</span></td>
                    </tr>
                `;
          tbody.append(row);
        });
      },
      error: function (err) {
        console.error("Error Fetching Leave Credits:", err);
        $("table tbody").html(
          '<tr><td colspan="6" class="text-red-500">Failed to load data</td></tr>'
        );
      },
    });
  });
  //   load dialogs
  $(document).on("click", "#leaveRequestBtn", function () {
    $.get("views/forms/leaveManagementForms/leaveRequest.php", function (data) {
      $("#loadAddLeaveReq").html(data);
      leaveReq.showModal();
    });
  });
  $(document).on("submit", "#saveRequestForm", function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "api/leaveManagement/save_leave_request.php",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: response,
          timer: 2000,
          showConfirmButton: false,
        });
        // optionally reset form
        $("#saveRequestForm")[0].reset();
        leaveReq.close();
      },
      error: function (xhr, status, error) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong: " + error,
        });
      },
    });
  });
}
