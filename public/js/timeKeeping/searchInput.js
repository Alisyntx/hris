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
    });
}
