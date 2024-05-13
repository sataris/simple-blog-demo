<?php
use SimpleDemoBlog\Models\User;


include(__DIR__.'/../components/dependencies.php');
include __DIR__.'/../components/auth.php';
include __DIR__.'/../components/captcha.php';
$pageTitle = "Login";
$headerTitle = 'Login';
$errors = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['captcha'] !== $_SESSION['captcha']) {
       $_SESSION['errors'][] = 'Captcha Incorrect';
        header('Location: /login.php');
        exit;
    }
    /** @var User $user */
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors = true;
    } else {
        $user = User::searchByEmail($email);
    }
    if (empty($user)) {
        $errors = true;
        $_SESSION['notifications'][] = 'No matching user/password found';
    } else {
        if ($user->validatePassword($_POST['password'])) {
            $_SESSION["authenticated"] = true;
            $_SESSION["userId"] = $user->getId();
            $_SESSION["user_name"] = $user->getUser_name();
            $_SESSION["email"] = $user->getEmail();
            header('Location: /index.php');
            exit;
        }
    }
}

include __DIR__.'/../components/header.php';
include __DIR__.'/../components/navbar.php';
?>
    <script>
        $(document).ready(function () {
            var dialog = $("#dialog").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                    }
                }
            });
            $("#login").submit(function (e) {
                var email = $("#email").val();
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                var password = $("#password").val();
                var captcha = $("#captcha").val();
                var text = '<ul>';
                var areFieldsEmpty = false;
                if (email === "" || !emailReg.test(email)) {
                    e.preventDefault();
                    text += "<li>Please fill in the email field correctly.</li>";
                    areFieldsEmpty = true;
                }
                if (password === "") {
                    e.preventDefault();
                    text += "<li>Please fill in the Password field.</li>";
                    areFieldsEmpty = true;
                }
                if (captcha === "") {
                    e.preventDefault();
                    text += "<li>Please fill in the Captcha field.</li>";
                    areFieldsEmpty = true;
                }
                text += '</ul>'; // closes the <ul> after list items
                if (areFieldsEmpty) {
                    e.preventDefault();
                    $("#modalMessage").html(text); // use .html() to render HTML tags
                    dialog.dialog("open");
                }
            });
        });
    </script>
    <body>
    <?php include __DIR__.'/../components/notifications.php';?>
    <main>

        <section style="display: flex; justify-content: center; align-items: center;">

            <!-- Add comment form -->

            <form id="login" action="login.php" method="POST"
                  style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                <h2>Login</h2>
                <div><?php if ($errors == true) { ?>Please correct any errors and try again.<?php } ?></div>
                <label for="email" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Email:</label><br/>
                <input type="email" id="email" name="email"
                       style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;">
                <br/>

                <label for="password" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Password:</label>
                <input id="password" name="password" type="password"
                       style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;"></input>
                <br/>
                <label for="captcha"
                       style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Captcha: <?php echo $_SESSION["captcha"]; ?></label>
                <input type="text" id="captcha" name="captcha"
                       style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;">

                <button type="submit"
                        style="background-color: #007BFF; color: #fff; padding: 10px 20px; border-radius: 4px; border: none; cursor: pointer;">
                    Submit
                </button>
                 <?php include __DIR__ .'/../components/errors.php';?>
            </form>
        </section>
    </main>
    </body>
<?php
include __DIR__.'/../components/footer.php';