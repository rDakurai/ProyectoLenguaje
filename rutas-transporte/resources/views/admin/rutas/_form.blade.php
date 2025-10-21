@csrf
<div class="mb-3">
  <label class="form-label">Nombre</label>
  <input type="text" name="nombre" class="form-control" required
         value="{{ old('nombre', $ruta->nombre ?? '') }}">
  @error('nombre') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Descripción</label>
  <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $ruta->descripcion ?? '') }}</textarea>
  @error('descripcion') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="d-flex gap-2">
  <button class="btn btn-primary" type="submit">{{ $btnText ?? 'Guardar' }}</button>
  <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">Cancelar</a>
</div>

