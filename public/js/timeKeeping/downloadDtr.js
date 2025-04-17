export function handleDownloadDtr() {
    $(document).ready(function () {
        // Add click event listener to the button
        $("#downloadDTR").click(function () {
            $.ajax({
                url: "api/timeKeeping/get_employee.php",
                method: "GET",
                dataType: "json",
                success: function (employees) {
                    // Fix timezone issue by creating a local date at midnight (no time shift)
                    const now = new Date();
                    const today = new Date(
                        now.getFullYear(),
                        now.getMonth(),
                        now.getDate()
                    );

                    const dtrTemplate = employees.map((emp) => {
                        const fullName = `${emp.emp_fname} ${emp.emp_mname} ${
                            emp.emp_lname
                        }${emp.emp_suffix ? " " + emp.emp_suffix : ""}`;
                        return {
                            "Employee ID": emp.emp_id,
                            "Employee Name": fullName,
                            Date: today, // Use fixed local date object
                            "Time-in": "",
                            "Time-out": "",
                        };
                    });

                    // Create worksheet
                    const worksheet = XLSX.utils.json_to_sheet(dtrTemplate);

                    // Optional: apply Excel date format to first date cell
                    const dateCell = worksheet["C2"]; // "C2" is usually the first date cell
                    if (dateCell) {
                        dateCell.z = XLSX.SSF._table[14]; // Apply Excel date format "m/d/yy"
                    }

                    // Create and append to workbook
                    const workbook = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(
                        workbook,
                        worksheet,
                        "DTR Template"
                    );

                    // Format file name based on local date
                    const fileDate = `${
                        today.getMonth() + 1
                    }-${today.getDate()}-${today.getFullYear()}`;

                    // Trigger Excel download
                    XLSX.writeFile(workbook, `dtr_template_${fileDate}.xlsx`);

                    // Show success alert
                    Swal.fire({
                        title: "Download Complete!",
                        text: `DTR Template for ${fileDate} has been successfully downloaded.`,
                        icon: "success",
                        confirmButtonText: "Okay",
                    });
                },
                error: function (err) {
                    console.error("Failed to fetch employee data:", err);
                    Swal.fire({
                        title: "Error",
                        text: "Failed to fetch employee data. Please try again.",
                        icon: "error",
                        confirmButtonText: "Okay",
                    });
                },
            });
        });
    });
}
