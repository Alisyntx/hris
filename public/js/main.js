import { handleAddEmployee } from "./employeeManagement/addEmploye.js";
import { handleDetailsEmployee } from "./employeeManagement/detailsEmp.js";
import { handleEditEmployee } from "./employeeManagement/editEmp.js";
$(document).ready(function () {
    handleEditEmployee();
    handleAddEmployee();
    handleDetailsEmployee();

    $.getScript("public/js/employeeManagement/deleteEmploye.js");
    $.getScript("public/js/employeeManagement/trackEmp.js");
    $.getScript("public/js/employeeManagement/deleteEmploye.js");
});
