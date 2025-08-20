@extends('layouts.app')

@section('title', 'Detalles del Contacto')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="card-title">
                    <i class="fas fa-user"></i>
                    {{ $contact->nombre }} {{ $contact->apellido }}
                </h1>
                <p style="color: #666; margin: 0;">Información completa del contacto</p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i>
                    Editar
                </a>
                <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Volver a la Lista
                </a>
            </div>
        </div>
    </div>

    <!-- Información principal del contacto -->
    <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 2rem; align-items: start; margin-bottom: 2rem;">
        <!-- Avatar -->
        <div style="text-align: center;">
            <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; margin-bottom: 1rem;">
                <i class="fas fa-user"></i>
            </div>
            <div style="background: #f8f9fa; padding: 0.5rem; border-radius: 8px; font-size: 0.8rem; color: #666;">
                Contacto #{{ $contact->id }}
            </div>
        </div>

        <!-- Información básica -->
        <div>
            <h2 style="color: #333; margin-bottom: 1rem;">{{ $contact->nombre }} {{ $contact->apellido }}</h2>
            
            <div style="display: grid; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 40px; height: 40px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <strong>Teléfono</strong><br>
                        <a href="tel:{{ $contact->telefono }}" style="color: #667eea; text-decoration: none; font-size: 1.1rem;">
                            {{ $contact->telefono }}
                        </a>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 40px; height: 40px; background: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <strong>Email</strong><br>
                        <a href="mailto:{{ $contact->email }}" style="color: #667eea; text-decoration: none; font-size: 1.1rem;">
                            {{ $contact->email }}
                        </a>
                    </div>
                </div>

                @if($contact->direccion)
                <div style="display: flex; align-items: start; gap: 1rem;">
                    <div style="width: 40px; height: 40px; background: #ffc107; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <strong>Dirección</strong><br>
                        <span style="color: #333;">{{ $contact->direccion }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 12px; min-width: 200px;">
            <h4 style="margin-bottom: 1rem; color: #333;">
                <i class="fas fa-bolt"></i>
                Acciones Rápidas
            </h4>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="tel:{{ $contact->telefono }}" class="btn btn-success" style="justify-content: flex-start;">
                    <i class="fas fa-phone"></i>
                    Llamar
                </a>
                
                <a href="mailto:{{ $contact->email }}" class="btn btn-primary" style="justify-content: flex-start;">
                    <i class="fas fa-envelope"></i>
                    Enviar Email
                </a>
                
                @if($contact->direccion)
                <a href="https://maps.google.com/?q={{ urlencode($contact->direccion) }}" 
                   target="_blank" 
                   class="btn btn-warning" 
                   style="justify-content: flex-start;">
                    <i class="fas fa-map"></i>
                    Ver en Mapa
                </a>
                @endif
                
                <form method="POST" 
                      action="{{ route('contacts.destroy', $contact) }}" 
                      style="margin: 0;"
                      onsubmit="return confirmDelete(event)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: flex-start;">
                        <i class="fas fa-trash"></i>
                        Eliminar Contacto
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Información adicional -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <!-- Historial -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-history"></i>
                Historial
            </h3>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #28a745;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <strong style="color: #28a745;">
                        <i class="fas fa-plus-circle"></i>
                        Contacto Creado
                    </strong>
                    <small style="color: #666;">{{ $contact->created_at->format('d/m/Y H:i') }}</small>
                </div>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">
                    Hace {{ $contact->created_at->diffForHumans() }}
                </p>
            </div>

            @if($contact->created_at != $contact->updated_at)
            <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #ffc107;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <strong style="color: #ffc107;">
                        <i class="fas fa-edit"></i>
                        Última Actualización
                    </strong>
                    <small style="color: #666;">{{ $contact->updated_at->format('d/m/Y H:i') }}</small>
                </div>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">
                    Hace {{ $contact->updated_at->diffForHumans() }}
                </p>
            </div>
            @endif
        </div>
    </div>

    <!-- Información técnica -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-cog"></i>
                Información Técnica
            </h3>
        </div>
        
        <div style="display: grid; gap: 1rem;">
            <div style="display: flex; justify-content: space-between; padding: 0.75rem; background: #f8f9fa; border-radius: 6px;">
                <span style="font-weight: 500;">ID del Contacto:</span>
                <span style="color: #666;">{{ $contact->id }}</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; padding: 0.75rem; background: #f8f9fa; border-radius: 6px;">
                <span style="font-weight: 500;">Propietario:</span>
                <span style="color: #666;">{{ $contact->user->full_name }}</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; padding: 0.75rem; background: #f8f9fa; border-radius: 6px;">
                <span style="font-weight: 500;">Estado:</span>
                <span style="color: #28a745; font-weight: 500;">
                    <i class="fas fa-check-circle"></i>
                    Activo
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media (max-width: 768px) {
        .card div[style*="grid-template-columns: auto 1fr auto"] {
            grid-template-columns: 1fr !important;
            text-align: center !important;
        }
        
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
