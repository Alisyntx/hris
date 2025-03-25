export function handleDetailsEmployee() {
    $(document).on("click", ".empDetailsBtn", function () {
        var url = "views/forms/employeeForms/detailsEmpForm.php";
        var empId = $(this).attr("id");
        $.post(url, { getId: empId }, function (response) {
            $("#loadDetailsEmp").html(response);
            detailsEmp.showModal();
        });
    });
}
