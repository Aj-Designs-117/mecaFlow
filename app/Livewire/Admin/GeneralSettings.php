<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GeneralSettings extends Component
{
    public $settings = [];

    public function render()
    {
        return view('livewire.admin.general-settings');
    }

    public function mount()
    {
        $user = auth()->user();

        if (! $user->hasRole('Administrador')) {
            abort(403, 'No tienes permiso para editar este post.');
        }

        $this->settings = Setting::pluck('value', 'key')->toArray();
    }

    public function store()
    {
        $validated = $this->validate([
            'settings.site_title' => 'required|string|max:255',
            'settings.site_description' => 'required|string|max:500',
            'settings.site_author' => 'required',
            'settings.site_number' => 'required|max:20',
            'settings.site_email' => 'required|email',
            'settings.facebook_url' => 'nullable|url',
            'settings.web_url' => 'nullable|url',
            'settings.instagram_url' => 'nullable|url',
            'settings.nav_links' => 'required'
        ]);

        try {

            DB::beginTransaction();

            foreach ($validated['settings'] as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }

            DB::commit();

            Log::info("Configuración actualizada", ['key' => $key, 'value' => $value]);

            $this->dispatch('success', ['message' => 'Se ha guardado correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al guardar configuración', [
                'message' => $e->getMessage(),
                'inputs' => $this->settings,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            $this->dispatch('error', ['message' => 'Algo va mal al guardar configuración']);
        }
    }
}
