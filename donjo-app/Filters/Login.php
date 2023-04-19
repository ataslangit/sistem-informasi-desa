<?php

namespace App\Filters;

use App\Models\User_model;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Login implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $userModel = new User_model();
        if (session()->has('sesi')) {
            $grup = $userModel->sesi_grup(session()->get('sesi'));
        }

        if ($arguments !== null && is_array($arguments)) {
            if ($arguments === ['view']) {
                if (session()->get('loggedIn')) {
                    switch ($grup) {
                        case 1:
                        case 2:
                            return redirect()->route('admin.dashboard');
                            break;

                        case 3:
                        case 4:
                            return redirect()->to('web');
                            break;
                    }
                } else {
                    return;
                }
            }

            if ($arguments === ['admin']) {
                if (session()->get('loggedIn')) {
                    switch ($grup) {
                        case 3:
                        case 4:
                            return redirect()->to('web');
                            break;
                    }
                } else {
                    return redirect()->route('login.view');
                }
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
