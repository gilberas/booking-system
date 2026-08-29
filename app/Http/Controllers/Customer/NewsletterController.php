<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $subscriber = NewsletterSubscriber::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'is_active' => true,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]
        );

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }

    public function unsubscribe(Request $request)
    {
        $subscriber = NewsletterSubscriber::where('email', $request->email)->first();

        if ($subscriber) {
            $subscriber->update([
                'is_active' => false,
                'unsubscribed_at' => now(),
            ]);
        }

        return back()->with('success', 'You have been unsubscribed from our newsletter.');
    }
}
