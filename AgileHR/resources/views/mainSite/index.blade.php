<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="/pictures/favico.png">
        <title>RecruitLink</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <style>
        <?php include '../resources/css/app.css' ?>
        <?php include '../resources/css/subContents.css' ?>
        </style>
    </head>
    <body id="mainFrame">       
        <header role="banner" id="mainHeader">
            @include("mainSite.header")
        </header>
        <div class="row">
            <div class="column side">
                @include("mainSite.navBar")
            </div>
            
            <div class="column middle">               
                @yield("content")
            </div>            
        </div>
    </body>
</html>
