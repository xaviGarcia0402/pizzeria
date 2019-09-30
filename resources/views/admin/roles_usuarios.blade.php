<table class="table table-hover">
  <tbody>
    @foreach($users as $user)
      <tr>
        <td style="width: 20px;"><i class="fa fa-user"></i></td>
        <td>{{ $user->name }}</td>
        <td style="width: 40px;">
          <button type="button" class="btn btn-warning btn-hover btn-sm btn-quitar_rol" data-name="{{ $user->name }}" data-userid="{{ $user->id }}" data-rolid="{{ $rol->id }}"><i class="fa fa-remove"></i></button>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
