<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
        'single_error' => 'App\Views\errors\form_validation',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public array $register = [
        'name'              => 'required|max_length[60]',
        'email'             => 'required|valid_email|is_unique[users.email]',
        'phoneNumber'       => 'required|numeric|max_length[13]',
        'password'          => 'required|min_length[8]|max_length[255]',
        'retypePassword'    => 'required|max_length[255]|matches[password]',
        'kecamatan'         => 'required|numeric',
    ];

    public array $register_errors = [
        'name' => [
            'required'      => 'Nama harus diisi',
            'max_length'    => 'Nama tidak boleh lebih dari 60 karakter',
        ],
        'email' => [
            'required'      => 'Email harus diisi',
            'valid_email'   => 'Email tidak valid',
            'is_unique'     => 'Email sudah terdaftar',
        ],
        'phoneNumber' => [
            'required'      => 'Nomor telepon harus diisi',
            'numeric'       => 'Nomor telepon harus berupa angka',
            'max_length'    => 'Nomor telepon tidak boleh lebih dari 13 karakter',
        ],
        'password' => [
            'required'      => 'Password harus diisi',
            'min_length'    => 'Password minimal 8 karakter',
            'max_length'    => 'Password tidak boleh lebih dari 255 karakter',
        ],
        'retypePassword' => [
            'required'      => 'Password harus diisi',
            'max_length'    => 'Password tidak boleh lebih dari 255 karakter',
            'matches'       => 'Password tidak sama',
        ],
        'kecamatan' => [
            'required'      => 'Kecamatan harus diisi',
            'numeric'       => 'Kecamatan harus berupa angka',
        ],
    ];
}
