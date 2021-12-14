<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifyUser;

trait NotifiyUserTrait
{

  const success = 'success';
  const warning = 'warning';
  const info = 'info';
  const danger = 'danger';
  const exclamation = 'exclamation';


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
