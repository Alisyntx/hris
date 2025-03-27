export function handleAddEmployee() {
    $(document).on("click", "#addEmployee", function () {
        $.get("views/forms/employeeForms/addEmpForm.php", function (data) {
            $("#loadAddEmp").html(data);
            addEmp.showModal();

            // Re-bind image preview event AFTER loading the form
            document
                .getElementById("imagePreview")
                .addEventListener("click", function () {
                    document.getElementById("profileImage").click();
                });

            document
                .getElementById("profileImage")
                .addEventListener("change", function (event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            document.getElementById("previewImg").src =
                                e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });

            // Bind form submission event
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

                        // Add new row dynamically
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
                                <button class="empDeleteBtn btn btn-xs btn-circle" id="${response.emp_id}">
                                    <i class='bx bx-trash text-[15px]'></i>
                                </button>
                            </td>
                        </tr>`;

                        $("#noResultsRow").remove();
                        $("#employeeTabled").prepend(newRow);
                        $("#employeeTabled tr:first").fadeIn("slow");

                        // Reset form after submission
                        $("#addEmpFormBtn")[0].reset();

                        // Show success toast
                        showToast("Employee added successfully!", "success");
                    } else {
                        showToast(response.message, "error");
                        alert(response.message);
                    }
                },
                error: function () {
                    alert("Failed to connect to the server.");
                },
            });
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
