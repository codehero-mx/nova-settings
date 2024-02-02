<?php

namespace CodeHeroMX\SettingsTool\Http\Middleware;


use CodeHeroMX\SettingsTool\SettingsTool;

class SettingsPathExists
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        $path = $request->get('path') ?: $request->route('path');
        $path = !empty($path) ? trim($path) : 'general';
        return SettingsTool::doesPathExist($path) ? $next($request) : abort(404);
    }
}
