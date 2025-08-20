@extends('layouts.app')

@section('title', 'Lista de Contactos')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 class="card-title">
                    <i class="fas fa-users"></i>
                    Mis Contactos
                </h1>
                <p style="color: #666; margin: 0;">Gestiona tu lista de contactos</p>
            </div>
            <a href="{{ route('contacts.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i>
                Nuevo Contacto
            </a>
        </div>
    </div>

    <!-- Búsqueda -->
    <form method="GET" action="{{ route('contacts.index') }}" class="search-box">
        <div class="search-input">
            <input type="text" 
                   name="search" 
                   class="form-control" 
                   placeholder="Buscar por nombre, apellido, teléfono o email..." 
                   value="{{ request('search') }}">
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
            Buscar
        </button>
        @if(request('search'))
            <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Limpiar
            </a>
        @endif
    </form>

    @if($contacts->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><i class="fas fa-user"></i> Nombre</th>
                        <th><i class="fas fa-phone"></i> Teléfono</th>
                        <th><i class="fas fa-envelope"></i> Email</th>
                        <th><i class="fas fa-map-marker-alt"></i> Dirección</th>
                        <th><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>
                                <strong>{{ $contact->nombre }} {{ $contact->apellido }}</strong>
                            </td>
                            <td>
                                <a href="tel:{{ $contact->telefono }}" style="color: #667eea; text-decoration: none;">
                                    <i class="fas fa-phone"></i>
                                    {{ $contact->telefono }}
                                </a>
                            </td>
                            <td>
                                <a href="mailto:{{ $contact->email }}" style="color: #667eea; text-decoration: none;">
                                    <i class="fas fa-envelope"></i>
                                    {{ $contact->email }}
                                </a>
                            </td>
                            <td>
                                {{ $contact->direccion ? Str::limit($contact->direccion, 30) : 'No especificada' }}
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('contacts.show', $contact) }}" 
                                       class="btn btn-primary" 
                                       style="padding: 0.25rem 0.5rem; font-size: 0.8rem;"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('contacts.edit', $contact) }}" 
                                       class="btn btn-warning" 
                                       style="padding: 0.25rem 0.5rem; font-size: 0.8rem;"
                                       title="Editar contacto">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" 
                                          action="{{ route('contacts.destroy', $contact) }}" 
                                          style="display: inline;"
                                          onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger" 
                                                style="padding: 0.25rem 0.5rem; font-size: 0.8rem;"
                                                title="Eliminar contacto">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($contacts->hasPages())
            <div style="margin-top: 2rem; display: flex; justify-content: center;">
                {{ $contacts->appends(request()->query())->links() }}
            </div>
        @endif

        <!-- Información de resultados -->
        <div style="margin-top: 1rem; text-align: center; color: #666; font-size: 0.9rem;">
            Mostrando {{ $contacts->firstItem() }} - {{ $contacts->lastItem() }} de {{ $contacts->total() }} contactos
            @if(request('search'))
                para la búsqueda "{{ request('search') }}"
            @endif
        </div>
    @else
        <div style="text-align: center; padding: 3rem;">
            @if(request('search'))
                <i class="fas fa-search" style="font-size: 4rem; color: #ddd; margin-bottom: 1rem;"></i>
                <h3 style="color: #333; margin-bottom: 1rem;">No se encontraron resultados</h3>
                <p style="color: #666; margin-bottom: 2rem;">
                    No se encontraron contactos que coincidan con "{{ request('search') }}"
                </p>
                <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Ver Todos los Contactos
                </a>
            @else
                <i class="fas fa-users" style="font-size: 4rem; color: #ddd; margin-bottom: 1rem;"></i>
                <h3 style="color: #333; margin-bottom: 1rem;">No tienes contactos aún</h3>
                <p style="color: #666; margin-bottom: 2rem;">
                    ¡Comienza agregando tu primer contacto!
                </p>
                <a href="{{ route('contacts.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i>
                    Agregar Primer Contacto
                </a>
            @endif
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .table-responsive {
        overflow-x: auto;
    }
    
    @media (max-width: 768px) {
        .table th:nth-child(4),
        .table td:nth-child(4) {
            display: none;
        }
        
        .search-box {
            flex-direction: column;
        }
        
        .search-input {
            max-width: none;
        }
    }
</style>
@endpush
