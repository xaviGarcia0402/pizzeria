@extends('layouts.app')

@section('content')

<div class="modal fade" id="modal_multiusos_lg" tabindex="-1" role="dialog" aria-labelledby="modal_multiusos_lg_label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_multiusos_lg_label">Logs</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div><!-- /.modal-header -->
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div><!-- /.modal-footer -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /#modal_multiusos_lg -->

<div class="container">

  <div class="row justify-content-center">
    <div class="col-md-12">

      <div id="card-roles" class="card mb-2">
        <div class="card-header">
          Logs
        </div><!-- /.card-header -->

        <div class="card-body p-1">
          <table class="data-table table table-hover table-striped table-sm mb-0" style="width: 100%">
            <thead>
              <tr>
                <td style="width: 140px;">Fecha</td>
                <td>Usuario</td>
                <td>Tipo</td>
                <td>Descripción</td>
                <td>Objetivo</td>
                <td style="width: 60px;"></td>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div><!-- /.card-body -->

        <div class="overlay" style="display: none;"><i class="fa fa-2x fa-refresh fa-spin"></i></div>

      </div><!-- /.card -->

    </div><!-- /.col -->
  </div><!-- /.row -->

</div><!-- /.container -->
@endsection

@section('footer_scripts')
  <script type="text/javascript">

    window.addEventListener('load', function(){

      var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('logs.index') }}",
          "type": "POST",
        },
        order: [[0, 'desc']],
        columns: [
          {data: 'created_at', name: 'created_at', "width": "140px"},
          {data: 'causer', name: 'causer', orderable: false, searchable: false, },
          {data: 'log_name', name: 'log_name'},
          {data: 'description', name: 'description'},
          {data: 'subject_type', name: 'subject_type'},
          {data: 'data', name: 'data', orderable: false, searchable: false, "width": "60px" },
        ],
        columnDefs: [
          { className: "align-middle", targets: "_all" }
        ],
      });// /DataTable

      $(document).on("click", ".btn-data", function(){
        var data = JSON.parse( atob( $(this).val() ) );
        var html =
           '<pre>' +
           	print_r(data) +
           '</pre>' +
           '';
         $("#modal_multiusos_lg .modal-body").html(html);
         $("#modal_multiusos_lg").modal();
      });

    });// /window load

    function print_r(o) {
      return JSON.stringify(o,null,'\t').replace(/\n/g,'<br>').replace(/\t/g,'&nbsp;&nbsp;&nbsp;');
    }// /print_r

  </script>
@endsection
