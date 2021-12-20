<?php

namespace App\Traits;

use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifyUser;

trait NotifiyUserTrait
{

//   static $success = 'success';
//   static $warning = 'warning';
//   static $info = 'info';
//   static $danger = 'danger';
//   static $exclamation = 'exclamation';


  public function AlertUser($users, $group,$message,$type = 'info')
  {

    $usermsg = [
            'group' => $group,
            'type' => $type,
            'message' => $message
    ];
    Notification::send($users, new NotifyUser($usermsg));
    return true;
  }
}
