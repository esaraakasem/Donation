<?php


namespace App\Http\Traits;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

trait ApiResponses
{
    protected $paginateNumber = 10;


    protected function apiResponse($data = null, $error = null, $code = 200)
    {

        if ($error != null)
        {
            $array = [
                'status' => in_array($code, $this->successCode()),
                'msg' => $error,
            ];
        }
        else
        {
            $array = [
                'status' => in_array($code, $this->successCode()),
                'data' => $data,
            ];
        }
        return response($array, 200);
    }

    protected function responseWithCode($data = null, $error = null, $code = 200)
    {

        if ($error != null) {
            $array = [
                'status' => in_array($code, $this->successCode()),
                'msg' => $error,
            ];
        } else {
            $array = [
                'status' => in_array($code, $this->successCode()),
                'data' => $data,
            ];
        }
        return response($array, $code);
    }

    protected function successCode()
    {
        return [
            200 , 201 , 202
        ];
    }

    protected function createdResponse($data)
    {
        return $this->apiResponse($data, null, 201);
    }

    protected function deleteResponse()
    {
        return $this->apiResponse(true, null, 200);
    }

    protected function notFoundResponse()
    {
        return $this->apiResponse(null, __('notifications.not_found'), 404);
    }

    protected function unAuthorized()
    {
        return $this->apiResponse(null, 'user is not unAuthorized !', 419);
    }

    protected function unKnowError()
    {
        return $this->apiResponse(null, 'Un know error', 520);
    }

    protected function apiValidation($request, $array)
    {

        $validate = Validator::make($request->all() , $array);

        $errors = [];

        if ($validate->fails()) {
            return $this->apiResponse(null, $validate->getMessageBag()->first(), 422);
        }

    }

    /**
     * Collection Paginate
     *
     * @param $items
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    protected function CollectionPaginate($items, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $this->paginateNumber), $items->count(), $this->paginateNumber, $page, $options);
    }


}