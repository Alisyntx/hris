$(document).ready(function () {
    $("#searchEmployee").click(function () {
        $.get("views/forms/employeeForms/searchEmpForm.php", function (data) {
            $("#loadSearchEmp").html(data);
            searchEmp.showModal();
        });
    });
});
