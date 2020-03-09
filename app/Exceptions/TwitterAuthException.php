<?php

namespace App\Exceptions;

use Exception;

/**
 * TwitterAuthException
 * Custom Social exception for Twitter 
 */
class TwitterAuthException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->view(
                'errors.twitter',
                array(
                    'exception' => $this
                )
        );
    }
}
