<?php
include("../../config.php");
$article_id = $_GET['id'];
//echo $article_id;

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
        <!--<link rel="stylesheet" type="text/css" href="css/slider-pro.min.css" media="screen" />-->
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
                                <a class="nav-link" href="../home">HOME
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
                        <!--<div class="search-top"><input class="form-control" type="text" placeholder="SEARCH..." id="search"><span class="search-icon"><i class="fa fa-search"></i></span></div>-->

                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <?php
        $condition = '';
//                    $condition .= " AND at.article_published ='1' AND at.user_id='1'";
        $condition .= " AND at.id=$article_id";
        $sql = "SELECT at.id, at.article_title, at.article_content,ai.image_url,at.article_summary,at.created_at,at.article_content FROM article as at LEFT JOIN article_image ai ON at.id=ai.article_ID where 1=1" . $condition;
        $query = mysqli_query($con, $sql);
        if ($query && mysqli_num_rows($query) != 0) {
            $row = mysqli_fetch_assoc($query);
            //print_r($row);exit;
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        ?>
        <div class="container post-details-page-wrap">
            <div class="row">
                <div class="col-md-9">
                    <?php
                    $file_type = ($row['image_url'] && file_exists("../../uploads/articles/" . $row['id'] . '/' . $row['image_url'])) ? finfo_file($finfo, "../../uploads/articles/" . $row['id'] . '/' . $row['image_url']) : '';
                    $img_org = $row['image_url'] ? "../../uploads/articles/" . $row['id'] . '/' . $row['image_url'] : '';
                    $img_src = (file_exists("../../uploads/articles/" . $row['id'] . '/' . $row['image_url']) && (strstr($file_type, "image/"))) ? $img_org : './images/no_images.jpg';

                    ?>
                    <div class="post-details-thumb-img"><img src="<?php echo $img_src ?>"></div>

                    <div class="post-details-title">
                        <div class="category-label"><?php echo $row['article_title'] ?> </div><div class="post-date"><?php echo date('d/m/y', strtotime($row['created_at'])) ?></div>
                        <h1><?php echo $row['article_summary'] ?></h1>

                    </div>
                    <div class="post-details">	

                        <p><?php echo $row['article_content'] ?></p>

                    </div>
                </div>
                   <div class="col-md-3">
                       <!--<h2 class="sub-head clear-both width100pers mt0">Get Our Daily Newsletter</h2>-->
<!--                                    <form id="subscriberAdd" method="POST" action="">
                                        <div class="newsletter-wrap">
                                            <input class="form-control" id="sub_name" type="text" name="sub_name" placeholder="Name">
                                            <input class="form-control" id="sub_email" type="text" name="sub_email" placeholder="Email">
                                            <input class="form-control submit" onclick="return validate()" type="submit" name="submit_btn" value="Subscribe" id="">
                
                                        </div>
                                    </form>-->
                                    <div class="ads-home-right">
                                        <img src="images/ads.png" style="margin-bottom: 30px;">
                                        <img src="images/ads.png">
                                    </div></div>
            </div>
        </div>
        <!-- /.container -->
<!--        <div class="container footer-content">
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
                    <li><i class="fa fa-g-plus"></i></li>
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
            </div>-->
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