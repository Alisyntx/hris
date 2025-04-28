export function handleAttendanceExport() {
    $("#exportExcelBtn").on("click", function () {
        const table = $("#tableDTR").DataTable();

        if (!table || table.rows().count() === 0) {
            Swal.fire("Error", "No data to export!", "error");
            return;
        }

        // ✅ Get data BEFORE the Swal modal opens
        const headers = [];
        $("#tableDTR thead tr th").each(function () {
            headers.push($(this).text().trim());
        });

        const data = [];
        table.rows({ search: "applied" }).every(function () {
            const rowNodes = $(this.node()).find("td");
            const rowData = [];
            rowNodes.each(function () {
                rowData.push($(this).text().trim());
            });
            data.push(rowData);
        });

        // 📦 Create and export Excel file
        const worksheet = XLSX.utils.aoa_to_sheet([headers, ...data]);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Attendance");

        const today = new Date().toISOString().split("T")[0];
        const filename = `Attendance_Report_${today}.xlsx`;

        // ✅ Trigger export FIRST, then show success
        XLSX.writeFile(workbook, filename);

        setTimeout(() => {
            Swal.fire("Success", "Attendance report exported!", "success");
        }, 200); // small delay to avoid DOM conflict
    });
}
