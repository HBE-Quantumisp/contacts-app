@extends('layouts.app')

@section('title', 'Agregar Contacto')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="card-title">
                    <i class="fas fa-user-plus"></i>
                    Agregar Nuevo Contacto
                </h1>
                <p style="color: #666; margin: 0;">Completa la información del contacto</p>
            </div>
            <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Volver a la Lista
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('contacts.store') }}">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label for="nombre" class="form-label">
                    <i class="fas fa-user"></i> Nombre *
                </label>
                <input type="text" 
                       id="nombre" 
                       name="nombre" 
                       class="form-control @error('nombre') is-invalid @enderror" 
                       value="{{ old('nombre') }}" 
                       required 
                       autofocus
                       placeholder="Nombre del contacto">
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="apellido" class="form-label">
                    <i class="fas fa-user"></i> Apellido *
                </label>
                <input type="text" 
                       id="apellido" 
                       name="apellido" 
                       class="form-control @error('apellido') is-invalid @enderror" 
                       value="{{ old('apellido') }}" 
                       required
                       placeholder="Apellido del contacto">
                @error('apellido')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label for="telefono" class="form-label">
                    <i class="fas fa-phone"></i> Teléfono *
                </label>
                <input type="tel" 
                       id="telefono" 
                       name="telefono" 
                       class="form-control @error('telefono') is-invalid @enderror" 
                       value="{{ old('telefono') }}" 
                       required
                       placeholder="+1234567890">
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Email *
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" 
                       required
                       placeholder="contacto@ejemplo.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="direccion" class="form-label">
                <i class="fas fa-map-marker-alt"></i> Dirección
            </label>
            <textarea id="direccion" 
                      name="direccion" 
                      class="form-control @error('direccion') is-invalid @enderror" 
                      rows="3"
                      placeholder="Dirección completa del contacto (opcional)">{{ old('direccion') }}</textarea>
            @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small style="color: #666; font-size: 0.85rem;">
                <i class="fas fa-info-circle"></i>
                La dirección es opcional pero puede ser útil para ubicar el contacto.
            </small>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end; border-top: 1px solid #e0e0e0; padding-top: 1.5rem;">
            <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i>
                Guardar Contacto
            </button>
        </div>
    </form>
</div>

<!-- Vista previa del contacto -->
<div class="card" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-eye"></i>
            Vista Previa
        </h3>
    </div>
    
    <div style="display: grid; grid-template-columns: auto 1fr; gap: 1rem; align-items: center;">
        <div style="width: 60px; height: 60px; background: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <h4 id="preview-name" style="margin: 0; color: #333;">Nombre Apellido</h4>
            <p id="preview-email" style="margin: 0; color: #666; font-size: 0.9rem;">
                <i class="fas fa-envelope"></i> email@ejemplo.com
            </p>
            <p id="preview-phone" style="margin: 0; color: #666; font-size: 0.9rem;">
                <i class="fas fa-phone"></i> +1234567890
            </p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media (max-width: 768px) {
        .card div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nombreInput = document.getElementById('nombre');
    const apellidoInput = document.getElementById('apellido');
    const emailInput = document.getElementById('email');
    const telefonoInput = document.getElementById('telefono');
    
    const previewName = document.getElementById('preview-name');
    const previewEmail = document.getElementById('preview-email');
    const previewPhone = document.getElementById('preview-phone');
    
    function updatePreview() {
        const nombre = nombreInput.value || 'Nombre';
        const apellido = apellidoInput.value || 'Apellido';
        const email = emailInput.value || 'email@ejemplo.com';
        const telefono = telefonoInput.value || '+1234567890';
        
        previewName.textContent = `${nombre} ${apellido}`;
        previewEmail.innerHTML = `<i class="fas fa-envelope"></i> ${email}`;
        previewPhone.innerHTML = `<i class="fas fa-phone"></i> ${telefono}`;
    }
    
    nombreInput.addEventListener('input', updatePreview);
    apellidoInput.addEventListener('input', updatePreview);
    emailInput.addEventListener('input', updatePreview);
    telefonoInput.addEventListener('input', updatePreview);
});
</script>
@endpush
