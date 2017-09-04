<header class="header">
  <h1>Test App - Login with Instagram</h1>
  <?php if ($isUserLoggedIn) { ?>
    <div class="user-info">
      <img class="profile-picture" src="<?php echo $userInfo['profile_picture']; ?>" alt="Profile picture">
      <strong class="user-name"><?php echo $userInfo['name']; ?></strong>
      <span class="logout-btn js-logout-btn">Log out</span>
    </div>
  <?php } ?>
</header>
<div class="content js-content" data-logged-in="<?php echo $isUserLoggedIn ?>">
  <?php if (!$isUserLoggedIn) { ?>
    <a href="<?php echo $loginURL ?>" class="btn btn-large btn-green-outline login-btn">Login with Instagram</a>
  <?php } else { ?>
    <i class="loader js-loader"></i>
  <?php } ?>
</div>