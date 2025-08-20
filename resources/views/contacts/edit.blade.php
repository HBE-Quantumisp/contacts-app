@extends('layouts.app')

@section('title', 'Editar Contacto')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="card-title">
                    <i class="fas fa-edit"></i>
                    Editar Contacto
                </h1>
                <p style="color: #666; margin: 0;">Actualiza la información de {{ $contact->nombre }} {{ $contact->apellido }}</p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('contacts.show', $contact) }}" class="btn btn-primary">
                    <i class="fas fa-eye"></i>
                    Ver Detalles
                </a>
                <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Volver a la Lista
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('contacts.update', $contact) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label for="nombre" class="form-label">
                    <i class="fas fa-user"></i> Nombre *
                </label>
                <input type="text" 
                       id="nombre" 
                       name="nombre" 
                       class="form-control @error('nombre') is-invalid @enderror" 
                       value="{{ old('nombre', $contact->nombre) }}" 
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
                       value="{{ old('apellido', $contact->apellido) }}" 
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
                       value="{{ old('telefono', $contact->telefono) }}" 
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
                       value="{{ old('email', $contact->email) }}" 
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
                      placeholder="Dirección completa del contacto (opcional)">{{ old('direccion', $contact->direccion) }}</textarea>
            @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end; border-top: 1px solid #e0e0e0; padding-top: 1.5rem;">
            <a href="{{ route('contacts.show', $contact) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i>
                Actualizar Contacto
            </button>
        </div>
    </form>
</div>

<!-- Información adicional -->
<div class="card" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i>
            Información del Contacto
        </h3>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div>
            <h4 style="color: #333; margin-bottom: 1rem;">Datos Actuales</h4>
            <div style="background: white; padding: 1rem; border-radius: 8px; border: 1px solid #e0e0e0;">
                <p><strong>Nombre:</strong> {{ $contact->nombre }} {{ $contact->apellido }}</p>
                <p><strong>Teléfono:</strong> {{ $contact->telefono }}</p>
                <p><strong>Email:</strong> {{ $contact->email }}</p>
                <p><strong>Dirección:</strong> {{ $contact->direccion ?: 'No especificada' }}</p>
            </div>
        </div>
        
        <div>
            <h4 style="color: #333; margin-bottom: 1rem;">Información del Sistema</h4>
            <div style="background: white; padding: 1rem; border-radius: 8px; border: 1px solid #e0e0e0;">
                <p><strong>Creado:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Actualizado:</strong> {{ $contact->updated_at->format('d/m/Y H:i') }}</p>
                @if($contact->created_at != $contact->updated_at)
                    <small style="color: #666;">
                        <i class="fas fa-clock"></i>
                        Última modificación hace {{ $contact->updated_at->diffForHumans() }}
                    </small>
                @endif
            </div>
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
        
        .card-header div[style*="display: flex"] {
            flex-direction: column !important;
            gap: 1rem !important;
            align-items: stretch !important;
        }
    }
</style>
@endpush
