export function handleEditEmployeeDtr() {
    $(document).on("click", ".empDtrEditBtn", function () {
        var url = "views/forms/timeKeeping/editEmpDtrForm.php";
        var dtrEmpId = $(this).attr("id");
        $.post(url, { getId: dtrEmpId }, function (response) {
            $("#loadEditEmpDtr").html(response);
            dtrEmpEdit.showModal();
            bindEditEmployeeDtr();
        });
    });
}
function bindEditEmployeeDtr() {
    $(document)
        .off("submit", "#editEmpDtrForm")
        .on("submit", "#editEmpDtrForm", function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "api/timeKeeping/update_dtr.php",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.status === "success") {
                        // Close modal
                        alert(response.message);
                        dtrEmpEdit.close();
                    } else {
                        console.error("Update failed:", response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", status, error);
                },
            });
        });
}
