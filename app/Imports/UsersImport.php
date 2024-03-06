<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Hash;
use Maatwebsite\Excel\Validators\ValidationException;

class UsersImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'      => $row['name'],
            'email'     => $row['email'],
            'password'  => Hash::make($row['password']),
            'phone_no'  => $row['phone_number'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.email' => ['email', 'unique:users,email'],
            '*.name' => ['required', 'string', 'max:255'],
            '*.password' => ['required', 'string', 'min:6'],
            '*.phone_number' => ['required', 'max:15'],
        ];
    }

    // public function onError(\Throwable $e)
    // {
    //     throw new ValidationException($e->validator);
    // }


    public function customValidationMessages()
    {
        return [
            '*.email.email' => 'Lütfen geçerli bir e-posta adresi girin.',
            '*.email.unique' => 'Aynı olan e-posta adresi mevcuttur satırda.',
            '*.name.required' => 'Ad alanlarından birinde boşluk var.',
            '*.name.string' => 'Ad alanı bir metin olmalıdır.',
            '*.name.max' => 'Ad alanı en fazla :max karakter uzunluğunda olabilir.',
            '*.password.required' => 'Şifre alanı zorunludur.',
            '*.password.string' => 'Şifre alanı bir metin olmalıdır.',
            '*.password.min' => 'Şifre en az :min karakter uzunluğunda olmalıdır.',
            '*.phone_number.required' => 'Telefon numarası zorunludur.',
            '*.phone_number.max' => 'Telefon numarası en fazla :max karakter uzunluğunda olabilir.',
        ];

    }

    public function onError(\Throwable $e)
    {
        if ($e instanceof ValidationException) {
            // Validasyon hatası varsa, blade'e hataları gönder
            return redirect()->back()->withErrors($e->errors());
        }

        // Diğer türde bir hata varsa, blade'e genel bir hata mesajı gönder
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);

    }


}
