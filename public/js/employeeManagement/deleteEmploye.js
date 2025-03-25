$(document).ready(function () {
    $(".empDeleteBtn").click(function () {
        var url = "views/forms/employeeForms/deleteEmpForm.php";
        var empId = $(this).attr("id");
        $.post(url, { getId: empId }, function (response) {
            $("#loadDeleteEmp").html(response);
            deleteEmp.showModal();
        });
    });
    // Prevent multiple event bindings for form submission
    $(document)
        .off("submit", "#deleteEmpAction")
        .on("submit", "#deleteEmpAction", function (e) {
            e.preventDefault();

            let empId = $(this).find('input[name="emp_id"]').val(); // Get emp_id from form input

            $.ajax({
                url: "api/employeeManagement/delete_employee.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        deleteEmp.close(); // Assuming this closes the modal
                        $("#employeeRow_" + empId).slideUp(500, function () {
                            $(this).remove();
                        });
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert("Error deleting employee.");
                },
            });
        });
});
