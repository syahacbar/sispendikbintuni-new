<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\SysSetting;
use Illuminate\Support\Facades\Http;

class StorePengaduanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $recaptcha_pengaduan_enabled = SysSetting::getValue('recaptcha_pengaduan_enabled', false);

        $rules = [
            'judul_laporan' => 'required|string|max:255',
            'nama_pelapor' => 'required|string|max:100',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'kategori' => 'required|string',
            'isi' => 'required|string',
            'dok_lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
        ];

        if ($recaptcha_pengaduan_enabled) {
            $rules['g-recaptcha-response'] = [
                'required',
                function ($attribute, $value, $fail) {
                    $secret = SysSetting::getValue('recaptcha_secret_key');
                    if (empty($secret))
                        return;

                    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret' => $secret,
                        'response' => $value,
                    ]);

                    if (!$response->json('success')) {
                        $fail('Validasi reCAPTCHA gagal. Silakan coba lagi.');
                    }
                },
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'judul_laporan.required' => 'Judul laporan wajib diisi.',
            'judul_laporan.max' => 'Judul laporan tidak boleh lebih dari 255 karakter.',
            'nama_pelapor.required' => 'Nama pelapor wajib diisi.',
            'nama_pelapor.max' => 'Nama pelapor tidak boleh lebih dari 100 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'no_hp.required' => 'Nomor HP/WA wajib diisi.',
            'no_hp.max' => 'Nomor HP/WA tidak boleh lebih dari 20 karakter.',
            'kategori.required' => 'Kategori pengaduan wajib dipilih.',
            'isi.required' => 'Isi pengaduan wajib diisi.',
            'dok_lampiran.file' => 'Lampiran harus berupa file.',
            'dok_lampiran.mimes' => 'Format file lampiran harus: jpg, jpeg, png, pdf, atau docx.',
            'dok_lampiran.max' => 'Ukuran file lampiran maksimal 2MB.',
            'g-recaptcha-response.required' => 'Silakan selesaikan validasi reCAPTCHA.',
        ];
    }
}
