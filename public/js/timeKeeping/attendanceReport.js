export function handleAttendanceReport() {
    let startDate = document.getElementById("cally1").innerText.trim();
    let endDate = document.getElementById("cally2").innerText.trim();
    let department = document.querySelector(".select").value;
    let searchTerm = document.querySelector("input[type='text']").value.trim();

    if (department.includes("Filter by")) {
        department = ""; // Ignore if not selected
    }

    $.ajax({
        url: "api/timeKeeping/fetch_attendance_report.php",
        type: "POST",
        data: { startDate, endDate, department, searchTerm },
        success: function (response) {
            // ✅ Destroy DataTable if already initialized
            if ($.fn.DataTable.isDataTable("#tableDTR")) {
                $("#tableDTR").DataTable().destroy();
            }

            // ✅ Replace table body or full table
            $("#attendance-data").html(response);

            // ✅ Reinitialize DataTable AFTER DOM update
            $("#tableDTR").DataTable({
                pageLength: 10,
                lengthChange: false,
                ordering: true,
                searching: false,
                language: {
                    emptyTable: "No DTR records found.",
                    paginate: {
                        previous: "<",
                        next: ">",
                    },
                },
            });

            // ✅ Check for no data message
            const hasNoData = $(".no-data-row").length > 0;
            if (hasNoData) {
                Swal.fire({
                    title: "No Records Found",
                    text: "There is no attendance data to display based on your filters.",
                    icon: "info",
                    confirmButtonText: "Okay",
                    width: "350px",
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching attendance data:", error);
        },
    });
}
