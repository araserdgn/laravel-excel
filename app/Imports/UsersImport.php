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

    public function onError(\Throwable $e)
    {
        throw new ValidationException($e->validator);
    }
}
