
<?php get_header(); ?>


<div class="header-sticky">
<header class="header">

    <div class="flex container">

        <div class="logo">
            <a href="./">
                <img src="assets/img/logo.svg" alt="__TITLE__">
            </a>
        </div>
        <!-- <h1>__TITLE__</h1> -->

        <div id="nav-mobile" class="nav-handler">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>

        <nav id="nav-main" class="nav">
            <ul>
                <li class="nav-dropdown nav--item"><a href="#">Item</a></li>
                <li class="nav-drop nav--item"><a href="#">Sub</a>
                    <ul class="nav-sub">
                        <li class="nav-sub--item"><a  href="#">Item</a></li>
                        <li class="nav-drop nav-sub--item"><a href="#">Deep</a>
                            <ul class="nav-deep">
                                <li class="nav-deep--item"><a href="#">Item</a></li>
                                <li class="nav-deep--item"><a href="#">Item</a></li>
                                <li class="nav-deep--item"><a href="#">Item</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="sb-overlay--handler nav--item"><a><i class="fa-instagram"></i></a></li>
            </ul>
        </nav>
    </div>

</header>
</div>


<main id="content"> <!-- content -->

    <p>Text!!</p>
    <router-view></router-view>

</main> <!-- end content -->


<?php get_footer(); ?>
