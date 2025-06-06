export function handleAddOvertimeRequest() {
  let viewingHistory = false;
  $("#otExportBtn").addClass("hidden");
  $(document).ready(function () {
    $(document).on("click", "#addOtRequest", function () {
      $.get("views/forms/timeKeeping/addOtRequestForm.php", function (data) {
        $("#loadAddReq").html(data);
        addOtReq.showModal();
        bindAddOtRequest();
      });
    });
    $(document).on("click", "#viewOtHistory", function () {
      if (!viewingHistory) {
        // Load overtime history data
        fetchOvertimeHistory();
        // Update button to toggle back
        $(this).html(
          `Back to Requests <i class='bx bx-arrow-back text-lg'></i>`
        );
        $("#otExportBtn").removeClass("hidden");
      } else {
        // Load active requests again
        fetchOtRequests();
        // Revert button text
        $(this).html(`Overtime History <i class='bx bx-history text-lg'></i>`);
        $("#otExportBtn").addClass("hidden");
      }
      viewingHistory = !viewingHistory;
    });

    fetchOtRequests();
    // setInterval(() => {
    //     if (!viewingHistory) {
    //         fetchOtRequests();
    //     }
    // }, 5000);
  });

  $(document).on("click", ".approveOtBtn, .rejectOtBtn", function () {
    const otId = $(this).data("id");
    const action = $(this).hasClass("approveOtBtn") ? "approved" : "rejected";
    const confirmText = action === "approved" ? "approve" : "reject";

    Swal.fire({
      title: `Are you sure?`,
      text: `You are about to ${confirmText} this overtime request.`,
      icon: "question",
      showCancelButton: true,
      confirmButtonText: `Yes, ${confirmText} it`,
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "api/timeKeeping/update_ot_status.php",
          method: "POST",
          data: {
            ot_id: otId,
            status: action,
          },
          dataType: "json",
          success: function (response) {
            Swal.fire({
              icon: response.status,
              title: response.status === "success" ? "Success!" : "Error",
              text: response.message,
              timer: 2000,
              showConfirmButton: false,
            });
            fetchOtRequests(); // refresh table
          },
          error: function (xhr, status, error) {
            Swal.fire({
              icon: "error",
              title: "Server Error",
              text: "An error occurred: " + error,
            });
          },
        });
      }
    });
  });
  // btn for data exportation in overtime history
  $("#otExportBtn").on("click", function () {
    if (otDataCache.length > 0) {
      exportOtHistoryToExcel(otDataCache);
    } else {
      alert("No data to export.");
    }
  });
  $(document).on("click", ".removeOtBtn", function () {
    const otId = $(this).data("id");

    Swal.fire({
      title: "Are you sure?",
      text: "This will permanently delete the OT record.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "api/timeKeeping/remove_ot.php",
          method: "POST",
          data: { ot_id: otId },
          dataType: "json",
          success: function (response) {
            if (response.status === "success") {
              Swal.fire(
                "Deleted!",
                "The OT record has been removed.",
                "success"
              );
              fetchOvertimeHistory(); // Refresh the table
            } else {
              Swal.fire(
                "Error!",
                response.message || "Something went wrong.",
                "error"
              );
            }
          },
          error: function () {
            Swal.fire("Error!", "Server error occurred.", "error");
          },
        });
      }
    });
  });
}

