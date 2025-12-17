@extends('layouts.template')

@section('content')

<div class="container">

  <div class="card">
    <div class="card-header bg-navy">
      <h2 class="card-title font-weight-bold" style="font-size: 22px">Kelola Laporan Masalah Keseluruhan</h2>
      <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
      @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <div class="row">
        {{-- filter --}}
        <div class="col-md-7">
          <div class="form-group row">
            <label class="pl-2 control-label col-form-label font-weight-normal">Filter Kategori : </label>
            <div class="col-3">
              <select class="form-control" name="status" id="status" required>
                    <option value="">--Pilih Salah Satu--</option>
                    <option value="baru">Baru</option>
                    <option value="proses">Proses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
          </div>
        </div>
        <div class="col-md-5 text-right">
          <div id="buttons" class="btn-group"></div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-striped w-100" id="tabel_data_laporan">
          <thead>
            <tr style="text-align: center;">
              {{-- <th>No</th> --}}
              <th>User</th> {{-- dibagi per role --}}
              <th>Judul</th>
              <th>Deskripsi</th>
              <th>Kategori</th> {{-- fk --}}
              <th>Lampiran</th>
              <th>Status</th>
              <th>Aksi</th>
              <th>Waktu</th>
            </tr>
          </thead>
        </table>
      </div>
    </div> <!-- /.card-body -->

    {{-- modal edit data --}}
    <div class="modal fade" id="editDataModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-navy">
                        <h5 class="modal-title">Edit Data Laporan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <input type="hidden" id="id_ticket_edit" name="id_ticket">
                                <input type="hidden" name="id_user" value="{{ auth()->user()->id_user }}">
                                <input type="text" id="username_edit" name="username" class="form-control" value="{{ auth()->user()->username }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Judul</label>
                            <div class="col-sm-9">
                                <input id="title_edit" type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Deskripsi</label>
                            <div class="col-sm-9">
                                {{-- <input type="text" name="description" class="form-control" required> --}}
                                <textarea id="description_edit" name="description" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kategori</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="category_edit" name="id_category" id="id_category" required>
                                    <option value="">--Semua--</option>
                                    @foreach($category as $item)
                                    <option value="{{$item->id_category}}">{{$item->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Lampiran</label>
                            <div class="col-sm-9">
                                <input id="attachment_edit" type="file" name="attachment" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="status" id="status" required>
                                    <option value="">--Pilih Salah Satu--</option>
                                    <option value="baru">Baru</option>
                                    <option value="proses">Proses</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>  Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

  </div>

</div><!-- /.container-fluid -->

@endsection

@push('css')
@endpush

@push('js')
<script>
  $(document).ready(function() {

    var dataLaporan = $('#tabel_data_laporan').DataTable({
      serverSide: false,
      ajax: {
        url: "{{ url('/lihat_data_laporan/') }}",
        dataType: "json",
        type: "GET",
        data: function(d) {
        //   d.id_category = $('#id_category').val();
        d.status = $('#status').val();
        }
      },
      columns: [
        // {
        //   data: "DT_RowIndex",
        //   // data: "id",
        //   className: "text-center",
        //   orderable: false,
        //   searchable: true
        // },
        {
          data: "users.username", // menyeseuaikan role
          className: "text-center",
          orderable: true,
          searchable: true
        },
        {
          data: "title",
          className: "text-center",
          orderable: true,
          searchable: true
        },
        {
          data: "description",
          className: "text-center",
          orderable: true,
          searchable: true
        },
        {
            data: "category.category_name",
            className: "text-center",
            orderable: true,
            searchable: true
        },
        {
            data: "attachment",
            className: "text-center",
            orderable: false,
            searchable: false,
            render: function (data) {
                if (!data) return '-';

                let ext = data.split('.').pop().toLowerCase();
                let url = `/storage/${data}`;

                // gambar
                if (['jpg','jpeg','png'].includes(ext)) {
                    return `<img src="${url}"
                            alt="attachment"
                            style="max-width:80px; max-height:80px; border-radius:4px;">`;
                }

                // file lain
                return `<a href="${url}" target="_blank">
                        <i class="fas fa-file"></i> Download
                        </a>`;
            }
        },
        {
            data: "status",
            className: "text-center",
            orderable: true,
            searchable: true,
            render: function (data) {
                let badgeClass = '';

                if (data === 'baru') {
                    badgeClass = 'badge badge-primary';   // biru
                } else if (data === 'proses') {
                    badgeClass = 'badge badge-warning';   // kuning
                } else if (data === 'selesai') {
                    badgeClass = 'badge badge-success';   // hijau
                } else {
                    badgeClass = 'badge badge-secondary';
                }

                return `<span class="${badgeClass}">${data}</span>`;
            }
        },
        {
            data: "created_at",
            className: "text-center",
            orderable: true,
            searchable: true,
            render: function (data, type, row) {
                if (!data) return '-';

                // ambil tanggal saja (YYYY-MM-DD)
                return data.substring(0, 10);
            }
        },
        {
            data: "aksi",
            className: "text-center",
            orderable: false,
            searchable: false
        },
      ],
      buttons: [
        {
          extend: 'copyHtml5',
          text: '<i class="fas fa-copy"></i>',
          titleAttr: 'Copy',
          className: 'btn btn-default btn-sm',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6]
          }
        },
        {
          extend: 'excelHtml5',
          text: '<i class="fas fa-file-excel"></i>',
          titleAttr: 'Excel',
          className: 'btn btn-success btn-sm',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6]
          }
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i>',
          titleAttr: 'PDF',
          title: 'Data Iterasi Akhir',
          className: 'btn btn-danger btn-sm',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6]
          }
        },
        {
          extend: 'print',
          text: '<i class="fas fa-print"></i>',
          titleAttr: 'Print',
          title: 'Data Iterasi Akhir',
          className: 'btn btn-info btn-sm',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6]
          }
        }
      ],
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      initComplete: function() {
        var api = this.api();
        api.buttons().container().appendTo('#buttons');// .addClass('float-right');
        // $('#buttons').html(dataLaporan.buttons().container().html());
      },
    });
    $('#id_category').on('change',function() {
      dataLaporan.ajax.reload();
    });
    $('#status').on('change', function () {
        dataLaporan.ajax.reload();
    });
    $('#buttons').html(dataLaporan.buttons().container());


    // ketika tombol edit diklik
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');

        $.get(`/user/${id}/edit-json`, function (res) {
            $('#id_ticket_edit').val(res.id_ticket);
            $('#title_edit').val(res.title);
            $('#description_edit').val(res.description);
            $('#category_edit').val(res.id_category);

            $('#editDataModal').modal('show');
        });
    });
    $('#editForm').on('submit', function (e) {
        e.preventDefault();

        const id = $('#id_ticket_edit').val();
        let formData = new FormData(this);

        // wajib untuk PUT
        formData.append('_method', 'PUT');

        $.ajax({
            url: `/user/${id}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                $('#editDataModal').modal('hide');
                $('#tabel_data_laporan').DataTable().ajax.reload();

                alert('Data berhasil diperbarui');
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Gagal menyimpan data');
            }
        });
    });


});
</script>
@endpush