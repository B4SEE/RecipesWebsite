<?php

/**
 * This file represents the header section of a website.
 * It includes the necessary files, displays the logo, navigation menu, search bar, and login button.
 * The navigation menu contains links to different recipe categories and an "About us" link.
 * The search bar allows users to search for recipes.
 * The login button displays "Login" if the user is not logged in, and "Logout" if the user is logged in.
 */

require_once "config.php";
require_once "crud.php";
?>
<div class="bar"></div>
<header>
    <!-- Logo -->
    <a href="./index.php" class="logo">
        <img src="./PROJECT_files/website_icon.png" alt="logo">
        <span>Nazev</span>
    </a>
    <!-- Navigation Menu -->
    <nav class="menu">
        <ul>
            <!-- Dinner Category -->
            <li>Dinner&#9660;
                <div class="sub_menu">
                    <ul>
                        <?php
                        $menu_result = searchNRecipes("dinner", 3);
                        generateMenu($menu_result);
                        ?>
                        <li><a href="./doSearch.php?searchInput=dinner">more</a></li>
                    </ul>
                </div>
            </li>
            <!-- Meals Category -->
            <li>Meals&#9660;
                <div class="sub_menu">
                    <ul>
                        <?php
                        $menu_result = searchNRecipes("meal", 3);
                        generateMenu($menu_result);
                        ?>
                        <li><a href="./doSearch.php?searchInput=meal">more</a></li>
                    </ul>
                </div>
            </li>
            <!-- Occasions Category -->
            <li>Occasions&#9660;
                <div class="sub_menu">
                    <ul>
                        <?php
                        $menu_result = searchNRecipes("occasion", 3);
                        generateMenu($menu_result);
                        ?>
                        <li><a href="./doSearch.php?searchInput=occasion">more</a></li>
                    </ul>
                </div>
            </li>
            <!-- About Us Link -->
            <li><a href="./about_us.php">About us</a></li>
        </ul>
    </nav>
    <!-- Search Bar and Login Button -->
    <div class="search_bar_and_login">
        <!-- Search Bar -->
        <div class="search_bar">
            <form id="search_form" action="./doSearch.php" method="post">
                <button id="submit_button" type="submit"><img src="./PROJECT_files/searchbar_icon.png" alt="search"></button>
                <label for="search_input" hidden></label>
                <input id="search_input" type="text" placeholder="Search" name="search_input">
            </form>
        </div>
        <!-- Login Button -->
        <div class="login">
            <img src="./PROJECT_files/login_icon.png" alt="login">
            <a id="login_button" href="./login.php">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "Logout";
                } else {
                    echo 'Login';
                }
                ?>
            </a>
        </div>
    </div>
</header>