function bindAddOtRequest() {
  $(document)
    .off("submit", "#addOtFormBtn")
    .on("submit", "#addOtFormBtn", function (e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "api/timeKeeping/save_ot_request.php",
        data: $(this).serialize(),
        dataType: "json",
        success: function (response) {
          if (response.status === "success") {
            Swal.fire({
              icon: "success",
              title: "Success!",
              text: response.message,
              timer: 2000,
              showConfirmButton: false,
            }).then(() => {
              location.reload();
              $("#addOtFormBtn")[0].reset();
            });
            addOtReq.close();
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: response.message,
            });
          }
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: "error",
            title: "Server Error",
            text: "An error occurred: " + error,
          });
        },
      });
    });
}
function fetchOtRequests() {
  $.ajax({
    url: "api/timeKeeping/fetch_ot_request.php",
    method: "GET",
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        let rows = "";

        response.data.forEach(function (req) {
          const startTimeFormatted = formatTimeTo12Hour(req.ot_start_time);
          const endTimeFormatted = formatTimeTo12Hour(req.ot_end_time);

          rows += `
                        <tr>
                            <td>${req.ot_id}</td>
                            <td>${req.ot_emp_name}</td>
                            <td>${startTimeFormatted} - ${endTimeFormatted}</td>
                            <td>${req.ot_reason}</td>
                            <td>${req.ot_date}</td>
                            <td><span class="badge badge-sm ${
                              req.ot_status === "approved"
                                ? "badge-success badge-sm"
                                : req.ot_status === "rejected"
                                ? "badge-error badge-sm text-primaryclr"
                                : "badge-warning"
                            }">
                                    ${req.ot_status}
                                </span>
                            </td>
                           <td>
                                <button class="btn btn-xs btn-primary text-white approveOtBtn" data-id="${
                                  req.ot_id
                                }">Accept</button>
                                <button class="btn btn-xs btn-error text-white rejectOtBtn" data-id="${
                                  req.ot_id
                                }">Reject</button>
                            </td>

                            
                        </tr>
                    `;
        });

        $("#otRequestTableBody").html(rows);
      } else {
        $("#otRequestTableBody").html(
          '<tr><td colspan="7" class="text-center text-gray-500">No overtime requests found.</td></tr>'
        );
      }
    },
    error: function (xhr, status, error) {
      console.error("Fetch error:", error);
    },
  });
}

function formatTimeTo12Hour(timeString) {
  const [hours, minutes] = timeString.split(":");
  const date = new Date();
  date.setHours(+hours);
  date.setMinutes(+minutes);

  const options = { hour: "numeric", minute: "2-digit", hour12: true };
  return date.toLocaleTimeString("en-US", options);
}

let otDataCache = [];
function fetchOvertimeHistory() {
  $.ajax({
    url: "api/timeKeeping/fetch_ot_history.php", // create this file if needed
    method: "GET",
    dataType: "json",
    success: function (response) {
      otDataCache = response.data; // Save data for export
      if (response.status === "success") {
        let rows = "";

        response.data.forEach(function (req) {
          const startTimeFormatted = formatTimeTo12Hour(req.ot_start_time);
          const endTimeFormatted = formatTimeTo12Hour(req.ot_end_time);

          rows += `
                        <tr>
                            <td>${req.ot_id}</td>
                            <td>${req.ot_emp_name}</td>
                            <td>${startTimeFormatted} - ${endTimeFormatted}</td>
                            <td>${req.ot_reason}</td>
                            <td>${req.ot_date}</td>
                            <td>
                                <span class="badge badge-sm ${
                                  req.ot_status === "approved"
                                    ? "badge-success"
                                    : req.ot_status === "rejected"
                                    ? "badge-error"
                                    : "badge-warning"
                                }">${req.ot_status}</span>
                            </td>
                            <td><button class="btn btn-xs btn-error text-white removeOtBtn" data-id="${
                              req.ot_id
                            }">Remove</button></td>
                        </tr>
                    `;
        });

        $("#otRequestTableBody").html(rows);
      } else {
        $("#otRequestTableBody").html(
          `<tr><td colspan="7" class="text-center text-gray-500">No overtime history found.</td></tr>`
        );
      }
    },
    error: function (xhr, status, error) {
      console.error("Error fetching OT history:", error);
    },
  });
}
// ot history exportation in excell
function exportOtHistoryToExcel(data) {
  const exportData = data.map((req) => ({
    ID: req.ot_id,
    "Employee Name": req.ot_emp_name,
    Time: `${formatTimeTo12Hour(req.ot_start_time)} - ${formatTimeTo12Hour(
      req.ot_end_time
    )}`,
    Reason: req.ot_reason,
    Date: req.ot_date,
    Status: req.ot_status,
  }));

  const worksheet = XLSX.utils.json_to_sheet(exportData);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "OvertimeHistory");

  // Get today's date (e.g., 2025-05-20)
  const today = new Date();
  const formattedDate = today.toISOString().split("T")[0]; // YYYY-MM-DD

  // File name with date
  const filename = `Overtime_History_${formattedDate}.xlsx`;

  XLSX.writeFile(workbook, filename);
}
