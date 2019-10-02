<table class="table table-hover table-sm mb-0">
  <tbody>
    @foreach($users as $user)
      <tr>
        <td class="align-middle" style="width: 30px;">
          <img class="border rounded" src="{{ asset('storage/avatars/'.$user->avatar) }}" style="width: 30px" />
        </td>
        <td class="align-middle">{{ $user->name }}</td>
        <td class="align-middle" style="width: 40px;">
          <button type="button" class="btn btn-warning btn-hover btn-sm btn-quitar_rol" data-name="{{ $user->name }}" data-userid="{{ $user->id }}" data-rolid="{{ $rol->id }}" title="Quitar usuario del rol"><i class="fa fa-remove"></i></button>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
