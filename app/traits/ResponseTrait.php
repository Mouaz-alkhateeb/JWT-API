<?php

namespace App\traits;


trait ResponseTrait
{
    public function ErrorResponse($errNum, $msg)
    {
        return response()->json([
            'status' => false,
            'errNum' => $errNum,
            'msg' => $msg
        ]);
    }
    public function SuccesResponse($errNum, $msg, $key, $value)
    {
        return response()->json([
            'status' => true,
            'errNum' => $errNum,
            'msg' => $msg,
            $key => $value
        ]);
    }

    public function changeStatus($errNum, $msg)
    {
        return response()->json([
            'status' => true,
            'errNum' => $errNum,
            'msg' => $msg,
        ]);
    }
    
    public function returnValidationError($code = "E001", $validator)
    {
        return $this->ErrorResponse($code, $validator->errors()->first());
    }


    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }
    public function getErrorCode($input)
    {
        if ($input == "name")
            return 'E0011';

        else if ($input == "password")
            return 'E002';

        else if ($input == "id")
            return 'E013';

        else if ($input == "email")
            return 'E015';

        else
            return "";
    }
}
