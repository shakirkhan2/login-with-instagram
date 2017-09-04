<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo isset($pageTitle) ? $pageTitle : $this->fetch('title'); ?></title>
  <?php echo $this->Html->charset(); ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
  <meta name="google" content="notranslate">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>

<body class="body">
  <div class="container">
    <?php echo $this->fetch('content'); ?>
  </div>

  <?php
    echo $this->Html->css(array('app', 'reset'));
    echo $this->Html->script('app');
  ?>
</body>
</html>