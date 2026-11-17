<?php

namespace App\Support;

use Illuminate\Support\Facades\Session;

/**
 * PHPFlasher Support Class for Laravel.
 * Provides the official PHPFlasher API with Google Material Design theme by default.
 */
class Flasher
{
    /**
     * Active theme name. Defaults to configured theme.google.
     */
    protected string $currentTheme = 'theme.google';

    /**
     * Current chain options.
     */
    protected array $currentOptions = [];

    /**
     * Current chain title.
     */
    protected ?string $currentTitle = null;

    /**
     * In-memory envelopes created during the current request lifecycle.
     */
    protected array $currentRequestEnvelopes = [];

    /**
     * Session storage key for envelopes.
     */
    public const SESSION_KEY = 'flasher_envelopes';

    public function __construct()
    {
        $this->currentTheme = config('flasher.default', 'theme.google');
    }

    /**
     * Switch theme fluently (e.g., flash()->use('theme.google')->success(...)).
     */
    public function use(string $theme): self
    {
        $this->currentTheme = $theme;
        return $this;
    }

    /**
     * Set a notification title fluently.
     */
    public function title(string $title): self
    {
        $this->currentTitle = $title;
        return $this;
    }

    /**
     * Set notification options fluently.
     */
    public function options(array $options): self
    {
        $this->currentOptions = array_merge($this->currentOptions, $options);
        return $this;
    }

    /**
     * Normalize arguments whether caller used:
     * - ($message, $title, $options)
     * - ($message, $options, $title)
     * - ($message, $options)
     * - ($message, $title)
     */
    protected function normalizeFlashArgs(array|string|null $arg2, array|string|null $arg3): array
    {
        $title = null;
        $options = [];

        if (is_array($arg2)) {
            $options = $arg2;
            if (is_string($arg3)) {
                $title = $arg3;
            } elseif (isset($options['title'])) {
                $title = (string) $options['title'];
                unset($options['title']);
            }
        } elseif (is_string($arg2)) {
            $title = $arg2;
            if (is_array($arg3)) {
                $options = $arg3;
            }
        } elseif (is_string($arg3)) {
            $title = $arg3;
        } elseif (is_array($arg3)) {
            $options = $arg3;
        }

        return [$title, $options];
    }

    /**
     * Flash a success notification.
     */
    public function success(string $message, array|string|null $title = null, array|string|null $options = []): self
    {
        [$resolvedTitle, $resolvedOptions] = $this->normalizeFlashArgs($title, $options);
        return $this->addFlash('success', $message, $resolvedTitle, $resolvedOptions);
    }

    /**
     * Flash an error notification.
     */
    public function error(string $message, array|string|null $title = null, array|string|null $options = []): self
    {
        [$resolvedTitle, $resolvedOptions] = $this->normalizeFlashArgs($title, $options);
        return $this->addFlash('error', $message, $resolvedTitle, $resolvedOptions);
    }

    /**
     * Flash a warning notification.
     */
    public function warning(string $message, array|string|null $title = null, array|string|null $options = []): self
    {
        [$resolvedTitle, $resolvedOptions] = $this->normalizeFlashArgs($title, $options);
        return $this->addFlash('warning', $message, $resolvedTitle, $resolvedOptions);
    }

    /**
     * Flash an info notification.
     */
    public function info(string $message, array|string|null $title = null, array|string|null $options = []): self
    {
        [$resolvedTitle, $resolvedOptions] = $this->normalizeFlashArgs($title, $options);
        return $this->addFlash('info', $message, $resolvedTitle, $resolvedOptions);
    }

    /**
     * Alias for success notification.
     */
    public function addSuccess(string $message, array|string|null $title = null, array|string|null $options = []): self
    {
        return $this->success($message, $title, $options);
    }

    /**
     * Alias for error notification.
     */
    public function addError(string $message, array|string|null $title = null, array|string|null $options = []): self
    {
        return $this->error($message, $title, $options);
    }

