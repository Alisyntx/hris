export function handleAddEmployee() {
    $(document).on("click", "#addEmployee", function () {
        $.get("views/forms/employeeForms/addEmpForm.php", function (data) {
            $("#loadAddEmp").html(data);
            addEmp.showModal();

            // Ensure event bindings are applied after content loads
            bindAddEmpForm();
        });
    });
}

function bindAddEmpForm() {
    $(document)
        .off("submit", "#addEmpFormBtn")
        .on("submit", "#addEmpFormBtn", function (e) {
            e.preventDefault();

            $.ajax({
                url: "api/employeeManagement/add_employee.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.status === "success") {
                        addEmp.close();
                        let newRow = `
                        <tr style="display: none;">
                            <td>${response.emp_id}</td>
                            <td>${response.emp_fname} ${response.emp_mname} ${response.emp_lname} ${response.emp_suffix}</td>
                            <td>${response.emp_position}</td>
                            <td>${response.emp_department}</td>
                            <td>${response.emp_promotion}</td>
                            <td>${response.emp_dateHire}</td>
                            <td>
                                <button class="empDetailsBtn btn btn-xs btn-circle" id="${response.emp_id}">
                                    <i class='bx bx-info-circle text-[15px]'></i>
                                </button>
                                <button class="empTrackBtn btn btn-xs btn-circle" id="${response.emp_id}">
                                    <i class='bx bx-line-chart-down text-[15px]'></i>
                                </button>
                                <button class="empEditBtn btn btn-xs btn-circle" id="${response.emp_id}">
                                    <i class='bx bx-edit-alt text-[15px]'></i>
                                </button>
                            </td>
                        </tr>`;

                        $("#noResultsRow").remove();
                        $("#employeeTabled").prepend(newRow);
                        $("#employeeTabled tr:first").fadeIn("slow");

                        $("#addEmpFormBtn")[0].reset();
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert("Failed to connect to the server.");
                },
            });
        });
}
