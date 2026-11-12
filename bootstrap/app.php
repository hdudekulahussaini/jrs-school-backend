<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(function ($request, \Throwable $e) {
            return $request->is('api/*') || $request->expectsJson();
        });

        // Handle POST body too large (PHP upload_max_filesize / post_max_size exceeded)
        $exceptions->render(function (PostTooLargeException $e, $request) {
            $maxPost  = ini_get('post_max_size');
            $maxFile  = ini_get('upload_max_filesize');

            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Upload failed: total POST data exceeds the server limit ({$maxPost}). "
                               . "Each file must be under {$maxFile}.",
                ], 413);
            }

            return back()
                ->withInput($request->except(['images', 'image', 'gallery_images']))
                ->withErrors([
                    'images' => "The uploaded files are too large. Total POST size must not exceed {$maxPost}. "
                              . "Please upload fewer images at once, or reduce file sizes (each file max: {$maxFile}).",
                ]);
        });
    })->create();
