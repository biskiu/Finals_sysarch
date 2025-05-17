<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<div class="diva">
    <h2>Departments of</h2>
    <h1>{{ $college->CollegeName }}</h1>
        <div>
            <button onclick="openAddModal()">Add Department</button>
            {{-- <a href= {{ route('college') }} >BACK</a> --}}
            <button onclick="window.location.href='{{ route('college') }}'">Back</button>
                <input type="radio" name="filter" id="hideDeleted" checked> Hide Deleted
                <input type="radio" name="filter" id="showAll"> Show All

        </div>
<br>
    <table>
        <tr>
            <th>Name</th>
            <th>Code</th>
            <th>Status</th>
            <th>Actions</th>

            @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </tr>

        <tbody id="tableBody">
            @foreach ($departments as $d)
                <tr class="{{ $d->deleted_at ? 'deleted' : '' }}">
                    <td>{{ $d->DepartmentName }}</td>
                    <td>{{ $d->DepartmentCode }}</td>
                    <td>
                        @if($d->deleted_at)
                            <span style="color: red;">Deleted</span>
                            @else
                            <span class="{{ $d->IsActive ? 'status-active' : 'status-inactive' }}">
                                {{ $d->IsActive ? 'Active' : 'Inactive' }}
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($d->deleted_at)
                            <!-- Restore Button -->
                            <form action="{{ route('restore.department', $d->DepartmentID) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit">Restore</button>
                            </form>

                            <!-- Permanent Delete Button -->
                            <form id="permanentDeleteForm-{{ $d->DepartmentID }}" action="{{ route('delete.permanent.department', $d->DepartmentID) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmPermanentDelete({{ $d->DepartmentID }}, '{{ $d->DepartmentName }}')">Delete</button>
                            </form>
                        @else
                            <!-- Edit & Soft Delete -->
                            <button onclick="openEditModal('{{ $d->DepartmentID }}', '{{ $d->DepartmentCode }}', '{{ $d->DepartmentName }}', '{{ $d->IsActive }}')">Edit</button>

                            <form id="deleteForm-{{ $d->DepartmentID }}" action="{{ route('delete.department', $d->DepartmentID) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $d->DepartmentID }}, '{{ $d->DepartmentName }}')">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



    <!-- ADD Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <h2>Add Department</h2>
            <form action="{{ route('store.department') }}" method="POST">
                <input type="hidden" name="college_id" value="{{ $college->CollegeID }}">

                @csrf
                <label>Name: <input type="text" name="name"></label><br><br>
                <label>Code: <input type="text" name="code"></label><br><br>
                <label>Status:
                    <select name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </label><br><br>
                <button type="submit">Save</button>
                <button type="button" onclick="closeAddModal()">Cancel</button>
            </form>
        </div>
    </div>

    <!-- EDIT Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>Edit Department</h2>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">
                <label>Name: <input type="text" id="editName" name="name"></label><br><br>
                <label>Code: <input type="text" id="editCode" name="code"></label><br><br>
                <label>Status:
                    <select id="editStatus" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </label><br><br>
                <button type="submit">Update</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>

<script src="/js/department_script.js"></script>
<br><br><br>

<div class="department-cards">
    <div class="card">
        <h3>Computer Science</h3>
        <p>Code: CS</p>
        <p>Status: Active</p>
    </div>
    <div class="card">
        <h3>Electronics</h3>
        <p>Code: ECE</p>
        <p>Status: Inactive</p>
    </div>
</div>

</body>
</html>
