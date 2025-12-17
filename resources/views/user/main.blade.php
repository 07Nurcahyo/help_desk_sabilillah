@extends('layouts.template')

@section('content')

<div class="container">

  <div class="card">
    <div class="card-header d-flex justify-content-center bg-navy">
      <h2 class="card-title font-weight-bold" style="font-size: 22px">Rekap Laporan Masalah</h2>
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
              <select class="form-control" name="id_category" id="id_category" required>
                <option value="">--Semua--</option>
                @foreach($category as $item)
                  <option value="{{$item->id_category}}">{{$item->category_name}}</option>
                @endforeach
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
              <th>Catatan Admin</th>
              <th>Waktu</th>
            </tr>
          </thead>
        </table>
      </div>

    </div> <!-- /.card-body -->
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
          d.id_category = $('#id_category').val();
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
          orderable: true,
          searchable: true
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
                  badgeClass = 'badge badge-primary';
              }

              return `<span class="${badgeClass}">${data}</span>`;
          }
        },
        {
          data: "admin_note",
          className: "text-center",
          orderable: true,
          searchable: true
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
        }
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
    $('#buttons').html(dataLaporan.buttons().container());

});
</script>
@endpush