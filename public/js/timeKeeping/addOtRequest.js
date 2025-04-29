export function handleAddOvertimeRequest() {
    $(document).ready(function () {
        $(document).on("click", "#addOtRequest", function () {
            $.get(
                "views/forms/timeKeeping/addOtRequestForm.php",
                function (data) {
                    $("#loadAddReq").html(data);
                    addOtReq.showModal();
                    bindAddOtRequest();
                }
            );
        });
        fetchOtRequests();
    });
}

function bindAddOtRequest() {
    $(document)
        .off("submit", "#addOtFormBtn")
        .on("submit", "#addOtFormBtn", function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "api/timeKeeping/save_ot_request.php",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                            $("#addOtFormBtn")[0].reset();
                        });
                        addOtReq.close();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response.message,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Server Error",
                        text: "An error occurred: " + error,
                    });
                },
            });
        });
}
function fetchOtRequests() {
    $.ajax({
        url: "api/timeKeeping/fetch_ot_request.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                let rows = "";

                response.data.forEach(function (req) {
                    const startTimeFormatted = formatTimeTo12Hour(
                        req.ot_start_time
                    );
                    const endTimeFormatted = formatTimeTo12Hour(
                        req.ot_end_time
                    );

                    rows += `
                        <tr>
                            <td>${req.ot_id}</td>
                            <td>${req.ot_emp_name}</td>
                            <td>${startTimeFormatted} - ${endTimeFormatted}</td>
                            <td>${req.ot_reason}</td>
                            <td>${req.ot_date}</td>
                            <td>
                                <button class="btn btn-xs btn-primary text-white">Accept</button>
                                <button class="btn btn-xs btn-error text-white">Reject</button>
                            </td>
                            
                        </tr>
                    `;
                });

                $("#otRequestTableBody").html(rows);
            } else {
                $("#otRequestTableBody").html(
                    '<tr><td colspan="7" class="text-center text-gray-500">No overtime requests found.</td></tr>'
                );
            }
        },
        error: function (xhr, status, error) {
            console.error("Fetch error:", error);
        },
    });
}

function formatTimeTo12Hour(timeString) {
    const [hours, minutes] = timeString.split(":");
    const date = new Date();
    date.setHours(+hours);
    date.setMinutes(+minutes);

    const options = { hour: "numeric", minute: "2-digit", hour12: true };
    return date.toLocaleTimeString("en-US", options);
}
