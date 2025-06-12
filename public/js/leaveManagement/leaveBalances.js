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
                        <td><span class="badge badge-outline badge-neutral badge-sm font-semibold">${total} Days</span></td>
                        <td><span class="badge badge-outline badge-neutral badge-sm font-semibold">${used} Days</span></td>
                        <td><span class="badge badge-outline badge-neutral badge-sm font-semibold">${remaining} Days</span></td>
                        <td><span class="badge badge-outline badge-primary badge-sm font-semibold"> Active</span></td>
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
  // buttons handling
  $(".btn-approve").on("click", function () {
    handleAction($(this).data("id"), "approved");
  });

  $(".btn-decline").on("click", function () {
    handleAction($(this).data("id"), "rejected");
  });
  // functions for buttons in leave request
  function handleAction(id, status) {
    console.log("Sending request...", id, status);

    Swal.fire({
      title: `Are you sure?`,
      text: `Do you want to mark this as ${status}?`,
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes, update it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "api/leaveManagement/update_leave_status.php", // make sure this path is correct
          type: "POST",
          data: { id: id, status: status },
          success: function (response) {
            console.log("AJAX response:", response);

            try {
              const res =
                typeof response === "string" ? JSON.parse(response) : response;
              if (res.success) {
                Swal.fire("Success!", res.message, "success").then(() =>
                  location.reload()
                );
              } else {
                Swal.fire("Error", res.message, "error");
              }
            } catch (e) {
              console.error("JSON parse error", e);
              Swal.fire("Error", "Invalid server response.", "error");
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX error:", xhr.responseText);
            Swal.fire("Error", "AJAX request failed.", "error");
          },
        });
      }
    });
  }
}
