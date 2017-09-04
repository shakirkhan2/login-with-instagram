<?php

require  '../vendor/autoload.php';
use Google\Cloud\Vision\VisionClient;

class CloudVision {

  public function detectLabels($path) {
    $vision = new VisionClient([
      'keyFilePath' => '../Config/credentials.json'
    ]);

    $image = $vision->image(file_get_contents($path), ['LABEL_DETECTION']);
    $result = $vision->annotate($image);

    return $result;
  }

  public function detectLabelsBatch($imagesURL) {
    $vision = new VisionClient([
      'keyFilePath' => '../Config/google_credentials.json'
    ]);

    $imagesContent = array();
    foreach ($imagesURL as  $image) {
      $imagesContent[] = file_get_contents($image);
    }
    
    $images = $vision->images($imagesContent, ['LABEL_DETECTION']);
    $result = $vision->annotateBatch($images);

    return $result;
  }
}