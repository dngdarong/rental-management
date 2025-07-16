<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider; // Import RouteServiceProvider

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        // If the user has already verified their email,
        // redirect them to the intended admin dashboard.
        if ($request->user()->hasVerifiedEmail()) {
            // Changed redirect to use the admin dashboard route
            return redirect()->intended(route('admin.dashboard'));
        }

        // Otherwise, send the email verification notification.
        $request->user()->sendEmailVerificationNotification();

        // Redirect back with a status message indicating the link was sent.
        return back()->with('status', 'verification-link-sent');
    }
}

