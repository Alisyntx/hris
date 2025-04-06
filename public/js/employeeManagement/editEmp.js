export function handleEditEmployee() {
    $(document).on("click", ".empEditBtn", function () {
        var url = "views/forms/employeeForms/editEmpForm.php";
        var empId = $(this).attr("id");
        $.post(url, { getId: empId }, function (response) {
            $("#loadEditEmp").html(response);
            editEmp.showModal();

            bindEditEmpForm();
        });
    });
}
function bindEditEmpForm() {
    $(document)
        .off("submit", "#editEmpFormBtn")
        .on("submit", "#editEmpFormBtn", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "api/employeeManagement/update_employee.php",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.status === "success") {
                        // Close modal
                        editEmp.close();
                        // Find the updated row
                        let updatedRow = $(
                            `#employeeRow_${formData.get("emp_id")}`
                        );
                        // Update the table row data dynamically
                        updatedRow.html(`
                            <td>${formData.get("emp_id")}</td>
                            <td>${formData.get("fname")} ${formData.get(
                            "mname"
                        )} ${formData.get("lname")} ${formData.get(
                            "suffix"
                        )}</td>
                            <td>${formData.get("position")}</td>
                            <td>${formData.get("department")}</td>
                            <td>${formData.get("promotion")}</td>
                            <td>${formData.get("hireDate")}</td>
                            <td>
                                <button class="empDetailsBtn btn btn-xs btn-circle" id="${formData.get(
                                    "emp_id"
                                )}">
                                    <i class='bx bx-info-circle text-[15px]'></i>
                                </button>
                                <button class="empTrackBtn btn btn-xs btn-circle" id="${formData.get(
                                    "emp_id"
                                )}">
                                    <i class='bx bx-line-chart-down text-[15px]'></i>
                                </button>
                                <button class="empEditBtn btn btn-xs btn-circle" id="${formData.get(
                                    "emp_id"
                                )}">
                                    <i class='bx bx-edit-alt text-[15px]'></i>
                                </button>
                                <button class="empDeleteBtn btn btn-xs btn-circle" id="${formData.get(
                                    "emp_id"
                                )}">
                                    <i class='bx bx-trash text-[15px]'></i>
                                </button>
                            </td>
                        `);

                        $("#toastAlertMessage")
                            .html(
                                `<div class="alert alert-success"><span>${response.message}</span></div>`
                            )
                            .fadeIn()
                            .delay(3000)
                            .fadeOut();
                    } else {
                        // Close modal
                        editEmp.close();
                        // Show an error message
                        $("#toastAlertMessage")
                            .html(
                                `<div class="alert alert-danger"><span>${response.message}</span></div>`
                            )
                            .fadeIn()
                            .delay(3000)
                            .fadeOut();
                    }
                },
                error: function () {
                    alert("Error updating employee.");
                },
            });
        });
}
