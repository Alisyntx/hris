export function handleDepartmentSelect() {
    $(document).ready(function () {
        $.ajax({
            url: "api/timeKeeping/fetch_department.php",
            method: "GET",
            dataType: "json",
            success: function (departments) {
                let departmentSelect = $("#departmentSelect");
                departmentSelect.html(`
                    <option value="" selected>All Departments</option>
                `); // ← This is the "none" or "clear selection" option

                $.each(departments, function (index, dept) {
                    departmentSelect.append(
                        `<option value="${dept}">${dept}</option>`
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error("Error fetching departments:", error);
            },
        });
    });
}
