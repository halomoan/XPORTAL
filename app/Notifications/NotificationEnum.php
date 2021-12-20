<?php

namespace App\Notifications;

interface NotificationEnum {

    const SUCCESS = 'success';
    const WARNING = 'warning';
    const INFO = 'info';
    const ERROR = 'danger';
    const ALERT = 'exclamation';
}
