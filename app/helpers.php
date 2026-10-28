<?php

use App\Support\Flasher;

if (!function_exists('flash')) {
    /**
     * PHPFlasher global helper.
     *
     * @param string|null $message
     * @param string $type ('success'|'error'|'warning'|'info')
     * @param string|null $title
     * @param array $options
     * @return \App\Support\Flasher
     */
    function flash(?string $message = null, string $type = 'success', ?string $title = null, array $options = []): Flasher
    {
        $flasher = app(Flasher::class);

        if ($message !== null) {
            $flasher->addFlash($type, $message, $title, $options);
        }

        return $flasher;
    }
}
