<?php

namespace App\Http\Middleware;

use App\Enums\Permission as PermissionEnums;
use App\Models\Devices\Lighting;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'ziggy' => fn() => [
                ...(new Ziggy())->toArray(),
                'location' => $request->url(),
            ],
            'locale' => fn() => collect(config('app.locale')),
            'permissions' => $request->user() ? [
                'lighting' => [
                    PermissionEnums::ViewDevices->value => $request->user()->can(PermissionEnums::ViewDevices->value, Lighting::class),
                    PermissionEnums::ControlDevices->value => $request->user()->can(PermissionEnums::ControlDevices->value, Lighting::class),
                ],
            ] : null,
        ];
    }
}
