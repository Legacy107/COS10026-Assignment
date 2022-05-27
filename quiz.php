<!-- 
    Last edited: 5PM 13/05/2022
    By: Orsan Routt
    Details: Addition of error feedback
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Quiz on MP3 format"/>
    <meta name="keywords" content="MP3 format, quiz"/>
    <meta name="author" content="Peter Farmer, Kien Quoc Mai, Yong Yuan Chong, Keath Kor"/>
    <title>MP3 Quiz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gelasio:ital,wght@0,500;1,500&family=Gravitas+One&family=Luckiest+Guy&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400&display=swap" rel="stylesheet">
    
    <!--for the checkmark and inner circle for radios-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> 
    <link rel="stylesheet" href="styles/style.css"/>
</head>
<body>
    <?php include "header.inc" ?>

    <main class="quiz-main">

        <h1 class="quiz-h2">MP3 Quiz</h1>

        <?php
            require_once "data_input.php";
            require_once "error.php";

            session_start();
            $action = get_action();
            if ($action == "error") {
                $origin = "quiz.php";
                $errorMsg = get_session("errorMsg");
                $errorOri = get_session("errorOri");
                $errors = [];
                if ($errorMsg == null) {
                    array_push($errors, "No error message in session.");
                }
                if ($errorOri == null) {
                    array_push($errors, "No error origin in session.");
                }
                if (count($errors) == 0) {
                    $origin = $errorOri;
                    $errors = $errorMsg;
                }
                echo_error($errors, $origin, "quiz-error");
            }
            session_unset();
            session_destroy();
        ?>

        <form method="post" action="mark.php" novalidate>
            <fieldset class="quiz-fieldset"><legend class="quiz-fieldset__legend">Student Information</legend>

                <!--user information-->
                <!--letters + spaces only for first name and last name-->
                <!--numbers only for student ID-->
                <label for="fname" class="quiz-fieldset__label">First Name</label>
                <input type="text" name="fname" id="fname" class="quiz-input__text--info" pattern="^[a-zA-Z\s-]{1,30}$" placeholder="Steve" title="Please enter upper or lower case letters only, spaces are allowed. Maximum 30 characters" required />
                <br />
                <label for="lname" class="quiz-fieldset__label">Last Name</label>
                <input type="text" name="lname" id="lname" class="quiz-input__text--info" pattern="^[a-zA-Z\s-]{1,30}$" placeholder="Johnson" title="Please enter upper or lower case letters only, spaces are allowed. Maximum 30 characters" required />
                <br />
                <label for="sid" class="quiz-fieldset__label">Student ID</label>
                <input type="text" name="sid" id="sid" class="quiz-input__text--info" pattern="^(\d{7}|\d{10})$" placeholder="0102654312" title="Please enter 7 or 10 digits." required />
            </fieldset>

            <div class="quiz-graphicContainer enhancement" id="quiz-graphic">
                <svg>
                    <rect rx=10 ry=10 width=7.2em height=2.5em></rect>
                </svg>
                <div class="quiz-graphic">
                    <span>Q</span>
                    <span>U</span>
                    <span>I</span>
                    <span>Z</span>
                    <span>T</span>
                    <span>I</span>
                    <span>M</span>
                    <span>E</span>
                </div>
            </div>

            <fieldset class="quiz-fieldset"><legend class="quiz-fieldset__legend quiz-fieldset__legend--questions">Questions</legend>

                <!--Question 1 - text answer-->
                <div class="quiz-fieldset__div">

                    <!--Left column in question section for large screens-->
                    <!--Top of question section in smaller screens-->
                    <div class="quiz-div__left">
                        <h3 class="quiz-h3__question">Question #1</h3>
                        <p class="quiz-div__para">Type out the answer for the following, using a capital letter at the start of each word. What does MPEG stand for?</p>
                    </div>

                    <!--Left Column in question section for large screens-->
                    <!--Bottom of question section in smaller screens-->
                    <div class="quiz-div__right">
                        <h4 class="quiz-h4">Answer</h4>
                        <!--Accepts letters, numbers, spaces.-->
                        <input type="text" name="MPEG" id="MPEG" class="quiz-input__text" pattern="^M[a-z]+\sP[a-z]+\sE[a-z]+\sG[a-z]+$" placeholder="Answer Here" title="Please enter four words starting with M, P, E, and G." required />
                    </div>

                </div>

                <!--Question 2 - single choice-->
                <div class="quiz-fieldset__div">

                    <!--Left for Large/ Top for small-->
                    <div class="quiz-div__left">
                        <h3 class="quiz-h3__question">Question #2</h3>
                        <p class="quiz-div__para">Select a single answer. Which of the following lists the year that MPEG-2 Audio Layer III was first published along with the year of its most recent update?</p>
                    </div>

                    <!--Right for Large/ Bottom for small-->
                    <div class="quiz-div__right">
                        <h4 class="quiz-h4">Answer</h4>
                        <div class="quiz-div__answers--grid">
                            <div class="quiz-div__answers">
                                <input type="radio" name="years" id="1993/1995" value="1993 / 1995" class="quiz-radio" required /> 
                                <label for="1993/1995" class="quiz-label__answer">1993 / 1995</label>
                            </div>
                            <div class="quiz-div__answers">
                                <input type="radio" name="years" id="1998/2008" value="1998 / 2008" class="quiz-radio" /> 
                                <label for="1998/2008" class="quiz-label__answer">1998 / 2008</label>
                            </div>
                            <div class="quiz-div__answers">
                                <input type="radio" name="years" id="1995/1998" value="1995 / 1998" class="quiz-radio" /> 
                                <label for="1995/1998" class="quiz-label__answer">1995 / 1998</label>
                            </div>
                            <div class="quiz-div__answers quiz-div__checkbox--bottom">
                                <input type="radio" name="years" id="1993/2008" value="1993 / 2008" class="quiz-radio" /> 
                                <label for="1993/2008" class="quiz-label__answer">1993 / 2008</label>
                            </div>
                        </div>
                    </div>

                </div>

                <!--Question 3 - Multi choice-->
                <div class="quiz-fieldset__div">

                    <!--Left for Large/ Top for small-->
                    <div class="quiz-div__left">
                        <h3 class="quiz-h3__question">Question #3</h3>
                        <p class="quiz-div__para">Select multiple answers. Which of the following are officially recognised MPEG standards?</p>
                    </div>

                    <!--Right for Large/ Bottom for small-->
                    <div class="quiz-div__right">
                        <h4 class="quiz-h4">Answer</h4>
                        <div class="quiz-div__answers--grid">
                            <div class="quiz-div__answers" >
                                <input type="checkbox" name="standards[]" id="MPEG1" value="MPEG 1 Audio layer III" class="quiz-checkbox" />
                                <label for="MPEG1" class="quiz-label__answer">MPEG 1 Audio layer III</label>
                            </div>
                            <div class="quiz-div__answers" >
                                <input type="checkbox" name="standards[]" id="MPEG2" value="MPEG 2 Audio Layer III" class="quiz-checkbox" />
                                <label for="MPEG2" class="quiz-label__answer">MPEG 2 Audio Layer III</label>
                            </div>
                            <div class="quiz-div__answers" >
                                <input type="checkbox" name="standards[]" id="MPEG2.5" value="MPEG 2.5 Audio Layer III" class="quiz-checkbox" />
                                <label for="MPEG2.5" class="quiz-label__answer">MPEG 2.5 Audio Layer III</label>
                            </div>
                            <div class="quiz-div__answers quiz-div__checkbox--bottom" >
                                <input type="checkbox" name="standards[]" id="MPEG3" value="MPEG 3 Audio Layer III" class="quiz-checkbox" />
                                <label for="MPEG3" class="quiz-label__answer">MPEG 3 Audio Layer III</label>
                            </div> 
                        </div>
                    </div>

                </div>

                <!--Question 4 - Multi choice -->
                <div class="quiz-fieldset__div">

                    <!--Left for Large/ Top for small-->
                    <div class="quiz-div__left">
                        <h3 class="quiz-h3__question">Question #4</h3> 
                        <p class="quiz-div__para">Select multiple answers. What were the main causes of the slow gradual decline in the MP3 format’s popularity?</p>
                    </div>

                    <!--Right for Large/ Bottom for small-->
                    <div class="quiz-div__right">
                        <h4 class="quiz-h4">Answer</h4>
                        <div class="quiz-div__answers--grid">
                            <div class="quiz-div__answers">
                                <input type="checkbox" name="decline[]" id="variety_of_devices" value="variety of devices" class="quiz-checkbox" />
                                <label for="variety_of_devices" class="quiz-label__answer">A wider variety of devices</label>
                            </div>
                            <div class="quiz-div__answers" >
                                <input type="checkbox" name="decline[]" id="legal_concerns" value="legal issues" class="quiz-checkbox" />
                                <label for="legal_concerns" class="quiz-label__answer">Legal concerns</label>
                            </div>
                            <div class="quiz-div__answers" >
                                <input type="checkbox" name="decline[]" id="alternative_audio_formats" value="alternative audio formats" class="quiz-checkbox" />
                                <label for="alternative_audio_formats" class="quiz-label__answer">Increasing number of alternative audio formats</label>
                            </div>
                            <div class="quiz-div__answers quiz-div__checkbox--bottom" >
                                <input type="checkbox" name="decline[]" id="MPEG_changes" value="MPEG changes" class="quiz-checkbox" />
                                <label for="MPEG_changes" class="quiz-label__answer">Changes in MPEG standards</label>
                            </div>  
                        </div> 
                    </div>

                </div>

                <!--Question 5 - Drop down list single answer-->
                <div class="quiz-fieldset__div">

                    <!--Left for Large/ Top for small-->
                    <div class="quiz-div__left">
                        <h3 class="quiz-h3__question">Question #5</h3>
                        <p class="quiz-div__para">Select an answer from the drop down list. Who was the primary inventor of the MP3 format?</p>
                    </div>

                    <!--Right for Large/ Bottom for small-->
                    <div class="quiz-div__right">
                        <h4 class="quiz-h4">Answer</h4>
                        <select name="creator" id="potential_creators" class="quiz-selector" required>
                            <option value="">Please Select an Answer</option>
                            <option value="Fraunhofer Society">Fraunhofer Society</option>
                            <option value="Karlheinz Brandenburg">Karlheinz Brandenburg</option>
                            <option value="MPEG">MPEG</option>
                            <option value="ISO">The international Standards Organisation (ISO)</option>
                        </select>
                    </div>

                </div>

                <!--Question 6 - True/False answer-->
                <div class="quiz-fieldset__div">

                    <!--Left for Large/ Top for small-->
                    <div class="quiz-div__left">
                        <h3 class="quiz-h3__question">Question #6</h3>
                        <p class="quiz-div__para">True or False? MP3 uses lossless compression.</p>
                    </div>   
                             
                    <!--Right for Large/ Bottom for small-->
                    <div class="quiz-div__right">
                        <h4 class="quiz-h4">Answer</h4>
                        <div class="quiz-div__answers--grid">
                            <div class="quiz-div__answers">
                                <input type="radio" name="compression" id="True" value="True" class="quiz-radio" required />
                                <label for="True" class="quiz-label__answer">True</label>
                            </div>
                            <div class="quiz-div__answers quiz-div__checkbox--bottom">
                                <input type="radio" name="compression" id="False" value="False" class="quiz-radio" />
                                <label for="False" class="quiz-label__answer">False</label>
                            </div>
                        </div>
                    </div>

                </div> 

            </fieldset>

            <!--Posts to specified form location -->
            <input type="submit" value="SUBMIT ANSWERS" class="quiz-submit"/>

        </form>
        
    </main>

    <?php include "footer.inc" ?> 
</body>
</html>
