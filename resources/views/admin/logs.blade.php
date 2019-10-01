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

      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      <div id="card-roles" class="card mb-2">
        <div class="card-header">
          Logs
        </div><!-- /.card-header -->

        <table class="table table-hover table-striped table-sm mb-0">
          <thead>
            <tr>
              <td>Fecha</td>
              <td>Usuario</td>
              <td>Tipo</td>
              <td>Descripción</td>
              <td>Objetivo</td>
              <td style="width: 60px;"></td>
            </tr>
          </thead>
          <tbody>
            @foreach($logs as $log)
              <tr>
                <td class="align-middle">{{ $log->created_at }}</td>
                <td class="align-middle">{{ $log->causer->name }}</td>
                <td class="align-middle">{{ $log->log_name }}</td>
                <td class="align-middle">{{ $log->description }}</td>
                <td class="align-middle">{{ $log->subject_type }}</td>
                <td>
                  @if(count($log->changes) > 0)
                    <button class="btn-data btn btn-info btn-sm" type="button" value="{{ base64_encode( json_encode($log->changes) ) }}">Data</button>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="overlay" style="display: none;"><i class="fa fa-2x fa-refresh fa-spin"></i></div>

      </div><!-- /.card -->

      {{ $logs->onEachSide(2)->links() }}

    </div><!-- /.col -->
  </div><!-- /.row -->

</div><!-- /.container -->
@endsection

@section('footer_scripts')
  <script type="text/javascript">

    window.addEventListener('load', function(){
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
    });

    function print_r(o) {
      return JSON.stringify(o,null,'\t').replace(/\n/g,'<br>').replace(/\t/g,'&nbsp;&nbsp;&nbsp;');
    }// /print_r

  </script>
@endsection
