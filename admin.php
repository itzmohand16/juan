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

    // Check if the config file exists
    if (!file_exists($configFile)) {
        responde(true, "auth");
    }
    
    // Read and decode the JSON file
    $configData = file_get_contents($configFile);
    if ($configData === false) {
        responde(true, "auth");
    }
    
    $config = json_decode($configData, true);
    
    // Check if JSON decoding was successful
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
$full = [];
try {
    $query = $db->prepare('SELECT * FROM `posts`');
    $result = $query->execute();

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $full[] = $row;
    }
} catch (Exception $e) {
    header("Location: /index.php");
    die();
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
        <div class="md:container min-h-screen md:flex-col md:h-auto md:w-1/3 md:bg-gray-800">
            <p class="md:text-white md:text-3xl md:font-bold md:flex md:w-full md:justify-center md:pt-20">Admin Panel</p>
            <button class="md:text-white md:text-3xl md:font-bold md:flex md:w-full md:justify-center md:py-8 ">
                <p class="md:bg-slate-100 md:text-black md:text-2xl md:font-medium md:p-2 md:rounded-xl">Posts Management</p>
            </button>
            <button onclick="window.location.href = '/uploader.php'" class="md:text-white md:text-3xl md:font-bold md:flex md:w-full md:justify-center md:py-8 ">
                <p class="md:bg-slate-100 md:text-black md:text-2xl md:font-medium md:p-2 md:rounded-xl">Upload Images</p>
            </button>
        </div>




        <div class="md:mx-20 md:mt-32 md:w-screen">
            <div class="md:flex md:justify-between md:space-x-40">
                <p class="md:text-4xl  md:text-white md:font-bold">Posts List:</p>
                <form action="/admin-create.php">
                <button>
                    <p class="md:text-lg md:bg-indigo-900 md:p-1.5 md:rounded-xl md:text-white md:font-bold">Create a new post</p>
                </button>
            </form>
            </div>



            <?php
            foreach ($full as $post){
                $id = $post['id'];
                $shortdes = $post['desc'];
                $title = $post['title'];
                $wordsArray = str_word_count($shortdes, 1);
                echo '<div class="md:bg-white md:my-10 md:rounded-lg ">
                <div class="md:flex md:font-bold md:text-xl md:px-4 md:py-4 md:justify-between">
                    <p class="md:text-2xl">Title: '.$title.'</p>
                    <button onclick="window.location.href = \'/admin-modify.php?id='.$id.'\'">
                        <p class="md:bg-black md:rounded-lg md:text-white md:p-1.5">Edit Post</p>
                    </button>
                </div>


                <div class="md:flex md:font-bold md:text-xl md:px-4 md:py-5 md:justify-between">
                    <p class="md:text-2xl">Headline: '.$post['headline'].'</p>
                    <button onclick="window.location.href = \'/adminprocessor.php?id='.$id.'&request=delete\'">
                        <p class="md:bg-red-700 md:rounded-lg md:text-white md:p-1.5">Delete Post</p>
                    </button>
                </div>
            </div>';
            }

            ?>
            




            





            



















        </div>


   


    </div>

</body></html>