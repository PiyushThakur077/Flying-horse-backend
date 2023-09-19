<?php 



if (!function_exists('fcm')) {
    /**
     * 
     *Either  Create a new instance of Notify Helper 
     *Or return already created instance
     * 
     */
    function fcm(){
        return app('\App\Helpers\Notify');
    }
}