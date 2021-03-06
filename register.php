<?php
require_once 'init.php';
if ($currentUser) {
  header('Location: index.php');
  exit();
}
?>

<?php include 'header.php' ?>

<?php if (!(isset($_POST['email']) || isset($_POST['password']))) : ?>
 <div class="inner">
  <h2 class="mb-2">Đăng ký</h2>
    <form action="register.php" method="POST">
      <div class="form-group">
        <label for="displayName">Họ tên</label>
        <input type="text" class="form-control" id="displayName" name="displayName" placeholder="Họ tên">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email đăng nhập">
      </div>
      <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
      </div>
      <button type="submit" class="btn btn-success">Đăng ký</button>
    </form>
 </div>
<?php else : ?>
  <?php
    // fetch from data
    $displayName = $_POST['displayName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // check fields
    $errorPattern = "<div class='alert alert-danger' role='alert alert-dismissible fade show'>";
    $error = "";

    if (empty($email) || empty($password) || empty($displayName)) {
      $error .= $errorPattern . "Bạn phải nhập đủ dữ liệu!</div>";
    } else {
      $user = findUserByEmail($email);
      if ($user) {
        $error .= $errorPattern . "Tài khoản đã tồn tại!</div>";
      } else {
        $avatarImage = file_get_contents('./assets/images/default-avatar.jpg');
        $backgroundImage = file_get_contents('./assets/images/default-background.png');

        $newUserId = createUser($displayName, $email, $password, $avatarImage, $backgroundImage);
      }
    }
    ?>

  <?php if (!empty($error)) : ?>
    <?php echo $error; ?>
    <a href="./register.php" class="btn btn-light">Thử lại</a>
  <?php else : ?>
    <div class="alert alert-success">Vui lòng kiểm tra email để kích hoạt tài khoản!</div>
    <a href="./activate.php" class="btn btn-success">Kích hoạt tài khoản</a>
  <?php endif; ?>
  </div>
<?php endif; ?>

<?php include 'footer.php' ?>