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
                        Swal.fire({
                            icon: "success",
                            title: "DTR Updated!",
                            text: response.message,
                            confirmButtonColor: "#10b981", // Tailwind green-500
                        }).then(() => {
                            location.reload();
                        });
                        dtrEmpEdit.close();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Update Failed",
                            text: response.message || "An error occurred.",
                            confirmButtonColor: "#ef4444", // Tailwind red-500
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    Swal.fire({
                        icon: "error",
                        title: "Server Error",
                        text: "Something went wrong while updating.",
                        confirmButtonColor: "#ef4444",
                    });
                },
            });
        });
}
