$(document).ready(function () {
    $(".empTrackBtn").click(function () {
        var url = "views/forms/employeeForms/trackEmpForm.php";
        var empId = $(this).attr("id");
        $.post(url, { getId: empId }, function (response) {
            $("#loadDetailsEmp").html(response);
            detailsEmp.showModal();
        });
    });
});
