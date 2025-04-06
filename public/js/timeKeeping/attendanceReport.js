export function handleAttendanceReport() {
    let startDate = document.getElementById("cally1").innerText.trim();
    let endDate = document.getElementById("cally2").innerText.trim();
    let department = document.querySelector(".select").value;
    let searchTerm = document.querySelector("input[type='text']").value.trim();

    // Ensure department is valid (not the default option)
    if (department.includes("Filter by")) {
        department = ""; // Ignore if not selected
    }
    $.ajax({
        url: "api/timeKeeping/fetch_attendance_report.php",
        type: "POST",
        data: { startDate, endDate, department, searchTerm },
        success: function (response) {
            $("#attendance-data").html(response);
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

// ✅ Ensure correct function is called in the event listener
