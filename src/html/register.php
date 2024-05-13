<?php

use SimpleDemoBlog\Models\User;


include(__DIR__.'/../components/dependencies.php');
include __DIR__.'/../components/auth.php';
$errors = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['captcha'] != $_SESSION['captcha']) {
        header('Location: /register.php');
        exit;
    }
    /** @var User $user */
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = $_POST['username'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors = true;
    } else {
        $user = User::searchByEmail($email);
    }
    if ($user) {
        $errors = true;
    } else {
        if ($_POST['password'] === $_POST['password_confirmation']) {
            $user = new User;
            $user->setUser_name($username);
            $user->setEmail($email);
            $user->setPassword($_POST['password']);
            $user->save();
            $_SESSION['authenticated'] = true;
            $_SESSION['user_name']= $username;
            $_SESSION['user_email']= $email;
            $_SESSION['user_id']= $user->getId();
            $_SESSION['notifications'][] = 'You have successfully registered';
            header('Location: /index.php');
            exit;
        }
    }
}
$headerTitle = 'Register';
$pageTitle = 'Register';
include __DIR__.'/../components/captcha.php';
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
            $("#register").submit(function (e) {
                var username = $("#username").val();
                var email = $("#email").val();
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                var password = $("#password").val();
                var password_confirmation = $("#password_confirmation").val(); //get the value of password confirmation
                var captcha = $("#captcha").val();
                var text = '<ul>';
                var areFieldsEmpty = false;
                if (username === "") {
                    e.preventDefault();
                    text += "<li>Please fill in the User Name field correctly.</li>";
                    areFieldsEmpty = true;
                }
                if (!emailReg.test(email)) {
                    e.preventDefault();
                    text += "<li>Please fill in the email field.</li>";
                    areFieldsEmpty = true;
                }
                if (password === "") {
                    e.preventDefault();
                    text += "<li>Please fill in the Password field.</li>";
                    areFieldsEmpty = true;
                }
                if (password !== password_confirmation) { //check if password and password confirmation are the same
                    e.preventDefault();
                    text += "<li>Confirmation Password is not the same as Password.</li>";
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
    <main>

        <section style="display: flex; justify-content: center; align-items: center;">
            <!-- Add comment form -->

            <form id="register" action="register.php" method="POST"
                  style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                <h2>Registration</h2>
                <div><?php if ($errors == true) { ?>Please correct any errors and try again.<?php } ?></div>
                <label for="username" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">User
                    Name:</label><br/>
                <input type="text" id="username" name="username"
                       style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;">
                <br/>
                <label for="email" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Email :</label><br/>
                <input type="email" id="email" name="email"
                       style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;">
                <br/>

                <label for="password" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Password:</label>
                <input id="password" name="password" type="password"
                       style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;"></input>
                <br/>
                <label for="password_confirmation" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Confirm
                    Password:</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
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
            </form>
        </section>
    </main>
    </body>
<?php
include __DIR__.'/../components/footer.php';