export function handleSearchInput() {
    $(document).ready(function () {
        $("input[type='text']").on("input", function () {
            let query = $(this).val();
            if (query.length >= 2) {
                $.ajax({
                    url: "api/timeKeeping/fetch_employeeName.php",
                    type: "GET",
                    data: { query },
                    success: function (response) {
                        let names = JSON.parse(response);
                        let suggestions = names
                            .map(
                                (name) =>
                                    `<li class="p-1 cursor-pointer">${name}</li>`
                            )
                            .join("");

                        $(".autocomplete-list").html(suggestions).show();
                    },
                });
            } else {
                $(".autocomplete-list").hide();
            }
        });

        // Set input when clicking on a suggestion
        $(document).on("click", ".autocomplete-list li", function () {
            $("input[type='text']").val($(this).text());
            $(".autocomplete-list").hide();
        });

        // for attendance search function
        $("#searchEmployee").on("keyup", function () {
            const value = $(this).val().toLowerCase();

            let matchCount = 0;

            $("#timeTable  tr").each(function () {
                const rowText = $(this).text().toLowerCase();
                const isMatch = rowText.indexOf(value) > -1;
                $(this).toggle(isMatch);

                if (isMatch) {
                    matchCount++;
                }
            });

            // Remove existing "no data" row if it exists
            $("#timeTable  .no-data-row").remove();

            if (matchCount === 0) {
                $("#timeTable ").append(`
                    <tr class="no-data-row">
                        <td colspan="7" class="text-center">No records found</td>
                    </tr>
                `);
            }
        });

        //data tables
        $("#timeTable").DataTable({
            pageLength: 5,
            lengthChange: false, // hides "Show N entries"
            ordering: true,
            searching: false, // disables the search bar
            language: {
                emptyTable: "No DTR records found.",
                paginate: {
                    previous: "<",
                    next: ">",
                },
            },
        });
    });
}
