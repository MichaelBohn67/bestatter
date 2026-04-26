<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale', config('app.locale', 'en'));
        $locale = in_array($locale, ['en', 'de'], true) ? $locale : 'en';
        $localeMap = [
            'en' => 'en_US.UTF-8',
            'de' => 'de_DE.UTF-8',
        ];
        $phpLocale = $localeMap[$locale] ?? $localeMap['en'];
        $shortLocale = $locale;

        App::setLocale($locale);
        putenv("LANG={$phpLocale}");
        putenv("LANGUAGE={$shortLocale}");
        putenv("LC_ALL={$phpLocale}");
        setlocale(LC_ALL, $phpLocale, $shortLocale);
        setlocale(LC_MESSAGES, $phpLocale, $shortLocale);
        bindtextdomain('messages', resource_path('lang'));
        bind_textdomain_codeset('messages', 'UTF-8');
        textdomain('messages');

        return $next($request);
    }
}
