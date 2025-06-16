<?php

namespace App\Exceptions;

use Exception;

class RoleHasUsersException extends Exception
{
    public function __construct(string $message = "Cannot delete role because it has users attached", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        // No need to report this exception as it's an expected validation error
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request)
    {
        if ($request->wantsJson() || $request->inertia()) {
            return back()->withErrors(['role' => $this->getMessage()]);
        }

        return back()->withErrors(['role' => $this->getMessage()]);
    }
}
