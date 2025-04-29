export function handleDownloadDtr() {
    $(document).ready(function () {
        $("#downloadDTR").click(function () {
            $.ajax({
                url: "api/timeKeeping/get_employee.php",
                method: "GET",
                dataType: "json",
                success: function (employees) {
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
                            Date: today,
                            "Am In": null,
                            "Am Out": null,
                            "Pm In": null,
                            "Pm Out": null,
                            Remarks: "",
                        };
                    });

                    const worksheet = XLSX.utils.json_to_sheet(dtrTemplate);

                    // Format Date column ("C")
                    for (let row = 2; row <= employees.length + 1; row++) {
                        const cellRef = "C" + row;
                        if (worksheet[cellRef]) {
                            worksheet[cellRef].z = "mm/dd/yyyy";
                        }
                    }

                    // Pre-format time columns: D (Am In), E (Am Out), F (Pm In), G (Pm Out)
                    const timeCols = ["D", "E", "F", "G"];
                    timeCols.forEach((col) => {
                        for (let row = 2; row <= employees.length + 1; row++) {
                            const cellRef = col + row;
                            if (!worksheet[cellRef])
                                worksheet[cellRef] = { t: "n", v: null };
                            worksheet[cellRef].z = "h:mm AM/PM";
                        }
                    });

                    const workbook = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(
                        workbook,
                        worksheet,
                        "DTR Template"
                    );

                    const fileDate = `${
                        today.getMonth() + 1
                    }-${today.getDate()}-${today.getFullYear()}`;
                    XLSX.writeFile(workbook, `dtr_template_${fileDate}.xlsx`);

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
