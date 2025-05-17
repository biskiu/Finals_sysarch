<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colleges</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>


<body>


<div class="diva">
    <h1>Colleges</h1>
        <div>
            <button onclick="openAddModal()">Add College</button>
            <label>
                <input type="radio" name="filter" id="hideDeleted" checked> Hide Deleted
                <input type="radio" name="filter" id="showAll"> Show All
            </label>
        </div>
        <br>
        
        <form method="GET">
            <input type="text" name="search" placeholder="Search college...">
            <button type="submit">Search</button>
        </form>


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
        @foreach ($colleges as $c)
            <tr class="{{ $c->deleted_at ? 'deleted' : '' }}">
                <td>
                    @if($c->deleted_at)
                        <a href="#" onclick="alertDeletedCollege(event)"> {{ $c->CollegeName }} </a>
                    @else
                        <a href="{{ route('departments.by.college', $c->CollegeID) }}">{{ $c->CollegeName }}</a>
                    @endif
                </td>
                <td>{{ $c->CollegeCode }}</td>
                <td>
                    @if($c->deleted_at)
                        <span style="color: red;">Deleted</span>
                    @else
                        <span class="{{ $c->IsActive ? 'status-active' : 'status-inactive' }}">
                            {{ $c->IsActive ? 'Active' : 'Inactive' }}
                        </span>
                    @endif
                </td>
                <td>
                    @if($c->deleted_at)
                    <!-- Show Restore Button -->
                    <form action="{{ route('restore.college', $c->CollegeID) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit">Restore</button>
                    </form>

                    <!-- Permanent Delete Button -->
                    <form id="permanentDeleteForm-{{ $c->CollegeID }}" action="{{ route('delete.permanent.college', $c->CollegeID) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmPermanentDelete({{ $c->CollegeID }}, '{{ $c->CollegeName }}')">Delete</button>
                    </form>
                    @else
                        <!-- Show Edit & Delete Buttons if Not Deleted -->
                        <button onclick="openEditModal('{{ $c->CollegeID }}', '{{ $c->CollegeCode }}', '{{ $c->CollegeName }}', '{{ $c->IsActive }}')">
                            Edit
                        </button>

                        <form id="deleteForm-{{ $c->CollegeID }}" action="{{ route('delete.college', $c->CollegeID) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $c->CollegeID }}, '{{ $c->CollegeName }}')">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>



<!-- ADD Modal Pop-up -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <h2>Add College</h2>

        <form action="/store-college" method="POST">
            @csrf <!-- CSRF Token -->
            <label>Name: <input type="text" name="name"></label><br><br>
            <label>Code: <input type="text" name="code"></label><br><br>
            <label>Status:
                <select id="editStatus" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </label><br><br>

            <button type="submit">Save</button>
            <button type="button" onclick="closeAddModal()">Cancel</button>
        </form>
    </div>
</div>

<!-- EDIT Modal Pop-up -->
<div id="editModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Edit College</h2>
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

<script src="/js/college_script.js"></script>
<br><br><br>

</body>
</html>
