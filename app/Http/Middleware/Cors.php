<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $IlluminateResponse = 'Illuminate\Http\Response';
        $SymfonyResopnse = 'Symfony\Component\HttpFoundation\Response';
        $allowedOrigins = ['http://localhost:3000','https://sandbox.smavio.de', 'http://109.239.57.250:3000', 'http://localhost:8100', 'capacitor-electron://-','http://localhost:8080', 'http://next.appmate.in', 'http://localhost:53427','http://127.0.0.1:8000', 'http://109.239.57.250', 'http://smavio.de', 'http://localhost:4200', 'http://localhost:4200/','https://smavio.de', 'https://service.smavio.de', 'https://dashboard.stripe.com', 'https://smn.vercel.app', 'https://service-backend.smavio.de', '*'];
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*';
//        dd($origin);
        $headers = [
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Origin' => $origin,
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Authorization , Access-Control-Request-Headers, X-XSRF-TOKEN'
        ];

        if (in_array($origin, $allowedOrigins)) {
            if($response instanceof $IlluminateResponse) {
                foreach ($headers as $key => $value) {
                    $response->header($key, $value);
                }
                return $response;
            }

            if($response instanceof $SymfonyResopnse) {
                foreach ($headers as $key => $value) {
                    $response->headers->set($key, $value);
                }
                return $response;
            }

            return $response;

        }

        return $next($request);
    }
}
