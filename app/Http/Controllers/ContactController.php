<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->contacts();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('telefono', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('nombre')->paginate(10);

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => [
                'required',
                'string',
                'max:20',
                Rule::unique('contacts')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('contacts')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })
            ],
            'direccion' => 'nullable|string|max:500',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.unique' => 'Ya tienes un contacto con este número de teléfono.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'email.unique' => 'Ya tienes un contacto con este email.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Auth::user()->contacts()->create($request->all());

        return redirect()->route('contacts.index')->with('success', 'Contacto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403);
        }

        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403);
        }

        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => [
                'required',
                'string',
                'max:20',
                Rule::unique('contacts')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($contact->id)
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('contacts')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($contact->id)
            ],
            'direccion' => 'nullable|string|max:500',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.unique' => 'Ya tienes un contacto con este número de teléfono.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'email.unique' => 'Ya tienes un contacto con este email.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('success', 'Contacto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403);
        }

        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contacto eliminado exitosamente.');
    }
}
