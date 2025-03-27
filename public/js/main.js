import { handleAddEmployee } from "./employeeManagement/addEmploye.js";
import { handleDetailsEmployee } from "./employeeManagement/detailsEmp.js";
import { handleTrackEmployee } from "./employeeManagement/trackEmp.js";
import { handleEditEmployee } from "./employeeManagement/editEmp.js";
$(document).ready(function () {
    handleEditEmployee();
    handleAddEmployee();
    handleTrackEmployee();
    handleDetailsEmployee();

    $.getScript("public/js/employeeManagement/deleteEmploye.js");
});
