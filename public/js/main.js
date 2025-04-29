import "../../node_modules/cally/dist/cally.js";
import * as XLSX from "../../node_modules/xlsx/xlsx.js";

import { handleAddEmployee } from "./employeeManagement/addEmploye.js";
import { handleDetailsEmployee } from "./employeeManagement/detailsEmp.js";
import { handleTrackEmployee } from "./employeeManagement/trackEmp.js";
import { handleEditEmployee } from "./employeeManagement/editEmp.js";
import { handleDtrImport } from "./employeeManagement/dtrImport.js";
import { handleAttendanceReport } from "./timeKeeping/attendanceReport.js";
import { handleDepartmentSelect } from "./timeKeeping/departmentSelect.js";
import { handleSearchInput } from "./timeKeeping/searchInput.js";
import { handleAttendanceExport } from "./timeKeeping/attendanceExport.js";
import { handleDownloadDtr } from "./timeKeeping/downloadDtr.js";
import { handleEditEmployeeDtr } from "./timeKeeping/editEmpDtr.js";
import { handleDepartments } from "./timeKeeping/departmentsScript.js";
import { handleAddOvertimeRequest } from "./timeKeeping/addOtRequest.js";
$(document).ready(function () {
    handleEditEmployee();
    handleAddEmployee();
    handleTrackEmployee();
    handleDetailsEmployee();
    handleDtrImport();
    handleDepartmentSelect();
    handleSearchInput();
    handleAttendanceExport();
    handleDownloadDtr();
    handleEditEmployeeDtr();
    handleDepartments();
    handleAddOvertimeRequest();
    $.getScript("public/js/employeeManagement/deleteEmploye.js");

    $(document).ready(function () {
        $(".btnFilters").on("click", function () {
            handleAttendanceReport(); // 🔥 Called ONLY when button clicked
        });
    });
});
