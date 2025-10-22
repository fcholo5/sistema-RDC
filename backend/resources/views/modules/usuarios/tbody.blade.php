@foreach ($items as $item)
    <tr class="text-center">
        <td>{{ $item->email }}</td>
        <td>{{ $item->name }}</td>
        <td>
            {{ $item->rol->nombre ?? 'Sin rol' }}
        </td>
        <td>
            <a href="#" class="btn btn-secondary">
                <i class="fa-solid fa-user-lock"></i>
            </a>
        </td>
        <td>
            <div class="form-check form-switch d-flex justify-content-center">
                <input 
                    class="form-check-input toggle-estado" 
                    type="checkbox" 
                    id="{{ $item->id }}"
                    {{ $item->activo ? 'checked' : '' }}>
            </div>
        </td>
        <td>
            <a href="{{ route('usuarios.edit', $item->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-user-pen"></i>
            </a>
        </td>
    </tr>
@endforeach
