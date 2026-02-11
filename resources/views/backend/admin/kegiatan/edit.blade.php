@extends('layouts.admin')

@section('main-content')
    <h2>Data Kegiatan</h2>

    <div class="card">
        <div class="card-body">
            <input type="hidden" id="id_kegiatan" name="id_kegiatan" value="{{ $kegiatan->id }}">
            <div class="form-group">
                <label for="title">Judul Kegiatan</label>
                <input class="form-control" id="title" name="title" required value="{{ $kegiatan->title }}">
            </div>
            <div class="form-group">
                <label for="date">Tanggal Kegiatan</label>
                <input type="date" class="form-control" id="date" name="date" required value="{{ $kegiatan->date }}">
            </div>

            <div class="preview d-flex justify-content-center">
                <img src="{{ $kegiatan->thumbnail }}" alt="" width="300">
            </div>
            <div class="form-group">
                <label for="thumbnail">Thumbnail Kegiatan</label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi Kegiatan</label>
                <textarea class="form-control" id="description" name="description" rows="4" required>{{ $kegiatan->description }}</textarea>
            </div>

            <button type="button" class="btn btn-success" id="update">Simpan</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#update').on('click', function() {
            let id_kegiatan = $('#id_kegiatan').val();
            let formData = new FormData();
            formData.append('title', $('#title').val());
            formData.append('date', $('#date').val());
            $('#thumbnail')[0].files[0] ? formData.append('thumbnail', $('#thumbnail')[0].files[0]) : null;
            formData.append('description', $('#description').val());

            $.ajax({
                url: `/admin/data/kegiatan/update/${id_kegiatan}`,
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