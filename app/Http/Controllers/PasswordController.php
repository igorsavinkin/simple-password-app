<?php

namespace App\Http\Controllers;

use App\Models\Password;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function index()
    {
        return view('password.index');
    }

    public function generate(Request $request)
    {
        $length = (int) $request->input('length', 8);
        $useNumbers = $request->has('numbers');
        $useBigLetters = $request->has('big_letters');
        $useSmallLetters = $request->has('small_letters');

        $characters = '';
        $set_characters = [];
        if ($useNumbers) {
            $set_characters[] = '0123456789';
        }
        if ($useBigLetters) {
            $set_characters[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if ($useSmallLetters) {
            $set_characters[] = 'abcdefghijklmnopqrstuvwxyz';
        }

        if (empty($set_characters)) {
            $set_characters[] = 'abcdefghijklmnopqrstuvwxyz';
        }

        // Generate unique password (retry if exists in DB)
        $maxAttempts = 100;
        $attempts = 0;
        
        do {
            $password = $this->generatePassword($set_characters, $length);
            $exists = Password::where('value', $password)->exists();
            $attempts++;
        } while ($exists && $attempts < $maxAttempts);

        if ($exists){
            return view('password.index', [
                'password' => null,
                'length' => $length,
                'numbers' => $useNumbers,
                'big_letters' => $useBigLetters,
                'small_letters' => $useSmallLetters,
            ]);
        }
        Password::create(['value' => $password]);

        return view('password.index', [
            'password' => $password,
            'length' => $length,
            'numbers' => $useNumbers,
            'big_letters' => $useBigLetters,
            'small_letters' => $useSmallLetters,
        ]);
    }

    private function generatePassword(array $set_characters, int $length): string
    {
        $password = '';
        $charactersLength = count($set_characters); 
        for ($i = 0; $i < $length; $i++) {
            $index = $i % $charactersLength;
            $password .= $set_characters[$index][random_int(0, strlen($set_characters[$index]) - 1)];
        }
        return $password;
    }
}
