<?php

namespace App\View\Components\App;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarLink extends Component
{
    public $route;
    public $icon;
    public $label;

    /**
     * Crea una nueva instancia del componente.
     */
    public function __construct($route, $icon, $label)
    {
        // Resuelve el nombre de la ruta (ej. 'docentes.index') a su URL completa
        $this->route = route($route);
        $this->icon = $icon;
        $this->label = $label;
    }

    /**
     * Obtiene la vista/contenido que representa el componente.
     */
    public function render(): View|Closure|string
    {
        return view('components.app.sidebar-link');
    }
}