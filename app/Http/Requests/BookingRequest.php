<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jasa_id' => 'required|exists:jasas,id',
            'vendor_id' => 'required|exists:users,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'phone' => 'required|string|max:20|regex:/^08[0-9]{8,13}$/',
            'address' => 'required|string|min:10|max:500',
            'preferred_time' => 'nullable|string|in:pagi,siang,sore',
            'photos' => 'required|array|min:3',
            'photos.*' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'jasa_id.required' => 'Jasa tidak valid.',
            'jasa_id.exists' => 'Jasa tidak ditemukan.',
            'vendor_id.required' => 'Pilih talent/penyedia jasa.',
            'vendor_id.exists' => 'Talent tidak ditemukan.',
            'booking_date.required' => 'Tanggal booking wajib diisi.',
            'booking_date.after_or_equal' => 'Tanggal booking harus hari ini atau setelahnya.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Nomor telepon harus diawali 08 dan 10-15 digit.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.min' => 'Alamat minimal 10 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'preferred_time.in' => 'Waktu preferensi harus Pagi, Siang, atau Sore.',
            'photos.required' => 'Foto dokumentasi wajib diunggah.',
            'photos.min' => 'Minimal unggah 3 foto dokumentasi.',
            'photos.*.image' => 'File harus berupa gambar (JPG/PNG).',
            'photos.*.mimes' => 'Format foto harus JPG atau PNG.',
            'photos.*.max' => 'Ukuran foto maksimal 5MB per file.',
            'notes.max' => 'Catatan maksimal 500 karakter.',
        ];
    }
}
