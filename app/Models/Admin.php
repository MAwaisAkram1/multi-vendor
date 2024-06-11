<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;

class Admin extends Model implements Authenticatable
{
    use HasFactory;

    public function getAuthIdentifierName()
    {
        return 'id'; // Return the name of the primary key column
    }

    public function getAuthIdentifier()
    {
        return $this->getKey(); // Return the primary key value
    }

    public function getAuthPassword()
    {
        return $this->password; // Return the hashed password
    }

    public function getRememberToken()
    {
        return $this->remember_token; // Return the remember token (if applicable)
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value; // Set the remember token (if applicable)
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Return the name of the remember token column
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = ['email_verified_at' => 'datetime'];


    public static function registerAdmin($data) {
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public static function loginAdmin($data) {
        $admin = self::where('email', $data['email'])->first();
        if (!$admin || !Hash::check($data['password'], $admin->password)) {
            return null;
        }
        return $admin;
    }

    public function token() {
        return $this->morphMany(Token::class, 'tokenable');
    }
}
