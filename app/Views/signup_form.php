<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation</title>
    <style>
        body{
            display: block;
            justify-content: center;
        }

        .form-box {
        max-width: 300px;
        background: #82b2e7;
        overflow: hidden;
        border-radius: 16px;
        color: #010101;
        }

        .form {
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 32px 24px 24px;
        gap: 16px;
        text-align: center;
        }

        .title {
        font-weight: bold;
        font-size: 1.6rem;
        }

        .subtitle {
        font-size: 1rem;
        color: #666;
        }

        .form-container {
        overflow: hidden;
        border-radius: 8px;
        background-color: #fff;
        margin: 1rem 0 .5rem;
        width: 100%;
        }

        .input {
        background: none;
        border: 0;
        outline: 0;
        height: 40px;
        width: 100%;
        border-bottom: 1px solid #eee;
        font-size: .9rem;
        padding: 8px 15px;
        }

        .form-section {
        padding: 16px;
        font-size: .85rem;
        background-color: #82b2e7;
        box-shadow: rgb(0 0 0 / 8%) 0 -1px;
        }

        .form-section a {
        font-weight: bold;
        color: #0066ff;
        transition: color .3s ease;
        }

        .form-section a:hover {
        color: #005ce6;
        text-decoration: underline;
        }

        .form button {
        background-color: #0066ff;
        color: #fff;
        border: 0;
        border-radius: 24px;
        padding: 10px 16px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color .3s ease;
        }

        .form button:hover {
        background-color: #005ce6;
        }
        
        .gen{
            margin-left: 40%;
        }
    </style>
</head>
<body>
    <div class="gen">
        <?= \Config\Services::validation()->listErrors(); ?>
        <div class="form-box">
            <form class="form" action="<?= site_url('signup/processSignup') ?>" method="post" accept-charset="utf-8">
                <span class="title">Sign up</span>
                <span class="subtitle">Create an account for an api key.</span>
                <div class="form-container">
                    <input type="text" class="input" placeholder="First Name" name="firstname" value="<?= set_value('firstname', $userData['firstname']) ?>">
                    <input type="text" class="input" placeholder="Last Name" name="lastname" value="<?= set_value($userData['lastname']) ?>">
                    <input type="text" class="input" placeholder="Username" name="username" value="<?= set_value($userData['username']) ?>">
                    <input type="email" class="input" placeholder="Email" name="email" value="<?= set_value($userData['email']) ?>">
                    <input type="password" class="input" placeholder="Password" name="password" value="<?= set_value($userData['password']) ?>">
                    <input type="password" class="input" placeholder="Confirm Password" name="c_password" value="<?= set_value($userData['c_password']) ?>">
                </div>
                <button type="submit">Sign up</button>
            </form>
        <div class="form-section">
            <p>Have an account? <a href="">Log in</a> </p>
        </div>
    </div>

</body>
</html>