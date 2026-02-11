@extends('layouts.admin')

@section('main-content')
    <h2>Data Kegiatan</h2>

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="title">Judul Kegiatan</label>
                <input class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="date">Tanggal Kegiatan</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="thumbnail">Thumbnail Kegiatan</label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi Kegiatan</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <button type="button" class="btn btn-success" id="save">Simpan</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#save').on('click', function() {
            let formData = new FormData();
            formData.append('title', $('#title').val());
            formData.append('date', $('#date').val());
            $('#thumbnail')[0].files[0] ? formData.append('thumbnail', $('#thumbnail')[0].files[0]) : null;
            formData.append('description', $('#description').val());

            $.ajax({
                url: '{{ url("/admin/data/kegiatan/store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success(response.text);
                    window.location.href = '{{ url("/admin/data/kegiatan") }}';
                },
                error: function(xhr) {
                    console.log(xhr);
                    xhr.responseJSON.title?.[0] ? toastr.error(xhr.responseJSON.title?.[0]) : '';
                    xhr.responseJSON.date?.[0] ? toastr.error(xhr.responseJSON.date?.[0]) : '';
                    xhr.responseJSON.thumbnail?.[0] ? toastr.error(xhr.responseJSON.thumbnail?.[0]) : '';
                    xhr.responseJSON.description?.[0] ? toastr.error(xhr.responseJSON.description?.[0]) : '';
                }
            });
        });
    </script>
@endpush