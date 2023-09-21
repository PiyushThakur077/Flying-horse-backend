<?php
    
    namespace  App\Traits;
    
    use Illuminate\Http\JsonResponse;

    trait ApiResponse
    {

        public $LOG_RESPONSE = false;

        public $LOG_TITLE = 'API REQUEST LOG';

        

        /**
         * Send response to the user requesting api
         * @param  string $message  message to send in request
         * @param  mixed array|null $data   data to be sent in response
         * @param  integer $status represent status code
         * @return JsonResponse
         */
        protected function response($message,$data=null,$status=200)
        {
            $this->log($message, $data, $status,true);
            
            if($data)
            {
                return $this->responseWithData($message,$data,$status);
            }
            else
            {
                
                return response()->json([
                    'success'=>true,
                    'data' => null,
                    'message'=> __($message),
                    'status_code'=>$status
                ],$status);
            }
            
        }
        
        /**
         * Send response to the user requesting api
         * @param  string $message  message to send in request
         * @param  array  $data   data to be sent in response
         * @param  integer $status represent status code
         * @return JsonResponse
         */
        protected function responseWithData($message,$data,$status)
        {
            return response()->json([
                'data'=>$data,
                'success'=>true,
                'message'=> __($message),
                'status_code'=>$status
            ],$status);
        }
        
        /**
         * Send Failed response to the user requesting api
         * @param  string $message  message to send in request
         * @param  integer $status represent status code
         * @return JsonResponse
         */
        protected function failedResponse($message,$data=null,$status=400)
        {
            $this->log($message, $data, $status,false);

            if($data)
            {
                return $this->failedResponseWithData($message,$data,$status);
            }
            else
            {
                return response()->json([
                    'success'=>false,
                    'errors' => null,
                    'message'=> __($message),
                    'status_code'=>$status
                ],$status);
            }
            
        }
        
        /**
         * Send Failed response to the user requesting api
         * @param  string $message  message to send in request
         * @param  array  $data   data to be sent in response
         * @param  integer $status represent status code
         * @return JsonResponse
         */
        protected function failedResponseWithData($message,$data=null,$status=500)
        {
            return response()->json([
                'success'=>false,
                'errors'=>$data,
                'message'=> __($message),
                'status_code'=>$status
            ],$status);
            
        }

        /**
     * return error response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages))
            $response['data'] = $errorMessages;
        else
            $response['data'] = null;
        return response()->json($response, $code);
    }

/**
 * Send Log context for response and request function
 *
 * @param string $message
 * @param array $data
 * @param integer $status
 * @param boolean $success
 * @return void
 */
    public function log($message, $data, $status, $success)
    {
        if( $this->LOG_RESPONSE)
        {
            \Log::info($this->LOG_TITLE,  [
                'request' => request()->all(),
                'response' => [ 
                    'success'=>$success,
                    'data' => $data,
                    'message'=> __($message),
                    'status_code'=>$status
                ]
            ]);
        }
    }

    
        
}
