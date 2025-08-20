@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </h1>
        <p style="color: #666; margin: 0;">¡Bienvenido/a, {{ $user->full_name }}!</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number">{{ $contactsCount }}</div>
            <div class="stat-label">Contactos Total</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stat-number">{{ $recentContacts->count() }}</div>
            <div class="stat-label">Contactos Recientes</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stat-number">{{ $user->created_at->format('M Y') }}</div>
            <div class="stat-label">Miembro Desde</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
        <div>
            <h3 style="margin-bottom: 1rem; color: #333;">
                <i class="fas fa-clock"></i>
                Contactos Recientes
            </h3>
            
            @if($recentContacts->count() > 0)
                <div style="background: #f8f9fa; border-radius: 8px; padding: 1rem;">
                    @foreach($recentContacts as $contact)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e0e0e0;">
                            <div>
                                <strong>{{ $contact->nombre }} {{ $contact->apellido }}</strong><br>
                                <small style="color: #666;">{{ $contact->email }}</small>
                            </div>
                            <div>
                                <a href="{{ route('contacts.show', $contact) }}" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: #666;">
                    <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p>No tienes contactos aún.</p>
                </div>
            @endif
        </div>

        <div>
            <h3 style="margin-bottom: 1rem; color: #333;">
                <i class="fas fa-rocket"></i>
                Acciones Rápidas
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <a href="{{ route('contacts.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i>
                    Agregar Nuevo Contacto
                </a>
                
                <a href="{{ route('contacts.index') }}" class="btn btn-primary">
                    <i class="fas fa-list"></i>
                    Ver Todos los Contactos
                </a>
                
                @if($contactsCount > 0)
                    <a href="{{ route('contacts.index') }}?search=" class="btn btn-secondary">
                        <i class="fas fa-search"></i>
                        Buscar Contactos
                    </a>
                @endif
            </div>

            @if($contactsCount > 0)
                <div style="margin-top: 2rem; padding: 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; color: white;">
                    <h4 style="margin-bottom: 0.5rem;">
                        <i class="fas fa-lightbulb"></i>
                        Consejo
                    </h4>
                    <p style="margin: 0; font-size: 0.9rem;">
                        Usa la función de búsqueda para encontrar contactos rápidamente por nombre, email o teléfono.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

@if($contactsCount === 0)
<div class="card" style="text-align: center;">
    <div style="padding: 3rem;">
        <i class="fas fa-address-book" style="font-size: 4rem; color: #667eea; margin-bottom: 1rem;"></i>
        <h2 style="color: #333; margin-bottom: 1rem;">¡Comienza a Gestionar tus Contactos!</h2>
        <p style="color: #666; margin-bottom: 2rem; font-size: 1.1rem;">
            Parece que no tienes contactos aún. ¡Agrega tu primer contacto para comenzar!
        </p>
        <a href="{{ route('contacts.create') }}" class="btn btn-success" style="font-size: 1.1rem; padding: 1rem 2rem;">
            <i class="fas fa-plus"></i>
            Agregar Mi Primer Contacto
        </a>
    </div>
</div>
@endif
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