    /**
     * Alias for warning notification.
     */
    public function addWarning(string $message, array|string|null $title = null, array|string|null $options = []): self
    {
        return $this->warning($message, $title, $options);
    }

    /**
     * Alias for info notification.
     */
    public function addInfo(string $message, array|string|null $title = null, array|string|null $options = []): self
    {
        return $this->info($message, $title, $options);
    }

    /**
     * Add notification envelope to session flash storage and in-memory list.
     */
    public function addFlash(string $type, string $message, array|string|null $title = null, array|string|null $options = []): self
    {
        [$resolvedTitle, $resolvedOptions] = $this->normalizeFlashArgs($title, $options);
        $theme = $this->currentTheme ?? config('flasher.default', 'theme.google');
        $resolvedTitle = $resolvedTitle ?? $this->currentTitle;
        $mergedOptions = array_merge(
            config("flasher.themes.{$theme}.options", [
                'timeout' => 5000,
                'position' => 'top-right',
                'progressBar' => true,
                'ripple' => true,
            ]),
            $this->currentOptions,
            $resolvedOptions
        );

        $envelope = [
            'id' => 'flasher_' . uniqid('', true),
            'type' => $type,
            'message' => $message,
            'title' => $resolvedTitle,
            'options' => $mergedOptions,
            'theme' => $theme,
            'created_at' => microtime(true),
        ];

        // Store in memory for immediate views in the same request
        $this->currentRequestEnvelopes[] = $envelope;

        // Store in session flash for redirects
        $envelopes = Session::get(self::SESSION_KEY, []);
        $envelopes[] = $envelope;
        Session::flash(self::SESSION_KEY, $envelopes);

        // Reset temporary fluent chain state
        $this->currentTitle = null;
        $this->currentOptions = [];

        return $this;
    }

    /**
     * Retrieve all envelopes. Ensures each action produces strictly ONE notification.
     */
    public function getMessages(): array
    {
        $sessionEnvelopes = Session::get(self::SESSION_KEY, []);
        if (!is_array($sessionEnvelopes)) {
            $sessionEnvelopes = [];
        }

        // Combine session envelopes and current request envelopes
        $all = array_merge($sessionEnvelopes, $this->currentRequestEnvelopes);

        // Deduplicate envelopes by unique ID and unique message text
        $unique = [];
        $seenMessages = [];

        foreach ($all as $env) {
            if (!isset($env['message'])) {
                continue;
            }
            $norm = strtolower(trim($env['message']));
            if (!in_array($norm, $seenMessages)) {
                $unique[] = $env;
                $seenMessages[] = $norm;
            }
        }

        $envelopes = $unique;

        // ONLY fallback to auto-mapping generic session keys if NO explicit flasher envelope exists
        if (empty($envelopes) && config('flasher.auto_render', true)) {
            $flashBag = config('flasher.flash_bag', [
                'success' => ['success', 'profile_success', 'email_success', 'password_success'],
                'error' => ['error', 'danger'],
                'warning' => ['warning', 'email_info'],
                'info' => ['info', 'status', 'message'],
            ]);

            foreach ($flashBag as $type => $keys) {
                foreach ($keys as $key) {
                    if (Session::has($key)) {
                        $val = Session::get($key);
                        if (is_string($val) && trim($val) !== '') {
                            $envelopes[] = [
                                'id' => 'flasher_' . uniqid('', true),
                                'type' => $type,
                                'message' => $val,
                                'title' => ucfirst($type),
                                'options' => config("flasher.themes.theme.google.options", [
                                    'timeout' => 5000,
                                    'position' => 'top-right',
                                    'progressBar' => true,
                                    'ripple' => true,
                                ]),
                                'theme' => 'theme.google',
                                'created_at' => microtime(true),
                            ];
                            break 2; // Only emit ONE single fallback notification
                        }
                    }
                }
            }
        }

        return $envelopes;
    }

    /**
     * Static method proxy for convenient calls like Flasher::success('...').
     */
    public static function __callStatic(string $method, array $arguments)
    {
        $instance = app(self::class);
        return $instance->$method(...$arguments);
    }
}
