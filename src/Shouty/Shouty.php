<?php

namespace Shouty;

class Shouty {
  const MESSAGE_RANGE = 1000;

  private $locationsByPersonName = [];
  private $messagesByPersonName = [];

  public function setLocation($personName, $location) {
    $this->locationsByPersonName[$personName] = $location;
  }

  public function shout($shouterName, $message) {
    $this->messagesByPersonName[$shouterName] = $message;
  }

  public function getMessagesHeardBy($listenerName) {
    $result = [];

    foreach ($this->messagesByPersonName as $shouterName => $message) {
      $distance = $this->locationsByPersonName[$listenerName]->distanceFrom($this->locationsByPersonName[$shouterName]);
      if ($distance < self::MESSAGE_RANGE && $listenerName != $shouterName)
        $result[$shouterName] = $message;
    }
    return $result;
  }
}
