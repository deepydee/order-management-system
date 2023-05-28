<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RegisterPasswords extends Component
{
    public string $password = '';
    public string $passwordConfirmation = '';

    public function render()
    {
        return view('livewire.register-passwords');
    }

    public function generatePassword(): void
    {
        $lowercase = range('a', 'z');
        $uppercase = range('A', 'Z');
        $digits = range(0, 9);
        $special = ['!', '@', '#', '$', '%', '^', '*'];
        $chars = array_merge($lowercase, $uppercase, $digits, $special);
        $length = 12;

        do {
            $password = [];

            for ($i = 0; $i <= $length; $i++) {
                $int = rand(0, count($chars) - 1);
                $password[] = $chars[$int];
            }

        } while (empty(array_intersect($special, $password)));

        $this->setPasswords(implode('', $password));
    }

    private function setPasswords($value): void
    {
        $this->password = $value;
        $this->passwordConfirmation = $value;
    }
}
