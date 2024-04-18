<?php

include_once('main.php');
$freeway = [];
function authenticate() {
    header('WWW-Authenticate: Basic realm="Authentication required"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authentication required';
    exit;
}
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    authenticate();
} else {
    $configFile = './safeassets/config.json';

    if (!file_exists($configFile)) {
        responde(true, "auth");
    }
    $configData = file_get_contents($configFile);
    if ($configData === false) {
        responde(true, "auth");
    }
    
    $config = json_decode($configData, true);
    
    if ($config === null) {
        responde(true, "auth");
    }   
     
    
    $username = $config['username'];
    $password = $config['password'];
    $freeway[] = $username;
    $freeway[]= $password;
    
    if ($_SERVER['PHP_AUTH_USER'] != $username || $_SERVER['PHP_AUTH_PW'] != $password) {
        authenticate();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="icon" type="image/png" href="">
    <meta property="og:title" content="Blox Center">
    <meta name="description" content="Together We Can Solve IT">
    <meta property="og:description" content="Together We Can Solve IT">
    <meta property="og:url" content="">
    <style>
        /* CSS to make textarea unresizable */
        .textarea {
            resize: none;
        }
    </style>
</head>



<body class="bg-black">
    <div class="flex">
        <div class="md:container min-h-screen md:flex-col md:h-auto md:w-1/4 md:bg-gray-800">
            <p class="md:text-white md:text-3xl md:font-bold md:flex md:w-full md:justify-center md:pt-20">Admin Panel</p>
            <button onclick="window.location.href = '/admin.php'" class="md:text-white md:text-3xl md:font-bold md:flex md:w-full md:justify-center md:py-8 ">
                <p class="md:bg-slate-100 md:text-black md:text-2xl md:font-medium md:p-2 md:rounded-xl">Posts Management</p>
            </button>
            <button onclick="window.location.href = '/uploader.php'" class="md:text-white md:text-3xl md:font-bold md:flex md:w-full md:justify-center md:py-8 ">
                <p class="md:bg-slate-100 md:text-black md:text-2xl md:font-medium md:p-2 md:rounded-xl">Upload Images</p>
            </button>
        </div>
        <div id="postForm" class="md:mx-20 md:mt-32 md:w-fit">
    <div class="md:flex md:justify-between md:space-x-40">
        <p class="md:text-4xl md:text-white md:font-bold">Create Post:</p>
    </div>

    <div class="md:bg-white md:my-10 md:rounded-lg md:h-fit py-8">
        <div class="md:flex md:font-bold md:text-xl md:px-4 md:py-4 md:justify-between">
            <p class="md:text-2xl">Title: <input id="title" class="md:bg-gray-700 md:text-white md:font-medium md:p-1 md:rounded-lg"></p>
        </div>
        <div class="md:flex md:font-bold md:text-xl md:px-4 md:py-4 md:justify-between">
            <p class="md:text-2xl">Headline: <input id="headline" class="md:bg-gray-700 md:text-white md:font-medium md:p-1 md:rounded-lg"></p>
        </div>
        <div class="md:flex md:font-bold md:text-xl md:px-4 md:py-5 md:justify-between">
            <p class=" md:text-2xl flex flex-row items-start">Description: <textarea rows="4" cols="50" id="des" class="textarea text-lg h-96 md:bg-gray-700 md:text-white md:font-medium md:p-1 md:rounded-lg"></textarea></p>
        </div>
        
        <div class="md:flex md:font-bold md:text-xl md:px-4 md:py-4 md:justify-between">
            <p class="md:text-2xl">Upload Image: <input id="file" type="file" class="md:bg-gray-700 md:text-white md:font-medium md:p-1 md:rounded-lg"></p>
        </div>

        <div class="justify-center flex my-16 space-x-4">
            <button onclick="submitData()">
                <p class="font-bold text-xl bg-green-800 p-2.5 rounded-xl text-white">Create Post</p>
            </button>
        </div>
    </div>
</div>

<script>
    function submitData() {
        var title = document.getElementById("title").value;
        var description = document.getElementById("des").value;
        
        var headline = document.getElementById("headline").value;
        var fileInput = document.getElementById("file");
        var file = fileInput.files.length > 0 ? fileInput.files[0] : null;

        if (!file) {
            console.error('Error: File not selected.');
            return;
        }

        var xhr = new XMLHttpRequest();
        var url = "adminprocessor.php?request=new";

        xhr.open("POST", url, true);

        var headers = {
            "Authorization": "Basic " + btoa("<?php echo $freeway[0] ?>:<?php echo $freeway[1] ?>"),
        };

        Object.keys(headers).forEach(function (key) {
            xhr.setRequestHeader(key, headers[key]);
        });

        var formData = new FormData();
        formData.append("title", title);
        formData.append("description", description);
        formData.append("file", file);
        formData.append("headline", headline);

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                window.location.href = "/admin.php"
            } else {
                console.error('Network response was not ok: ' + xhr.status);
            }
        };

        // Define a callback function to handle errors
        xhr.onerror = function () {
            console.error('Request failed');
        };

        // Send the request with the form data
        xhr.send(formData);
    }
</script>


</body></html>