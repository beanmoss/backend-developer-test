<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait RestControllerTrait
{

    public function index()
    {
        $m = self::MODEL;
        return $this->listResponse($m::simplePaginate(10));
    }

    public function show($id)
    {
        $m = self::MODEL;
        if($data = $m::find($id))
        {
            return $this->showResponse($data);
        }
        return $this->notFoundResponse();
    }

    public function store(Request $request)
    {
        $m = self::MODEL;
        try
        {

            if(method_exists($this, 'beforeStore'))
            {
                $this->beforeStore();
            }
            $v = \Validator::make($request->all(), $this->validationRules);

            if($v->fails())
            {
                throw new \Exception("ValidationException");
            }
            $data = $m::create(\Request::all());
            return $this->createdResponse($data);
        }catch(\Exception $ex)
        {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }

    }

    public function update($id)
    {
        $m = self::MODEL;

        if(!$data = $m::find($id))
        {
            return $this->notFoundResponse();
        }

        try
        {
            if(method_exists($this, 'beforeUpdate'))
            {
                $this->beforeUpdate($data);
            }
            $v = \Validator::make(\Request::all(), $this->validationRules);

            if($v->fails())
            {
                throw new \Exception("ValidationException");
            }
            $data->fill(\Request::all());
            $data->save();
            return $this->showResponse($data);
        }catch(\Exception $ex)
        {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
    }

    public function destroy($id)
    {
        $m = self::MODEL;
        if(!$data = $m::find($id))
        {
            return $this->notFoundResponse();
        }
        $data->delete();
        return $this->deletedResponse();
    }

    protected function createdResponse($data)
    {
        $response = [
            'code' => 201,
            'status' => 'succcess',
            'data' => $data
        ];
        return response()->json($response, $response['code']);
    }

    protected function showResponse($data)
    {
        $response = [
            'code' => 200,
            'status' => 'succcess',
            'data' => $data
        ];
        return response()->json($response, $response['code']);
    }

    protected function listResponse($data)
    {
        $response = [
            'code' => 200,
            'status' => 'succcess',
            'data' => $data->toArray()
        ];
        return response()->json($response, $response['code']);
    }

    protected function notFoundResponse()
    {
        $response = [
            'code' => 404,
            'status' => 'error',
            'data' => 'Resource Not Found',
            'message' => 'Not Found'
        ];
        return response()->json($response, $response['code']);
    }

    protected function deletedResponse()
    {
        $response = [
            'code' => 204,
            'status' => 'success',
            'data' => [],
            'message' => 'Resource deleted'
        ];
        return response()->json($response, $response['code']);
    }

    protected function clientErrorResponse($data)
    {
        $response = [
            'code' => 422,
            'status' => 'error',
            'data' => $data,
            'message' => 'Unprocessable entity'
        ];
        return response()->json($response, $response['code']);
    }

}