<?php if (!empty($imagesData['categories'])) { ?>
  <ul class="all-categories">
    <li data-group="all" class="selected js-category">show all images</li>
    <?php foreach ($imagesData['categories'] as $category) { ?>
      <li data-group="<?php echo $category ?>" class="js-category"><?php echo $category ?></li>
    <?php } ?>
  </ul>
<?php } ?>
<?php if (!empty($imagesData['images'])) { ?>
  <div class="images js-images">
    <?php foreach ($imagesData['images'] as $image) {
      $labels = $image['labels'];
      $group =  '"' . implode('", "', $labels) . '"'; ?>
      <img class="img" src="<?php echo $image['url'] ?>" data-groups='[<?php echo $group ?>]'>
    <?php } ?>
  </div>
<?php } ?>