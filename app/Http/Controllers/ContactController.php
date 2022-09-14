<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    
    /**
     * The index function returns the view contactForm
     * 
     * @return The view contact.contactForm
     */
    public function index()
    {
        return view('contact.contactForm');
    }

    /**
     * The store function stores the data from the contact form in the database
     * 
     * @param Request $request The request object
     * 
     * @return The view contact.contactForm
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable|numeric',
            'subject' => 'required',
            'message' => 'required'
        ]);
  
        Contact::create($request->all());
  
        return redirect()->back()
                         ->with(['success' => 'Thank you for contact us. We will contact you soon.']);
    }
}
