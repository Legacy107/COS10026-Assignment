<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Enhancements page for the HTML Boys' MP3 website."/>
    <meta name="keywords" content="HTML, CSS, Enhancements"/>
    <meta name="author" content="Kien Quoc Mai, Yong Yuan Chong, Keath Kor"/>
    <title>Enhancements</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gelasio:ital,wght@0,500;1,500&family=Gravitas+One&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css"/>
</head>
<body>
    <?php include('header.inc')
    ?>

    <main class="enhancements-main">
        <h1 class="enhancements-main__title">Enhancements</h1>

        <section>
            <div class="enhancements-article__demo">
                <img class="enhancements-article__demoImg" id="enhancements-desktopLayoutDemo" src="images/desktop-index.jpg" alt="desktop version of index page">
                <img class="enhancements-article__demoImg" id="enhancements-mobileLayoutDemo" src="images/mobile-index.jpg" alt="mobile version of index page">
                <img class="enhancements-article__demoImg" id="enhancements-tabletLayoutDemo" src="images/tablet-index.jpg" alt="tablet version of index page">
            </div>

            <div class="enhancements-article__description">
                <h2>Responsive Design</h2>
                <p>Various techniques including the use of media queries, flexbox and grid are utilised to make the page responsive to different screen layouts (e.g. desktop, tablet and mobile layout). By doing this, the website can be accessed on a variety of devices which enhances user experience.</p>
            </div>
        </section>

        <section>
            <div class="enhancements-article__demo">
                <a href="./quiz.html#quiz-graphic">
                    <img class="enhancements-article__demoImg" id="enhancements-bouncingAnimationDemo" src="images/bouncing.gif" alt="bouncing animation demo">
                </a>
                <a href="./index.html#intro-menu">
                    <img class="enhancements-article__demoImg" id="enhancements-navbarAnimationDemo" src="images/navbar.gif" alt="navbar animation demo">
                </a>
                <a href="./index.html#intro-main">
                    <img class="enhancements-article__demoImg" id="enhancements-enteringAnimationDemo" src="images/entering.gif" alt="entering animation demo">
                </a>
            </div>

            <div class="enhancements-article__description">
                <h2>Transition and Animation</h2>
                <p>Throughout out all pages, animation and transition properties are applied on different element in order to increase the interactivity as well as maintain a smooth and aesthetically pleasing experience.</p>
            </div>
        </section>

        <section>
            <div class="enhancements-article__demo">
                <a href="./topic.html#topic-hero">
                    <img class="enhancements-article__demoImg" id="parallaxDemo" src="images/parallax.gif" alt="parallax background">
                </a>
            </div>

            <div class="enhancements-article__description">
                <h2>Parallax effect</h2>
                <p>At the top of the topic page, a parallax effect is applied on the image element so that it scrolls at a different pace compared to the rest of the page. This is achieved using a 3D transformation. The parallax effect creates a nicer scrolling experience which enhances the user's overall experience on the topic page.</p>
            </div>
        </section>
    </main>

 
    <?php include('footer.inc')
    ?>
</body>
</html>
