<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider; // Import RouteServiceProvider (good practice, though not directly used in this specific redirect)

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // If the user has already verified their email,
        // redirect them to the intended admin dashboard.
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('admin.dashboard')) // Changed redirect to admin.dashboard
            : view('auth.verify-email'); // Otherwise, show the verification prompt view
    }
}

