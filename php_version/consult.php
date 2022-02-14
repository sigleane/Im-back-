<?php

// if(!isset($_POST['submitter']) || !isset($_POST['password'])){
//     header("Location:http://localhost/projects/keylogger/php_version/login.html");
//     exit(0);
// }else if($_POST['password'] != 6.62607){
//     header("Location:http://localhost/projects/keylogger/php_version/login.html?info=wrongpassword");
//     exit(0);
// }


require_once("./includes/db_connect.php");
require_once("./includes/instruction.php");


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divirta-se!</title>

    <link rel="shortcut icon" href="./favicon/marianne.png" type="image/x-icon">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600&display=swap" rel="stylesheet">

    <style>
        ::-webkit-scrollbar {
            width: 9px;
            background-color: rgb(31 31 31);
        }

        ::-webkit-scrollbar-thumb {
            height: 10px;
            background-color: rgb(66 65 65);
        }

        body {
            /*background: #0c0c0c;*/
            background-color: #161e29;
            color: wheat;
            font-family: 'Inter', sans-serif;
        }

        hr {
            border: 1px solid #343454;
            max-width: 700px;
        }

        P {
            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 18px;
            margin-top: 30px;
            gap: 10px;

            background-color: #1b2431;
            overflow-wrap: anywhere;
            cursor: pointer;
        }

        p.special {
            border-right: 3px solid #00ff72;
        }


        p:hover {
            background: #18212e;
        }

        p:hover .star_container {
            display: initial;
        }

        .star_container {
            display: none;
        }

        .star_container.active {
            display: initial;
        }

        .header_data {
            color: green;
            cursor: text;
            color: #00f3ff;
        }

        .content_data {
            color: white;
            cursor: text;
        }


        .date_header {
            color: red;
        }

        button.star_container {
            background: none;
            border: none;
        }

        header {
            display: flex;
            justify-content: flex-end;
        }


        button.select-content {
            font-weight: bolder;
            padding: 10px;
            border: none;
            opacity: 0.5;
            border-radius: 8px;
            background-color: #1b2431;
            color: wheat;
            cursor: pointer;
        }

        button.select-content.active {
            opacity: 1;
            cursor: default;
            background: #1d2b40;
        }

        button.select-content:hover {
            background-color: #1f2c40;
        }


        a {
            display: none;
        }

        .buttons_container {
            display: flex;
            gap: 10px;
            position: fixed;

            background-color: #18212e;
            padding: 14px;
            border-radius: 8px;
        }


        @keyframes up {
            from {
                opacity: 1;
                transform: translateY(0px);
            }

            to {
                opacity: 0;
                transform: translateY(-50px)
            }
        }



        @keyframes down {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0px)
            }
        }

        .up-header {
            animation-name: up;
            animation-duration: 0.3s;
            animation-fill-mode: forwards;
        }

        .down-header {
            animation-name: down;
            animation-duration: 0.3s;
            animation-fill-mode: forwards;
        }
    </style>



</head>

<body onload="init_DOM()">

    <header>
        <div class="buttons_container">
            <button id="all-data" class="select-content active">
                Tudo
            </button>

            <button id="favorites" class="select-content">
                Favoritados
            </button>
        </div>


    </header>

    <main></main>

    <script>
        const all_stars = document.querySelectorAll(".star_container");
        const all_data = document.querySelector("#all-data");
        const favorites = document.querySelector("#favorites");

        const main_tag = document.querySelector("main");


        function init_DOM() {
            all_stars.forEach((star) => {
                star.addEventListener("click", (event) => control_favorite_system(event));
            });

            ajax_content("POST", "./ajax/show_all_data.php", null);
        }



        all_data.addEventListener("click", (event) => change_content(event));

        favorites.addEventListener("click", (event) => change_content(event));

        function change_content(event) {
            if (event.target.id === "all-data" && !event.target.classList.contains("active")) {

                event.target.classList.add("active");
                favorites.classList.remove("active");

                ajax_content("POST", "./ajax/show_all_data.php", null);

            } else if (event.target.id === "favorites" && !event.target.classList.contains("active")) {

                event.target.classList.add("active");
                all_data.classList.remove("active");

                ajax_content("POST", "./ajax/show_favorite_data.php", null)

            }

        }

        function control_favorite_system(event) {
            let reference = event.target.parentNode

            if (reference.id !== "") {
                const id_of_data = reference.id;
                const star_container = event.target;

                adjust_favorite(id_of_data, star_container);

            } else {
                const id_of_data = reference.parentNode.id;
                const star_container = event.target.parentNode

                adjust_favorite(id_of_data, star_container);
            }

            function adjust_favorite(id_of_data, star_container) {
                if (!star_container.classList.contains("active")) {
                    star_container.classList.add("active");

                    star_container.innerHTML = "<img src='./favicon/star_white_full.svg'>";

                    send_ajax("POST", "./ajax/add_favorites.php", id_of_data);
                } else {
                    star_container.classList.remove("active");

                    star_container.innerHTML = "<img src='./favicon/star_white.svg'>";

                    send_ajax("POST", "./ajax/remove_favorites.php", id_of_data);
                }
            }
        }

        function send_ajax(method, ajax_to, send_data) {
            const xhr = new XMLHttpRequest();
            xhr.onload = () => {
                if (xhr.status === 200) {
                    console.log(xhr.responseText)
                }
            }
            xhr.open(method, ajax_to, true);
            xhr.send(send_data);
        }

        function ajax_content(method, ajax_to, send_data) {
            const xhr = new XMLHttpRequest();
            xhr.onload = () => {
                if (xhr.status === 200) {
                    main_tag.innerHTML = xhr.responseText

                    if (ajax_to === "./ajax/show_all_data.php") {
                        document.querySelectorAll(".star_container").forEach((star) => {
                            star.addEventListener("click", (event) => control_favorite_system(event));
                        });
                    }

                }
            }
            xhr.open(method, ajax_to, true);
            xhr.send(send_data);
        }

        let lastScrollY = window.scrollY;
        const buttons_container = document.querySelector(".buttons_container");

        window.addEventListener("scroll", () => {
            if (lastScrollY < window.scrollY) {
                buttons_container.classList.add("up-header");
                buttons_container.classList.remove("down-header");
            } else {
                buttons_container.classList.remove("up-header");
                buttons_container.classList.add("down-header");
            }

            lastScrollY = window.scrollY;
        });
    </script>

</body>

</html>