$(document).ready(function () {
    $(document).on("click", ".empDeleteBtn", function () {
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
                        deleteEmp.close(); // Close the modal
                        $("#employeeRow_" + empId).slideUp(500, function () {
                            $(this).remove();
                        });
                        // Show success toast
                        showToast("Employee deleted successfully!", "success");
                    } else {
                        showToast(response.message, "error");
                    }
                },
                error: function () {
                    showToast("Error deleting employee.", "error");
                },
            });
        });
});
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
