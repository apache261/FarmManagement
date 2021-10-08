<?php

namespace App\Filters;

use CodeIgniter\Commands\Server\Serve;
use Config\Services;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Firebase\JWT\JWT;

class Auth implements FilterInterface
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
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
         helper('cookie');
        $key            = getenv('JWT_SECRET');
        $auth_header    = $request->getServer('HTTP_AUTHORIZATION');
       $token           = "empty";

        if(!$auth_header){
            return Services::response()
                                ->setJSON([
                                            'messages'=> ['error' => 'Missing Token']
                                        ])
                                -> setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
        #Check if the authorization code can be split into two items
        # throws error if the user only put the token w/out bearer method (no index 1)
        try{
            $token          = explode(' ',$auth_header)[1];
            
        }catch(Exception $err){
           
        }
       
        try{
            JWT::decode($token,$key,['HS256']);
        }catch(\Throwable $err){
            return Services::response()
                            ->setJSON([
                                'messages'=> ['error' => 'Invalid Token']
                            ])
                            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);

        }

    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
