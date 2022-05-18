<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Intro page for the HTML Boys' MP3 website." />
    <meta name="keywords" content="MP3, Format, Intro" />
    <meta name="author" content="Orson Routt, Kien Quoc Mai, Yong Yuan Chong, Keath Kor" />
    <title>MP3 Introduction</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gelasio:ital,wght@0,500;1,500&family=Gravitas+One&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css" />
</head>

<body class="body">
    <?php include('header.inc')
    ?>

    <main class="intro-main enhancement" id="intro-main">
        <h1 class="intro-h1__large">MP3 FORMAT</h1>
        <p class="intro-p__line">MP3 is a coding format that’s been around for decades, and since its initial standardisation in 1993 has been a consistent part of audio formatting. Its initial creation was led by <i>Karlheinz Brandenburg</i> of the <i>Fraunhofer Society</i>, and it is thanks to him and his group's efforts that MP3 has become the dominant global format that you have certainly used in your life either knowingly or unknowingly. Even in spite of other technologies rising up to contest this mammoth of a format, its still here to stay for a long time.</p>
        <form>
            <button class="intro-button" value="FIND OUT MORE" formaction="./topic.php#topic-page">FIND OUT MORE</button>
            <button class="intro-button intro-button--video" formaction="https://youtu.be/-Vz2DZYxPwo">VIEW DEMO VIDEO</button>
        </form>
        <p class="unsplash">
            Photo by
            <a href="https://unsplash.com/@kpebedko_o?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText" target="_blank" rel="noopener noreferrer">
                Oleg Sergeichik
            </a> on
            <a href="https://unsplash.com/s/photos/sony-walkman?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText" target="_blank" rel="noopener noreferrer">
                Unsplash
            </a>
        </p>
    </main>

    <?php include('footer.inc')
    ?>
</body>

</html>