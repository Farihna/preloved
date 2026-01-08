<?
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('failed', 'Please login first');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $role = session()->get('role');
        
        // Check if user has required role
        if ($arguments && !in_array($role, $arguments)) {
            return redirect()->to('/')->with('failed', 'Access denied');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}


// ============================================
// REGISTER FILTERS
// File: app/Config/Filters.php
// ============================================
/* 

public $aliases = [
    'csrf'          => \CodeIgniter\Filters\CSRF::class,
    'toolbar'       => \CodeIgniter\Filters\DebugToolbar::class,
    'honeypot'      => \CodeIgniter\Filters\Honeypot::class,
    'invalidchars'  => \CodeIgniter\Filters\InvalidChars::class,
    'secureheaders' => \CodeIgniter\Filters\SecureHeaders::class,
    'auth'          => \App\Filters\AuthFilter::class,
    'role'          => \App\Filters\RoleFilter::class,
];

public $globals = [
    'before' => [
        // 'honeypot',
        // 'csrf',
        // 'invalidchars',
    ],
    'after' => [
        'toolbar',
        // 'honeypot',
        // 'secureheaders',
    ],
];
*/