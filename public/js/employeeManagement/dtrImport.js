export function handleDtrImport() {
    $(document).ready(function () {
        fetchAttendanceSummary();
        $("#saveFile").on("click", function () {
            $("#fileInput").click();
        });

        $("#fileInput").on("change", function (e) {
            let file = e.target.files[0];

            if (file) {
                let reader = new FileReader();
                reader.readAsBinaryString(file);

                reader.onload = function (e) {
                    let data = e.target.result;
                    let workbook = XLSX.read(data, { type: "binary" });

                    let sheetName = workbook.SheetNames[0];
                    let sheetData = XLSX.utils.sheet_to_json(
                        workbook.Sheets[sheetName],
                        { header: 1 }
                    );

                    if (sheetData.length > 0) {
                        let formattedData = formatSheetData(sheetData);
                        sendDataToServer(formattedData);
                    } else {
                        alert("No data found in the file!");
                    }
                };

                reader.onerror = function () {
                    alert("Failed to read the file. Please try again.");
                };
            }
        });

        // Convert Excel numbers back to date/time
        function excelDateToJSDate(serial) {
            if (!serial || isNaN(serial)) return null; // Handle invalid dates

            let excelStartDate = new Date(1899, 11, 30); // Excel base date
            let jsDate = new Date(
                excelStartDate.getTime() + (serial + 1) * 86400000
            ); // ✅ Subtract 1 day

            return jsDate.toISOString().split("T")[0]; // Returns YYYY-MM-DD format
        }

        function excelTimeToJSTime(serial) {
            let totalSeconds = Math.round(serial * 86400); // Convert fraction of a day to seconds
            let hours = Math.floor(totalSeconds / 3600);
            let minutes = Math.floor((totalSeconds % 3600) / 60);
            let ampm = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12; // Convert to 12-hour format
            return `${hours}:${minutes.toString().padStart(2, "0")} ${ampm}`;
        }

        // Format sheet data (Convert date/time correctly)
        function formatSheetData(sheetData) {
            return sheetData.map((row, index) => {
                if (index === 0) return row; // Keep headers as is
                console.log("Raw Excel Date:", row[2]);
                return [
                    row[0], // Employee ID
                    row[1], // Employee Name
                    excelDateToJSDate(row[2]), // Convert Date
                    row[3] ? excelTimeToJSTime(row[3]) : null, // Convert Time-in
                    row[4] ? excelTimeToJSTime(row[4]) : null, // Convert Time-out
                    row[5], // Total Hours
                    row[6], // Remarks
                ];
            });
        }
        // Send formatted data to the server
        function sendDataToServer(sheetData) {
            $.ajax({
                url: "api/timeKeeping/dtr_Import.php",
                type: "POST",
                data: { data: JSON.stringify(sheetData) },
                dataType: "json",
                success: function (response) {
                    console.log(sheetData);
                    if (response.success) {
                        fetchAttendanceSummary();
                        Swal.fire("Success", response.message, "success").then(
                            () => {
                                location.reload();
                            }
                        );
                    } else {
                        console.log(sheetData);
                        Swal.fire("Failed", response.message, "error");
                    }
                },
                error: function () {
                    Swal.fire("Request Error", "AJAX request failed!", "error");
                },
            });
        }
    });
}
function showToast(message, type) {
    let toastClass = type === "success" ? "alert-success" : "alert-error";

    let toast = $(`
        <div class="alert ${toastClass} text-white shadow-lg p-3 flex items-center gap-2">
            <span>${message}</span>
        </div>
    `);

    $("#toastAlertMessage").append(toast);

    // Auto-hide after 3 seconds
    setTimeout(() => {
        toast.fadeOut(300, function () {
            $(this).remove();
        });
    }, 3000);
}
function fetchAttendanceSummary() {
    $.ajax({
        url: "api/timeKeeping/attendance_summary.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                // ✅ Update UI with new attendance summary
                $("#totalAbsent").text(response.data.total_absent);
                $("#totalLate").text(response.data.total_late);
                $("#totalPresent").text(response.data.total_present);
            } else {
                showToast("Failed to fetch summary!", "error");
            }
        },
        error: function () {
            showToast("Error fetching summary!", "error");
        },
    });
}
