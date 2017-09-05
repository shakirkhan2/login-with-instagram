<?php
App::import('Controller', 'Instagram');
App::import('Controller', 'CloudVision');

class HomeController extends AppController {

  /**
   * Main index function
   *
   */
  public function index() {
    $instagramCode = $this->request->query('code');

    if (!empty($instagramCode) && !$this->isUserLoggedIn) {
      $result = $this->addUser($instagramCode);
      if (!$result) {
        $this->redirect('/');
      }
    }

    if (!$this->isUserLoggedIn) {
      $instagram = $this->getInstagramInstance();
      $this->set('loginURL', $instagram->getLoginUrl());
    } else {
      $userInfo = $this->Session->read('user');
      $this->set('userInfo', $userInfo);
    }
    
    $this->set('isUserLoggedIn', $this->isUserLoggedIn);
    $this->set('pageTitle', 'Test App - Login with Instagram');
  }

  /**
   * Get images fata to render on front end
   *
   * @return json object
   */
  public function getImagesData() {
    $status = false;
    $ajaxResult = null;

    if ($this->isUserLoggedIn) {
      $userInfo = $this->Session->read('user');
      
      $instagram = $this->getInstagramInstance();
      $instagram->setAccessToken((object) $userInfo);
      $userMedia = $instagram->getUserMedia($id = 'self', $limit = 30);
      $images = $this->getImages($userMedia);

      $vision = new CloudVision();
      $imagesChunks = array_chunk($images, 10);
      $preparedChunkData = array();

      foreach ($imagesChunks as $imagesChunk) {
        $result = $vision->detectLabelsBatch($imagesChunk);
        $preparedChunkData[] = $this->prepareImagesData($imagesChunk, $result);
      }

      $imagesData = array(
        'categories' => array(),
        'images' => array()
      );

      $categories = array();
      foreach ($preparedChunkData as $key => $preparedData) {
        $imagesData['categories'] = array_merge($imagesData['categories'], $preparedData['categories']);
        $imagesData['images'] = array_merge($imagesData['images'], $preparedData['images']);
      }
      
      $imagesData['categories'] = array_unique($imagesData['categories']);
      sort($imagesData['categories']);
      $this->set('imagesData', $imagesData);

      $ajaxResultView = new View($this);
      $ajaxResult = $ajaxResultView->render('ajaxResult', 'ajax');
      $status = true;
    }

    $this->set('json', ['status' => $status, 'html' => $ajaxResult]);
    $this->render('/Elements/json', 'ajax');
  }

  /**
   * Prepare Data Structure to use on front end
   *
   * @return array $images Array of images (Prepared Data of images)
   */
  private function prepareImagesData($images, $labeledImages) {
    $imagesData = array();
    $categories = array();

    foreach ($labeledImages as $index => $labeledImage) {
      $imageData = array();
      $imageData['labels'] = array();
      $imageData['url'] = $images[$index];

      foreach ($labeledImage->labels() as $labelData) {
        if ($labelData->score() >= 0.6) {
          $label = $labelData->description();

          if (!in_array($label, $categories)) {
            $categories[] = $label;
          }

          array_push($imageData['labels'], $label);
        }
      }

      $imagesData[] = $imageData;
    }

    sort($categories);
    return array(
      'categories' => $categories,
      'images' => $imagesData
    );
  }


  /**
   * Get all images URLs
   *
   * @return array $images Array of all image's url
   */
  private function getImages($userMedia) {
    $data = $userMedia->data;
    $images = array();

    foreach ($data as $media) {
      if (isset($media->carousel_media)) {
        foreach ($media->carousel_media as $cMedia) {
          $images[] = $cMedia->images->low_resolution->url;
        }

        continue;
      }

      if ($media->type !== 'video') {
        $images[] = $media->images->low_resolution->url;
      }
    }

    return $images;
  }

  /**
   * Get Instagram Instance
   *
   * @return object
   */
  private function getInstagramInstance() {
    $config = json_decode(file_get_contents('../Config/instagram_credentials.json'), true);
    $instagram = new Instagram($config);

    return $instagram;
  }

  /**
   * Add user function
   *
   * @return boolean
   */
  private function addUser($instagramCode) {
    $instagram = $this->getInstagramInstance();
    $data = $instagram->getOAuthToken($instagramCode);
    $code = isset($data->code) ? $data->code : 200;

    if ($code === 400) {
      return false;
    } else {
      $userData = $data->user;

      $userInfo = array(
        'username' => $userData->username,
        'name' => $userData->full_name,
        'bio' => $userData->bio,
        'website' => $userData->website,
        'instagram_id' => $userData->id,
        'profile_picture' => $userData->profile_picture,
        'access_token' => $data->access_token
      );

      $this->loadModel('User');
      $userInfo = $this->User->addUser($userInfo);

      $this->Session->write('user', $userInfo);
      $this->isUserLoggedIn = true;
      return true;
    }
  }
}