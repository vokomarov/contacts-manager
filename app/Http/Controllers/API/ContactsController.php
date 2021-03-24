<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\UpdateRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Bouncer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        if (Bouncer::cannot('read-contacts')) {
            return $this->forbidden();
        }

        return ContactResource::collection(Contact::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Contact\StoreRequest  $request
     * @return \App\Http\Resources\ContactResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        if (Bouncer::cannot('create-contacts')) {
            return $this->forbidden();
        }

        $user = Auth::user();

        try {
            $contact = $user->contacts()->create($request->only([
                'name',
                'lastname',
                'email',
                'company_name',
                'company_job_title',
            ]));

            return new ContactResource($contact);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Unable to create contact. Please try again later.',
                'error' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \App\Http\Resources\ContactResource|\Illuminate\Http\JsonResponse
     */
    public function show(Contact $contact)
    {
        if (Bouncer::cannot('read-contacts')) {
            return $this->forbidden();
        }

        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Contact  $contact
     * @param  \App\Http\Requests\Contact\UpdateRequest  $request
     * @return \App\Http\Resources\ContactResource|\Illuminate\Http\JsonResponse
     */
    public function update(Contact $contact, UpdateRequest $request)
    {
        if (Bouncer::cannot('update-contacts')) {
            return $this->forbidden();
        }

        $contact->fill($request->only([
            'name',
            'lastname',
            'email',
            'company_name',
            'company_job_title',
        ]));

        try {
            $contact->save();
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Unable to update contact. Please try again later.',
                'error' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Contact $contact)
    {
        if (Bouncer::cannot('delete-contacts')) {
            return $this->forbidden();
        }

        try {
            $contact->delete();
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Unable to delete contact. Please try again later.',
                'error' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Contact has been deleted.',
        ]);
    }
}
