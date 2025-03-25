export function handleEditEmployee() {
    $(document).on("click", ".empEditBtn", function () {
        var url = "views/forms/employeeForms/editEmpForm.php";
        var empId = $(this).attr("id");
        $.post(url, { getId: empId }, function (response) {
            $("#loadEditEmp").html(response);
            editEmp.showModal();
        });
    });
}
