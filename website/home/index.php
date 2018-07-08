<?php
include("../../config.php");
if (isset($_POST['sub_name']) && isset($_POST['sub_email'])) {

// get form data, making sure it is valid
    $name = mysqli_real_escape_string($con, htmlspecialchars($_POST['sub_name']));

    $email = mysqli_real_escape_string($con, htmlspecialchars($_POST['sub_email']));

// check to make sure both fields are entered

    if ($name == '' || $email == '') {

// generate error message

        $error = 'ERROR: Please Enter Name and Email!';



// if either field is blank, display the form again
//renderForm($firstname, $lastname, $error);
    } else {
        $subscribed_date = date("Y-m-d H:i:s");
// save the data to the database
        mysqli_query($con, "INSERT subscribers SET name='$name', email='$email', subscribed_date='$subscribed_date'")

            or die(mysqli_error($con));
//                header("Location: manage_users.php");
        echo '<script type="text/javascript">';
        echo "alert('Successfully subscribed')";
        //echo 'window.location.href="index.php";';
        echo '</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>4 Col Portfolio - Start Bootstrap Template</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


        <!-- Custom styles for this template -->
        <link href="css/4-col-portfolio.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/custom.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/slider-pro.min.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./slick/slick.css">
        <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <style type="text/css">
        </style>
    </head>

    <body>

        <!-- Navigation -->
        <div class="container-fluid nav-header">
            <div class="container  clear">
                <ul class="header-social">
                    <li>SIGN IN</li>
                    <li>SIGN UP</li>

                    <li><i class="fa fa-twitter"></i></li>
                    <li><i class="fa fa-facebook-f"></i></li>
                </ul>
            </div>
        </div>
        <div class="full-width-wrap">
            <div class="container"> <a class="navbar-brand" href="#"><img src="images/agripunt_logo.png"></a></div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark ">


            <div class="full-width-wrap">
                <div class="container"><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">HOME
                                    <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">CATEGORIES</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">TOPICS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">VIDEOS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">PARTNERS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">CONTACT</a>
                            </li>
                        </ul>
                        <div class="search-top"><input class="form-control" type="text" placeholder="SEARCH..." id="search"><span class="search-icon"><i class="fa fa-search"></i></span></div>

                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="slider-wrap">
            <div class="container ">
                <div class="row ">
                    <ul class="latest-news">
                        <li>Latest News</li>
                        <li><a href="£">Automation in agriculture using microcontroler</a></li>
                        <li><a href="£">Biosensor use in agriculture</a></li>
                        <li><a href="£">Chinampa agriculture</a></li>
                        <li><a href="£">Climate effects in farming systems</a></li>
                        <li><a href="£">Agro based industries</a></li>
                    </ul>
                    <!-- Slider Starts -->
                    <?php
                    $condition = '';
                    $condition .= " AND at.article_published ='1'";
                    $sql = "SELECT at.id, at.article_title, at.article_content,ai.image_url,at.article_pubdate FROM article as at LEFT JOIN article_image ai ON at.id=ai.article_ID where 1=1" . $condition . " ORDER BY at.created_at ASC limit 5 offset 0";
                    $query = mysqli_query($con, $sql);
                    if ($query && mysqli_num_rows($query) != 0) {
                        $row = mysqli_fetch_all($query);
                        // print_r($row);exit;
                    }

                    ?>
                    <div class="col-lg-12">
                        <div class="row">
                            <section class="lazy slider" data-sizes="50vw">


                                <div class="slide-list-wrap">
                                    <div class="col-lg-6 slide-lg">
                                        <div class="row">
                                            <img src="<?php echo $row[0][3] ?>">
                                            <div class="slide-news-wrap">
                                                <div class="category-label"><?php echo $row[0][1] ?></div>
                                                <h1 class="slide-title"><?php echo $row[0][1] ?></h1>
                                                <div class="post-date"><?php echo $row[0][4] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12" style="float:left">
                                        <div class="row">


                                            <div class="col-lg-6 col-md-6 col-sm-12 slide-sm">
                                                <div class="row">
                                                    <img src="<?php echo $row[1][3] ?>">
                                                    <div class="slide-news-wrap">
                                                        <div class="category-label"><?php echo $row[1][1] ?></div>
                                                        <h1 class="slide-title"><?php echo $row[1][1] ?></h1>
                                                        <div class="post-date"><?php echo $row[1][4] ?></div>
                                                    </div>

                                                </div>
                                            </div>



                                            <div class="col-lg-6  col-md-6 col-sm-12 slide-sm">
                                                <div class="row">
                                                    <img src="<?php echo $row[2][3] ?>">
                                                    <div class="slide-news-wrap">
                                                        <div class="category-label"><?php echo $row[2][1] ?></div>
                                                        <h1 class="slide-title"><?php echo $row[2][1] ?></h1>
                                                        <div class="post-date"><?php echo $row[2][4] ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6  col-md-6 col-sm-12 slide-sm">
                                                <div class="row"> <img src="images/img3.png">
                                                    <div class="slide-news-wrap">
                                                        <div class="category-label">Label</div>
                                                        <h1 class="slide-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </h1>
                                                        <div class="post-date">10/11/2017</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6  col-md-6 col-sm-12 slide-sm">
                                                <div class="row"> <img src="images/img4.png">
                                                    <div class="slide-news-wrap">
                                                        <div class="category-label">Label</div>
                                                        <h1 class="slide-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </h1>
                                                        <div class="post-date">10/11/2018</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>





                            </section>




                        </div>
                    </div>


                    <!-- Slider Ends -->
                </div></div>
        </div>
        <div class="container">
            <div class="row">
                <!-- Page Heading -->
                <h2 class="sub-head"><span class="orange-txt">Featured</span> News
                </h2>

                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                        <div class="card h-100">
                            <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                            <div class="card-body">
                                <div class="category-label">Label</div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="post-date">10/11/2017</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                        <div class="card h-100">
                            <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                            <div class="card-body">
                                <div class="category-label">Label</div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="post-date">10/11/2017</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                        <div class="card h-100">
                            <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                            <div class="card-body">
                                <div class="category-label">Label</div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="post-date">10/11/2017</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                        <div class="card h-100">
                            <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                            <div class="card-body">
                                <div class="category-label">Label</div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="post-date">10/11/2017</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                        <div class="card h-100">
                            <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                            <div class="card-body">
                                <div class="category-label">Label</div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="post-date">10/11/2017</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                        <div class="card h-100">
                            <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                            <div class="card-body">
                                <div class="category-label">Label</div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="post-date">10/11/2017</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                        <div class="card h-100">
                            <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                            <div class="card-body">
                                <div class="category-label">Label</div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="post-date">10/11/2017</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                        <div class="card h-100">
                            <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                            <div class="card-body">
                                <div class="category-label">Label</div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="post-date">10/11/2017</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->


            </div>
        </div>
        <!-- /.container -->
        <div class="container">



            <div class="row">

                <div class="col-md-9">

                    <div class="row">
                        <!-- Page Heading -->
                        <h2 class="sub-head  clear-both width100pers"><span class="orange-txt">Trending</span> Topics
                        </h2><div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 portfolio-item">
                                <div class="card h-100">
                                    <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                                    <div class="card-body">
                                        <div class="category-label">Label</div>
                                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                        <div class="post-date">10/11/2017</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 portfolio-item">
                                <div class="card h-100">
                                    <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                                    <div class="card-body">
                                        <div class="category-label">Label</div>
                                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                        <div class="post-date">10/11/2017</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 portfolio-item">
                                <div class="card h-100">
                                    <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                                    <div class="card-body">
                                        <div class="category-label">Label</div>
                                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                        <div class="post-date">10/11/2017</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7 row">
                            <h2 class="sub-head clear-both width100pers"><span class="orange-txt">Featured</span> Videos and Images</h2>
                            <div class="row">
                                <div class="col-lg-12 col-sm-6 portfolio-item">
                                    <div class="featured-block-wrap">


                                        <div class="featured-block-media" ><div class="media-type"><i class="fa fa-camera"></i></div><a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a></div>



                                        <div class="featured-block-txt" >
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet,  eliteps  ipsum .  </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div>
                                    <div class="featured-block-wrap">


                                        <div class="featured-block-media" ><div class="media-type"><i class="fa fa-play"></i></div><a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a></div>



                                        <div class="featured-block-txt" >
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet adipisicing elit. </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div><div class="featured-block-wrap">


                                        <div class="featured-block-media" ><div class="media-type"><i class="fa fa-camera"></i></div><a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a></div>



                                        <div class="featured-block-txt" >
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet,  eliteps  ipsum . </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div><div class="featured-block-wrap">


                                        <div class="featured-block-media" ><div class="media-type"><i class="fa fa-play"></i></div><a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a></div>



                                        <div class="featured-block-txt" >
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet,  eliteps  ipsum . </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div>
                                    <div class="featured-block-wrap">


                                        <div class="featured-block-media" ><div class="media-type"><i class="fa fa-play"></i></div><a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a></div>



                                        <div class="featured-block-txt" >
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet,  eliteps  ipsum . </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div>
                                    <div class="featured-block-wrap">


                                        <div class="featured-block-media" ><div class="media-type"><i class="fa fa-play"></i></div><a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a></div>



                                        <div class="featured-block-txt" >
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet,  eliteps  ipsum . </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="col-md-5 pl25 pr0">
                            <h2 class="sub-head clear-both width100pers"><span class="orange-txt">Recent</span> News
                            </h2><div class="row">
                                <div class="col-md-6 portfolio-item pr0">
                                    <div class="card h-100">
                                        <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                                        <div class="card-body">
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 portfolio-item pr0">
                                    <div class="card h-100">
                                        <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                                        <div class="card-body">
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-md-6 portfolio-item pr0">
                                    <div class="card h-100">
                                        <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                                        <div class="card-body">
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 portfolio-item pr0">
                                    <div class="card h-100">
                                        <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                                        <div class="card-body">
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 portfolio-item pr0">
                                    <div class="card h-100">
                                        <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                                        <div class="card-body">
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 portfolio-item pr0">
                                    <div class="card h-100">
                                        <a href="#"><img class="card-img-top" src="images/3.jpg" alt=""></a>
                                        <div class="card-body">
                                            <div class="category-label">Label</div>
                                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                            <div class="post-date">10/11/2017</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-3 pr0 pl25"><h2 class="sub-head clear-both width100pers">Get Our Daily Newsletter</h2>
                    <form id="subscriberAdd" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                        <div class="newsletter-wrap">
                            <input class="form-control" id='sub_name' type="text" name='sub_name' placeholder="Name" id="">
                            <input class="form-control" id='sub_email' type="text" name='sub_email' placeholder="Email" id="">
                            <input class="form-control submit" onclick="return validate()" type="submit" value="Subscribe" id="">

                        </div>
                    </form>
                    <div class="ads-home-right">
                        <img src="images/ads.png" style="margin-bottom: 30px;">
                        <img src="images/ads.png">
                    </div>
                </div>


            </div>
            <!-- /.row -->



        </div>
        <!-- /.container -->
        <div class="container footer-content">
            <div class="row">
                <div class="col-md-3 pl0"><h3>Top Categories</h3>
                    <ul>
                        <li>Poultry</li>
                        <li>Pigs</li>
                        <li>Milk Prices</li>
                        <li>Egg Prices</li>
                        <li>Poultry</li>
                    </ul>
                </div>
                <div class="col-md-6 pl0"><h3>About Agripunt</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.Lorem ipsum dolor sit amet, consectetur adipisicing elit.Lorem ipsum dolor sit amet, consectetur adipisicing elit.Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.Lorem ipsum dolor sit amet, consectetur adipisicing elit.Lorem ipsum dolor sit amet, consectetur adipisicing elit.Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    <ul class="footer-social">
                        <li><i class="fa fa-twitter"></i></li>
                        <li><i class="fa fa-facebook"></i></li>
                        <li><i class="fa fa-linkedin"></i></li>
                        <!--<li><i class="fa fa-g-plus"></i></li>-->
                        <li><i class="fa fa-vimeo"></i></li>
                        <li><i class="fa fa-youtube"></i></li>
                    </ul>
                </div>
                <div class="col-md-3 pl0"><h3>Trending Topics</h3>
                    <ul>
                        <li>Poultry</li>
                        <li>Pigs</li>
                        <li>Milk Prices</li>
                        <li>Egg Prices</li>
                        <li>Poultry</li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- Footer -->
        <footer class=" bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; Agripunt 2017</p>
            </div>
            <!-- /.container -->
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="./slick/slick.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
                                $(document).on('ready', function () {
                                    $(".lazy").slick({
                                        lazyLoad: 'ondemand', // ondemand progressive anticipated
                                        infinite: true
                                    });
                                });
        </script>


    </body>

</html>
<script type="text/javascript">
    function validate() {
        var name = document.getElementById('sub_name').value;
        var email = document.getElementById('sub_email').value;

        if (!name || !email) {
            alert('Please fill in name and email!');
            return false;
        } else {
            return true;
        }
    }
</script>