<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrimony</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css  -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap');

        :root{
            --red:#ff5a3c;
            --light-red:#f9edeb;
        }

        *{
            font-family: 'Nunito', sans-serif;
            margin:0; padding:0;
            box-sizing: border-box;
            outline: none; border:none;
            text-decoration: none;
            text-transform: capitalize;
        }

        html{
            font-size: 62.5%;
            overflow-x: hidden;
            scroll-behavior: smooth;
            scroll-padding-top: 7rem;
        }

        body{
            background:#f7f7f7;
        }

        section{
            padding:2rem 9%;
        }

        .btn{
            margin-top: 1rem;
            display: inline-block;
            padding:.8rem 3.5rem;
            border-radius: .5rem;
            font-size: 1.7rem;
            color:var(--red);
            background:var(--light-red);
            cursor: pointer;
            text-align: center;
        }

        .btn:hover{
            background:var(--red);
            color:#fff;
        }

        .heading{
            text-align: center;
            color:#333;
            font-size: 4rem;
            padding-bottom: 3rem;
        }

        .heading span{
            color:var(--red);
            background:var(--light-red);
            border-radius: .5rem;
            padding:.2rem 1.5rem;
        }

        header{
            position: fixed;
            top:0; left:0; right:0;
            z-index: 1000;
            background:#fff;
            padding:1.5rem 9%;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header .logo{
            font-weight: bolder;
            font-size: 2.5rem;
            color:#333;
        }

        header .logo span{
            color:var(--red);
        }

        header .navbar a{
            color:#333;
            font-size: 2rem;
            padding:0 1.5rem;
        }

        header .navbar a:hover{
            color:var(--red);
        }

        header .icons #menu-bars,
        header .icons a{
            height:4.5rem;
            line-height: 4.5rem;
            width:5rem;
            font-size: 2rem;
            margin-right: .5rem;
            border-radius: .5rem;
            color:var(--red);
            background:var(--light-red);
            text-align: center;
        }

        header .icons #menu-bars:hover,
        header .icons a:hover{
            background-color:var(--red);
            color:#fff;
        }

        header .icons #menu-bars{
            display: none;
        }


        .services .box-container{
            display: flex;
            flex-wrap: wrap;
            gap:1.5rem;
        }

        .services .box-container .box{
            flex:1 1 30rem;
            border-radius: .5rem;
            background:#fff;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
            border:.1rem solid rgba(0,0,0,.2);
            text-align: center;
            padding:2rem;
        }

        .services .box-container .box h3{
            font-size: 2.5rem;
            color:var(--red);
        }

        .services .box-container .box p{
            text-align: justify;
            font-size: 1.6rem;
            color: #2c2b2b;
            padding:.5rem 0;
            line-height: 2;
        }


        /* media queries  */
        @media (max-width:991px){

            html{
                font-size:55%;
            }

            header{
                padding:1.5rem 1rem;
            }

            section{
                padding:1.5rem;
            }

        }

        @media (max-width:768px){

            header .icons #menu-bars{
                display: inline-block;
            }

            header .navbar{
                position: absolute;
                left:0; right:0; top:100%;
                background:#f7f7f7;
                border-top: .1rem solid #333;
                border-bottom: .1rem solid #333;
                transition: .2s linear;
                clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
            }

            header .navbar.active{
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
            }

            header .navbar a{
                display: block;
                padding:1.5rem;
                margin:1.5rem;
                background:#fff;
                border:.1rem solid #333;
                box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
                border-radius: .5rem;
            }

        }

        @media (max-width:450px){

            html{
                font-size:50%;
            }

            .contact .row form .inputBox input{
                width: 100%;
            }

        }

    </style>

</head>
<body>

<!-- header section starts  -->

<header>

    <a href="#" class="logo"><span>matrimony</span>App</a>

    <nav class="navbar">
        <a href="#home">home</a>

    </nav>

    <div class="icons">
        <div id="menu-bars" class="fas fa-bars"></div>
        <a href="#" class="fas fa-user"></a>
    </div>

</header>

<!-- header section ends -->

<section class="services" id="services">

    <h1 class="heading"> our <span>services</span> </h1>

    <div class="box-container">

        <div class="box">
            <h3>Welcome to Muslim Matrimony - Find Your Perfect Life Partner</h3>
            <p>
                Are you a Muslim individual searching for a life partner who shares your faith and values?
                Look no further! Muslim Matrimony is an innovative and user-friendly app designed exclusively for the Muslim community,
                offering a seamless and secure platform to connect and find your ideal match.
            </p>
            <br><br>

            <h3>Why Choose Muslim Matrimony?</h3>
            <p>
                <i class="fas fa-check-circle"></i> Exclusive Muslim Community: Our app is dedicated to Muslims worldwide, providing a focused and tailored approach to finding compatible partners within the community. <br>

                <i class="fas fa-check-circle"></i> Advanced Matching Algorithms: Our intelligent matchmaking algorithms analyze your preferences, interests, and compatibility factors to suggest highly compatible profiles, increasing the likelihood of finding a perfect match. <br>

                <i class="fas fa-check-circle"></i> Secure and Private: We prioritize your privacy and ensure the utmost security of your personal information. Our platform employs strict verification processes and takes measures to maintain a safe environment for all users. <br>

                <i class="fas fa-check-circle"></i> Detailed Profiles: Gain insights into potential matches through comprehensive profiles that highlight important aspects such as religious beliefs, education, profession, family background, and more. This allows you to make informed decisions while considering a prospective partner. <br>

                <i class="fas fa-check-circle"></i> Enhanced Communication: Engage in meaningful conversations with other members through our secure messaging feature. Get to know each other better, share your values and aspirations, and build a strong foundation for a lifelong relationship. <br>

                <i class="fas fa-check-circle"></i> Community and Support: Join a vibrant community of like-minded individuals who understand the importance of faith and cultural values. Interact through forums, discussion boards, and social events, fostering connections beyond the traditional matchmaking experience. <br>

            </p>
            <br><br>

            <h3>How It Works?</h3>
            <p>
                <i class="fas fa-arrow-circle-right"></i> Sign up: Create your profile by providing essential details and preferences that will help us understand your requirements better. <br>

                <i class="fas fa-arrow-circle-right"></i> Explore Profiles: Browse through a vast database of verified profiles, filtering based on specific criteria such as age, location, education, and more. <br>

                <i class="fas fa-arrow-circle-right"></i> Connect and Communicate: Express interest, send personalized messages, and initiate conversations with potential matches. <br>

                <i class="fas fa-arrow-circle-right"></i> Get to Know Each Other: Engage in meaningful conversations, exchange photos, and build a connection to assess compatibility. <br>

                <i class="fas fa-arrow-circle-right"></i> Take the Next Step: When you find someone special, take the relationship forward by involving families, conducting meetings, and progressing towards a joyous union. <br>

                <i class="fas fa-arrow-circle-right"></i> Join Muslim Matrimony today and embark on a beautiful journey to find your life partner who shares your values, beliefs, and aspirations. Experience the convenience, privacy, and effectiveness of our platform, designed exclusively for Muslims seeking lifelong companionship. <br>
                Sign up now and let love find its way! <br>

            </p>
        </div>
    </div>

</section>



<!-- javascript part  -->
<script>

    let menu = document.querySelector('#menu-bars');
    let navbar = document.querySelector('.navbar');

    menu.onclick = () =>{
        navbar.classList.toggle('active');
        menu.classList.toggle('fa-times');
    }

    window.onscroll = () =>{
        navbar.classList.remove('active');
        menu.classList.remove('fa-times');
    }

</script>

</body>
</html>
