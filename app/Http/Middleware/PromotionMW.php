<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PromotionMW
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        echo <<<HTML
        <style>
            .promotion-banner {
                background: linear-gradient(90deg, #0d0d0d 0%, #1a1a1a 50%, #0d0d0d 100%);
                border-bottom: 3px solid #d4af37;
                padding: 18px 0;
                overflow: hidden;
                position: relative;
                z-index: 9999;
                width: 100%;
                margin: 0;
                box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
            }

            .promotion-content {
                display: flex;
                animation: scrollLeft 25s linear infinite;
                font-size: 24px;
                font-weight: bold;
                color: #d4af37;
                text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8), 0 0 10px rgba(212, 175, 55, 0.3);
                letter-spacing: 3px;
                white-space: nowrap;
                padding: 0 100%;
            }

            @keyframes scrollLeft {
                0% {
                    transform: translateX(0);
                }
                100% {
                    transform: translateX(-100%);
                }
            }

            .banner-text {
                display: inline-block;
                padding: 0 50px;
            }
        </style>
        <div class="promotion-banner">
            <div class="promotion-content">
                <span class="banner-text"> WELCOME TO LARAVEL DEVELOPMENT </span>
                <span class="banner-text"> WELCOME TO LARAVEL DEVELOPMENT </span>
                <span class="banner-text"> WELCOME TO LARAVEL DEVELOPMENT </span>
            </div>
        </div>
        HTML;
        return $next($request);
    }
}
