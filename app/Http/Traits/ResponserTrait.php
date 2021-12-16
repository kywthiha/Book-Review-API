<?php

namespace App\Http\Traits;

use Illuminate\Http\Response;

trait ResponserTrait
{

    public function respondCollection($message, $data)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data,
        ], Response::HTTP_OK);
    }


    protected function respondPermissionDenied()
    {
        return response()->json([
            'code' => Response::HTTP_FORBIDDEN,
            'message' => 'Permission denied',
        ], Response::HTTP_FORBIDDEN);
    }

    protected function respondUnautorized()
    {
        return response()->json([
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => 'UNAUTHORIZED',
        ], Response::HTTP_UNAUTHORIZED);
    }


    public function respondSuccessMsgOnly($message)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
        ], Response::HTTP_OK);
    }
}
