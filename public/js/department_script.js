function openAddModal() {
    document.getElementById("addModal").style.display = "flex";
}

function closeAddModal() {
    document.getElementById("addModal").style.display = "none";
}

function openEditModal(id, code, name, status) {
    document.getElementById("editId").value = id;
    document.getElementById("editCode").value = code;
    document.getElementById("editName").value = name;
    document.getElementById("editStatus").value = status;

    document.getElementById("editForm").action = "/departments/update/" + id;
    document.getElementById("editModal").style.display = "flex";
}

function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
}

function confirmDelete(id, departmentName) {
    if (confirm(`Are you sure you want to delete "${departmentName}"?`)) {
        document.getElementById(`deleteForm-${id}`).submit();
    }
}


document.addEventListener("DOMContentLoaded", function() {
const hideDeleted = document.getElementById("hideDeleted");
const showAll = document.getElementById("showAll");
const rows = document.querySelectorAll("#tableBody tr");

function filterTable() {
rows.forEach(row => {
    if (row.classList.contains("deleted")) {
        row.style.display = hideDeleted.checked ? "none" : "";
    }
});
}

hideDeleted.addEventListener("change", filterTable);
showAll.addEventListener("change", filterTable);

// Initially hide deleted rows
filterTable();
});



function confirmDelete(id, departmentName) {
if (confirm(`Are you sure you want to delete "${departmentName}"?`)) {
document.getElementById(`deleteForm-${id}`).submit();
}
}

function confirmPermanentDelete(id, departmentName) {
if (confirm(`Are you sure you want to permanently delete "${departmentName}"? This action cannot be undone!`)) {
document.getElementById(`permanentDeleteForm-${id}`).submit();
}
}
