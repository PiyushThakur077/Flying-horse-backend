<?php

namespace App\Helpers;
use Edujugon\PushNotification\PushNotification;


/**  
 * 
 *  helper class to send push notification to specified user 
 *   // $data = [
    //     'job_id' =>$request->job_id,
    //     'message' => 'Indent '.$job->indent->indent_number .'Has Been Rejected By System'
    // ];
    // fcm()->Notify('Indent '.$job->indent->indent_number .'Has Been Rejected By System', $data, $user->reg_id);
 *
*/

    
class Notify
{

    /**
     * 
     *  send push notification to specified user 
     *  @param string $message the text message to be displayed to the user
     *  @param mixed $token the registration id of user device
     *  @param array $data  contains data to be send along with notification
     * 
     */
    public function Notify(string $message,array $data,$token){
        
        $push = new PushNotification();
        $push->setService('fcm')
            ->setMessage([
                'notification' => [
                    'title'=>'Payment App',
                    'body'=>$message,
                    'sound' => 'default'
                ],
                'data' => $data,
            ])
            ->setDevicesToken($token)
            ->send()
            ->getFeedback();
    }

    /**
     * 
     *  send push notification to all the specified user's 
     *  @param array $token the registration id's of user device
     *  @param array $data  contains data to be send along with notification
     * 
     */
    public function NotifyAll(array $data,array $token){
        $length=count($data);
        $i=0;
        $push = new PushNotification();
        while($i<$length){
            $push->setService('fcm')
            ->setMessage([
                'notification' => [
                    'title'=>'Payment App',
                    'body'=>'You have a new notification',
                    'sound' => 'default'
                ],
                'data' => $data[$i],
            ])
            ->setDevicesToken($token[$i])
            ->send()
            ->getFeedback();
            $i++;
        }
    }
}
