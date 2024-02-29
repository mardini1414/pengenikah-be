<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Illuminate\Contracts\Validation\Validator;

class InvitationCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'heroImage' => 'required|max:255',
            'songId' => 'required|integer|min:1',
            'themeId' => 'required|max:20',
            'bride.name' => 'required|min:3|max:50',
            'bride.instagram' => 'required|min:3|max:50',
            'bride.image' => 'required|max:255',
            'bride.motherName' => 'required|min:3|max:50',
            'bride.fatherName' => 'required|min:3|max:50',
            'bride.address' => 'required|min:5|max:50',
            'groom.name' => 'required|min:3|max:50',
            'groom.instagram' => 'required|min:3|max:50',
            'groom.image' => 'required|max:255',
            'groom.motherName' => 'required|min:3|max:50',
            'groom.fatherName' => 'required|min:3|max:50',
            'groom.address' => 'required|min:5|max:50',
            'weddingCeremony.date' => 'required|date',
            'weddingCeremony.address' => 'required|min:5|max:50',
            'weddingCeremony.googleMap' => 'required|max:1000',
            'weddingReception.date' => 'required|date',
            'weddingReception.address' => 'required|min:5|max:50',
            'weddingReception.googleMap' => 'required|max:1000',
            'alsoInvites' => 'required|array',
            'alsoInvites.*.name' => 'required|min:3|max:50',
            'stories' => 'required|array',
            'stories.*.title' => 'required|min:5|max:50',
            'stories.*.text' => 'required|min:100|max:1000',
            'galleries' => 'required|array',
            'galleries.*.image' => 'required|max:255'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->getMessageBag()
        ], 400));
    }
}
