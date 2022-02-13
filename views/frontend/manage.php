<?php

// CHECK IF USER IS ADMIN
if (is_admin($connection, $_SESSION['id'])) {

  // SETS TITLE FOR HEADER
  $title = "Zmaturuj.me | Manage accounts";

  // INCLUDES HEADER
  include_once "parts/header.php"; ?>

  <main class="website-content">
    <?= $msg->display(); ?>
    <h2>Here you can manage accounts!</h2>
    <form action="/zmaturuj.me/manage-account" method="post">
      <select name="users">
        <?php

        $users = $connection->prepare("
        SELECT id, firstname, lastname
        FROM users
        ");
        $users->execute();
        $users_fetch = $users->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users_fetch as $user) {
          if (!empty($user['firstname']) && !empty($user['lastname'])) {
            echo '<option value="' . $user['id'] . '">' . $user['firstname'] . " " . $user['lastname'] . "</option>";
          }
        }
        ?>
      </select>
      <input type="checkbox" name="isTeacher" id="isTeacher">
      <label for="isTeacher">Teacher</label>
      <input type="checkbox" name="isAdmin" id="isAdmin">
      <label for="isAdmin">Admin</label>

      <button type="submit" name="submit" class="buttonInput">Edit</button>

    </form>
  </main>

<?php

  //INCLUDE FOOTER
  include_once "parts/footer.php";

  // OTHERWISE REDIRECT HIM BACK
} else {
  header("Location: $url/error");
}
?>