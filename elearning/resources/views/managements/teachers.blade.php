<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    .color {
        background-color: #FFFF;
    }

    .tengah {
        justify-content: center;
        align-items: center;
        margin: 0 auto;

    }

    table {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-collapse: collapse;
        width: 80%;
        margin: 0 auto;

    }


    th,
    td {
        padding: 8px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        text-align: center;
    }

    .edit-button {
        background-color: #19A7CE;
        color: #fff;
        border: none;
        padding: 6px 12px;
        cursor: pointer;
    }

    .delete-button {
        background-color: red;
        color: #fff;
        border: none;
        padding: 6px 12px;
        cursor: pointer;
    }


    .kanan {
        text-align: right;
        padding-right: 170px;
    }

    .button {
        background-color: #19A7CE;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .button:hover {
        background-color: #0D7E9B;
    }

    .button-delete {
        background-color: red;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-radius: 5px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-content textarea {
        box-shadow: 0 5px 7px rgba(0, 0, 0, 0.2);
        border: 0;
    }

    .form-container {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        margin-bottom: 10px;
        position: relative;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 200px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
</style>


<x-app-layout>
    <div class="color"></div>
    <x-slot name="header">
        <div class="w-full flex justify-between">
            <div class="">
                <h2 class="font-semibold text-xl text-gray-500 leading-tight">
                    {{ __('E-Learning | Management Guru') }}
                </h2>
            </div>
        </div>
        <div>
            <a href="{{ route('course.index') }}" class="text-blue-500 underline">
                < Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div style="background-color: #FFFF" class="min-h-screen overflow-x-hidden">
        @if (Auth::user()->role)
            <div class="flex justify-center w-full">
                <div class="w-[80%] flex justify-between">
                    @if (Session::has('msg'))
                        <div class="bg-cyan-500 text-white px-5 py-2 rounded w-2/5">
                            {{ Session::get('msg') }}
                        </div>
                    @else
                        <div></div>
                    @endif
                    <div class="">
                        <button class="button" onclick="openModal()">Create</button>
                    </div>
                </div>
            </div>

            <div id="myModal" class="modal">
                <div class="modal-content md:w-1/5">
                    <form action="{{ Route('teacher.store') }}" method="POST">
                        @csrf
                        <span class="close" onclick="closeModal()">&times;</span>
                        <div class="md:px-20 md:py-10">
                            <div class="mt-4" style="">
                                <label for="name" class="block font-bold">Nama Guru <span
                                        class="text-red-500">*</span></label>
                                <input type="text" class="w-full rounded focus:border-cyan-500" id="name"
                                    name="name" placeholder="Masukan Nama Guru" required>
                                <input type="hidden" value="{{ md5(rand(1, 10) . microtime()) }}" name="token">
                            </div>
                        </div>
                        <div class="flex justify-center w-full gap-2 mt-5">
                            <button class="button bg-red-500 hover:bg-red-700 rounded" type="reset">Reset</button>
                            <button class="button bg-green-500 hover:bg-green-700 rounded"
                                type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        @endif
        <br>


        <!--Tabel-->
        <div class="overflow-x-auto">
            <table class="tengah">
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Token Verifikasi</th>
                    <th>Terakhir Diubah</th>
                    <th>Aksi</th>
                </tr>
                @forelse ($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->id }}</td>
                        <td>{{ $teacher->teacher_name }}</td>
                        <td>
                            @if ($teacher->user_id)
                                Terdaftar
                            @else
                                Belum Terverifikasi
                            @endif
                        </td>
                        <td>
                            {{ $teacher->token }}
                        </td>

                        <td>{{ $teacher->updated_at }}</td>
                        <td>
                            <div class="flex justify-center gap-2">
                                <!-- Tombol aksi -->
                                <div class="flex">
                                    <a href="{{ route('teacher.edit', $teacher->id) }}"
                                        class="bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded h-fit">Edit</a>
                                </div>
                                <form action="{{ Route('teacher.destroy', $teacher->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="{{-- hidden --}} bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Data tidak ditemukan... Tabel dalam keadaan kosong.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
</x-app-layout>

<script>
    function openModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
    }

    function closeModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

    function deleteRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function deleteTulisan() {
        var id1Input = document.getElementById("id1");
        var id2Input = document.getElementById("id2");
        var id3Input = document.getElementById("id3");
        var id4Input = document.getElementById("id4");

        id1Input.value = "";
        id2Input.value = "";
        id3Input.value = "";
        id4Input.value = "";
    }

    function saveTask() {
        var id1 = document.getElementById("id1").value;
        var id2 = document.getElementById("id2").value;
        var id3 = document.getElementById("id3").value;
        var id4 = document.getElementById("id4").value;

        var table = document.getElementsByTagName("table")[0];
        var newRow = table.insertRow(table.rows.length);

        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);
        var cell6 = newRow.insertCell(5);

        cell1.innerHTML = id1;
        cell2.innerHTML = id2;
        cell3.innerHTML = id3;
        cell4.innerHTML = id4;
        cell5.innerHTML = "Waktu saat ini";
        cell6.innerHTML = `
                <button class="edit-button">Edit</button>
                <button class="delete-button" onclick="deleteRow(this)">Hapus</button>
            `;

        closeModal();
        deleteTulisan();
    }

    function deleteRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    window.onclick = function(event) {
        var modal = document.getElementById("myModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>

</html>
