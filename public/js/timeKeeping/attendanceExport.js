export function handleAttendanceExport() {
    // ✅ Make sure XLSX is already imported before this (you said it is)
    $(document).ready(function () {
        $("#exportExcelBtn").on("click", function () {
            // Show SweetAlert2 confirmation
            Swal.fire({
                title: "Export to Excel?",
                text: "Do you want to download the attendance report?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, export it!",
                cancelButtonText: "No",

                padding: "1em",
                customClass: {
                    container: "5rem",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Select table element
                    const table = document.querySelector("table");

                    // If no table data exists
                    if (!table) {
                        Swal.fire("Error", "No table data found!", "error");
                        return;
                    }

                    // Convert table to Excel (XLSX)
                    const workbook = XLSX.utils.table_to_book(table, {
                        sheet: "Attendance",
                    });

                    // Create filename with current date
                    const today = new Date().toISOString().split("T")[0];
                    const filename = `Attendance_Report_${today}.xlsx`;

                    // Trigger file download (this will show the Save As dialog)
                    XLSX.writeFile(workbook, filename);

                    // Show success confirmation
                    Swal.fire(
                        "Success",
                        "Attendance report exported!",
                        "success"
                    );
                }
            });
        });
    });
}
