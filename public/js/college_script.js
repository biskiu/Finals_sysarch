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

// Set form action with ID
document.getElementById("editForm").action = "/update-college/" + id;
document.getElementById("editModal").style.display = "flex";
}

function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
}

function confirmDelete(id, collegeName) {
if (confirm(`Are you sure you want to delete "${collegeName}"?`)) {
    document.getElementById(`deleteForm-${id}`).submit();
}
}

document.addEventListener("DOMContentLoaded", function() {
const hideDeleted = document.getElementById("hideDeleted");
const showAll = document.getElementById("showAll");

function filterTable() {
    const deletedRows = document.querySelectorAll(".deleted");
    if (hideDeleted.checked) {
        deletedRows.forEach(row => row.style.display = "none");
    } else {
        deletedRows.forEach(row => row.style.display = "");
    }
}

hideDeleted.addEventListener("change", filterTable);
showAll.addEventListener("change", filterTable);

// Initially hide deleted rows
filterTable();
});

function confirmPermanentDelete(id, collegeName) {
    if (confirm(`Are you sure you want to permanently delete "${collegeName}"? This action cannot be undone!`)) {
        document.getElementById(`permanentDeleteForm-${id}`).submit();
    }
}

function alertDeletedCollege(event) {
    event.preventDefault(); // Prevent navigation
    alert("This college has been deleted.");
}
