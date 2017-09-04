<?php

class User extends AppModel {
  public function addUser($userInfo) {
    return $this->save(array(
      'User' => $userInfo
    ))['User'];
  }
}