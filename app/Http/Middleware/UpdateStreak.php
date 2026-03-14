<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;
use Closure;
use App\Services\StreakService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateStreak
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        Log::info('UpdateStreak middleware triggered');

        
        if (auth()->check()) {
            StreakService::update(auth()->user()->fresh());
            auth()->setUser(auth()->user()->fresh());

            Log::info('Middleware refresh', [
                'id' => auth()->id(),
                'current_streak' => auth()->user()->current_streak,
            ]);
        }

        return $next($request);
    }
}
