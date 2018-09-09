<?php
include("../../config.php");
if (isset($_POST['submit_btn'])) {

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
//email exist checking
        $check = "SELECT * FROM subscribers WHERE email = '$email'";
        $rs = mysqli_query($con, $check);
        if (!$rs || mysqli_num_rows($rs) == 0) {
            $subscribed_date = date("Y-m-d H:i:s");
// save the data to the database
            mysqli_query($con, "INSERT subscribers SET name='$name', email='$email', subscribed_date='$subscribed_date'")

                or die(mysqli_error($con));
//                header("Location: manage_users.php");
            echo "<script>alert('Successfully subscribed');
              window.location.href='index.php';
              </script>";
//header("Location: index.php");
        } else {
            echo "<script>alert('Email Already Exists');window.location.href='index.php';</script>";
        }
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
        <!--<link rel="stylesheet" type="text/css" href="css/slider-pro.min.css" media="screen" />-->
        <link rel="stylesheet" type="text/css" href="./slick/slick.css">
        <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <style type="text/css">
            #html5-watermark {
                display:none !important;
            }
        </style>
        <script type="text/javascript" src="./plugin/html5lightbox/jquery.js"></script>
        <script type="text/javascript" src="./plugin/html5lightbox/html5lightbox.js"></script>
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
//                    $condition .= " AND at.article_published ='1' AND at.user_id='1'";
                    $condition .= " AND at.user_id='1' AND at.is_featured='0' AND at.is_trending='0'";
                    $sql = "SELECT at.id, at.article_title, at.article_content,ai.image_url,at.article_summary,at.created_at FROM article as at LEFT JOIN article_image ai ON at.id=ai.article_ID where 1=1" . $condition . " GROUP BY at.id ORDER BY at.created_at desc limit 50 offset 0";
                    $query = mysqli_query($con, $sql);
                    if ($query && mysqli_num_rows($query) != 0) {
                        $row = mysqli_fetch_all($query);
                        //print_r($row[0]);exit;
                    }
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);

                    ?>
                    <div class="col-lg-12">
                        <div class="row">
                            <section class="lazy slider" data-sizes="50vw">


                                <div class="slide-list-wrap">
                                    <div class="col-lg-6 slide-lg">
                                        <div class="row">
                                            <?php
                                            $p = 0;
                                            $set = 0;
                                            while ($p < count($row) && $set == 0) {
                                                $img_org = $row[$p][3] ? "../../uploads/articles/" . $row[$p][0] . '/' . $row[$p][3] : '';
                                                $img_src = file_exists("../../uploads/articles/" . $row[$p][0] . '/' . $row[$p][3]) ? $img_org : './images/no_images.jpg';

                                                $file_type1 = $row[$p][3] ? finfo_file($finfo, "../../uploads/articles/" . $row[$p][0] . '/' . $row[$p][3]) : '';
                                                if (strstr($file_type1, "image/") || !$row[$p][3]) {

                                                    ?>
                                                    <a href="./post_details.php?id=<?php echo $row[$p][0]; ?>"><img src="<?php echo $img_src ?>"></a>;
                                                    <div class="slide-news-wrap">
                                                        <div class="category-label"><?php echo $row[$p][1] ?></div>
                                                        <h1 class="slide-title"><?php echo $row[$p][4] ?></h1>
                                                        <div class="post-date"><?php echo date('d/m/y', strtotime($row[$p][5])) ?></div>
                                                    </div>
                                                    <?php
                                                    $set = 1;
                                                } $p++;
                                            }

                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12" style="float:left">
                                        <div class="row">

                                            <?php
                                            $j = $p;
                                            $set2 = 0;
                                            while ($j < count($row) && $set2 < 4) {
                                                $img_org = $row[$j][3] ? "../../uploads/articles/" . $row[$j][0] . '/' . $row[$j][3] : '';
                                                $img_src = file_exists("../../uploads/articles/" . $row[$j][0] . '/' . $row[$j][3]) ? $img_org : './images/no_images_small.jpg';
                                                $file_type = $row[$j][3] ? finfo_file($finfo, "../../uploads/articles/" . $row[$j][0] . '/' . $row[$j][3]) : '';
                                                if (strstr($file_type, "image/") || !$row[$j][3]) {

                                                    ?>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 slide-sm">
                                                        <div class="row">
                                                            <a href="./post_details.php?id=<?php echo $row[$j][0]; ?>"><img src="<?php echo $img_src; ?>"></a>
                                                            <div class="slide-news-wrap">
                                                                <div class="category-label"><?php echo $row[$j][1] ?></div>
                                                                <h1 class="slide-title"><?php echo $row[$j][4] ?></h1>
                                                                <div class="post-date"><?php echo date('d/m/y', strtotime($row[$j][5])) ?></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <?php
                                                    $set2++;
                                                } $j++;
                                            }

                                            ?>
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
                <?php
                $condition1 = '';
//                    $condition .= " AND at.article_published ='1' AND at.user_id='1'";
                $condition1 .= " AND at.user_id='1' AND at.is_featured='1'";
                $sql = "SELECT at.id, at.article_title, at.article_content,ai.image_url,at.article_summary,at.created_at FROM article as at LEFT JOIN article_image ai ON at.id=ai.article_ID where 1=1" . $condition1 . " GROUP BY at.id ORDER BY at.created_at desc limit 50 offset 0";
                $query = mysqli_query($con, $sql);
                if ($query && mysqli_num_rows($query) != 0) {
                    $rowFeatured = mysqli_fetch_all($query);
                    //print_r($row[0]);exit;
                }

                ?>
                <div class="row">
                    <?php
                    $setFeat = 0;
                    for ($k = 0; $k < count($rowFeatured) && $setFeat < 8; $k++) {
                        if (!empty($rowFeatured[$k])) {
                            $img_org = $rowFeatured[$k][3] ? "../../uploads/articles/" . $rowFeatured[$k][0] . '/' . $rowFeatured[$k][3] : '';
                            $img_src = file_exists("../../uploads/articles/" . $rowFeatured[$k][0] . '/' . $rowFeatured[$k][3]) ? $img_org : './images/no_images_small.jpg';

                            $file_type_feat = $rowFeatured[$k][3] ? finfo_file($finfo, "../../uploads/articles/" . $rowFeatured[$k][0] . '/' . $rowFeatured[$k][3]) : '';
                            if (strstr($file_type_feat, "image/") || !$rowFeatured[$k][3]) {

                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                                    <div class="card h-100">
                                        <a href="./post_details.php?id=<?php echo $rowFeatured[$k][0]; ?>"><img class="card-img-top" src="<?php echo $img_src; ?>" alt=""></a>
                                        <div class="card-body">
                                            <div class="category-label"><?php echo $rowFeatured[$k][1]; ?></div>
                                            <p class="card-text"><?php echo $rowFeatured[$k][4]; ?></p>
                                            <div class="post-date"><?php echo date('d/m/y', strtotime($rowFeatured[$k][5])); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $setFeat++;
                            }
                            if ($rowFeatured[$k][3] && !(strstr($file_type_feat, "image/"))) {

                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                                    <div class="card h-100">
                                        <a href="./post_details.php?id=<?php echo $rowFeatured[$k][0]; ?>"><img class="card-img-top" src="./images/no_images_small.jpg" alt=""></a>
                                        <div class="card-body">
                                            <div class="category-label"><?php echo $rowFeatured[$k][1]; ?></div>
                                            <p class="card-text"><?php echo $rowFeatured[$k][4]; ?></p>
                                            <div class="post-date"><?php echo date('d/m/y', strtotime($rowFeatured[$k][5])); ?></div>
                                        </div>
                                    </div>
                                </div>


                                <?php
                                $setFeat++;
                            }
                        } else {

                            ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                                <div class="card h-100">
                                    <a href="#"><img class="card-img-top" src="./images/no_images_small.jpg" alt=""></a>
                                    <div class="card-body">
                                        <div class="category-label">No Article Exist</div>
                                        <p class="card-text"></p>
                                        <div class="post-date"></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $setFeat++;
                        }
                    }

                    ?>

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
                            <?php
                            $condition2 = '';
                            $setTrend = 0;
//                    $condition .= " AND at.article_published ='1' AND at.user_id='1'";
                            $condition2 .= " AND at.user_id='1' AND at.is_trending='1'";
                            $sqlTrend = "SELECT at.id, at.article_title, at.article_content,ai.image_url,at.article_summary,at.created_at FROM article as at LEFT JOIN article_image ai ON at.id=ai.article_ID where 1=1" . $condition2 . " GROUP BY at.id ORDER BY at.created_at desc limit 50 offset 0";
                            $queryTrend = mysqli_query($con, $sqlTrend);
                            if ($query && mysqli_num_rows($queryTrend) != 0) {
                                $rowTrend = mysqli_fetch_all($queryTrend);
                                //print_r($row[0]);exit;
                            }

                            for ($l = 0; $l < 3 && $setTrend < 4; $l++) {
                                if (!empty($rowTrend[$l])) {
                                    $img_org = $rowTrend[$l][3] ? "../../uploads/articles/" . $rowTrend[$l][0] . '/' . $rowTrend[$l][3] : '';
                                    $img_src = file_exists("../../uploads/articles/" . $rowTrend[$l][0] . '/' . $rowTrend[$l][3]) ? $img_org : './images/no_images_small.jpg';

                                    $file_type_feat = $rowTrend[$l][3] ? finfo_file($finfo, "../../uploads/articles/" . $rowTrend[$l][0] . '/' . $rowTrend[$l][3]) : '';
                                    if (strstr($file_type_feat, "image/") || !$rowTrend[$l][3]) {

                                        ?>
                                        <div class="col-lg-4 col-md-4 col-sm-6 portfolio-item">
                                            <div class="card h-100">
                                                <a href="./post_details.php?id=<?php echo $rowTrend[$l][0]; ?>"><img class="card-img-top" src="<?php echo $img_src; ?>" alt=""></a>
                                                <div class="card-body">
                                                    <div class="category-label"><?php echo $rowTrend[$l][1] ?></div>
                                                    <p class="card-text"><?php echo $rowTrend[$l][4] ?></p>
                                                    <div class="post-date"><?php echo date('d/m/y', strtotime($rowTrend[$l][5])) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $setTrend++;
                                    }
                                    if ($rowTrend[$l][3] && !(strstr($file_type_feat, "image/"))) {

                                        ?>
                                        <div class="col-lg-4 col-md-4 col-sm-6 portfolio-item">
                                            <div class="card h-100">
                                                <a href="./post_details.php?id=<?php echo $rowTrend[$l][0]; ?>"><img class="card-img-top" src="./images/no_images_small.jpg" alt=""></a>
                                                <div class="card-body">
                                                    <div class="category-label"><?php echo $rowTrend[$l][1] ?></div>
                                                    <p class="card-text"><?php echo $rowTrend[$l][4] ?></p>
                                                    <div class="post-date"><?php echo date('d/m/y', strtotime($rowTrend[$l][5])) ?></div>
                                                </div>
                                            </div>
                                        </div>


                                        <?php
                                        $setTrend++;
                                    }
                                } else {

                                    ?>
                                    <div class="col-lg-4 col-md-4 col-sm-6 portfolio-item">
                                        <div class="card h-100">
                                            <a href="#"><img class="card-img-top" src="./images/no_images_small.jpg" alt=""></a>
                                            <div class="card-body">
                                                <div class="category-label">No Article Exist</div>
                                                <p class="card-text"> </p>
                                                <div class="post-date"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $setTrend++;
                                }
                            }

                            ?>
                        </div>

                        <div class="col-md-7 row">
                            <h2 class="sub-head clear-both width100pers"><span class="orange-txt">Featured</span> Videos and Images</h2>
                            <div class="row">
                                <div class="col-lg-12 col-sm-6 portfolio-item">
                                    <?php
                                    $condition = '';
                                    $imgVideo = 0;
//                    $condition .= " AND at.article_published ='1' AND at.user_id='1'";
                                    $condition .= " AND at.user_id='1' AND at.is_featured='1' AND ai.image_url != ''";
                                    $sql = "SELECT at.id, at.article_title, at.article_content,ai.image_url,at.article_summary,at.created_at FROM article as at LEFT JOIN article_image ai ON at.id=ai.article_ID where 1=1" . $condition . " GROUP BY at.id ORDER BY at.created_at desc limit 6 offset 0";
                                    $query = mysqli_query($con, $sql);
                                    if ($query && mysqli_num_rows($query) != 0) {
                                        $rowImgVid = mysqli_fetch_all($query);
                                        //print_r($row[0]);exit;
                                    }
                                    // $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                    for ($x = 0; $x < count($rowImgVid) && $imgVideo < 4; $x++) {
                                        if (!empty($rowImgVid[$x])) {
                                            $file_type = finfo_file($finfo, "../../uploads/articles/" . $rowImgVid[$x][0] . '/' . $rowImgVid[$x][3]);
                                            if (strstr($file_type, "video/")) {

                                                ?>
                                                <div class="featured-block-wrap">
                                                    <div class="featured-block-media" ><div class="media-type"><i class="fa fa-play"></i></div><a href="../../uploads/articles/<?php echo $rowImgVid[$x][0] . '/' . $rowImgVid[$x][3] ?>" class="html5lightbox" data-width="480" data-height="320" title="<?php echo $rowImgVid[$x][1] ?>"><img class="card-img-top" src="./images/play_vid.png" alt=""></a></div>
                                                    <div class="featured-block-txt" >
                                                        <div class="category-label"><?php echo $rowImgVid[$x][1] ?></div>
                                                        <p class="card-text"><?php echo $rowImgVid[$x][4] ?></p>
                                                        <div class="post-date"><?php echo date('d/m/y', strtotime($rowImgVid[$x][5])) ?></div>
                                                    </div>
                                                </div>
                                                <?php
                                                $imgVideo++;
                                            } else if (strstr($file_type, "image/")) {

                                                ?>
                                                <div class="featured-block-wrap">
                                                    <div class="featured-block-media" ><div class="media-type"><i class="fa fa-camera"></i></div><a href="../../uploads/articles/<?php echo $rowImgVid[$x][0] . '/' . $rowImgVid[$x][3] ?>" class="html5lightbox" data-width="480" data-height="320" title="<?php echo $rowImgVid[$x][1] ?>"><img class="card-img-top" src="../../uploads/articles/<?php echo $rowImgVid[$x][0] . '/' . $rowImgVid[$x][3] ?>" alt=""></a></div>
                                                    <div class="featured-block-txt" >
                                                        <div class="category-label"><?php echo $rowImgVid[$x][1] ?></div>
                                                        <p class="card-text"><?php echo $rowImgVid[$x][4] ?></p>
                                                        <div class="post-date"><?php echo date('d/m/y', strtotime($rowImgVid[$x][5])) ?></div>
                                                    </div>
                                                </div>

                                                <?php
                                                $imgVideo++;
                                            }
                                        }
                                    }

                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-5 pl25 pr0">
                            <h2 class="sub-head clear-both width100pers"><span class="orange-txt">Recent</span> News
                            </h2><div class="row">

                                <?php
                                $condition = '';
//                    $condition .= " AND at.article_published ='1' AND at.user_id='1'";
                                $condition .= " AND at.user_id='1' AND at.is_featured='0' AND at.is_trending='0'";
                                $sql = "SELECT at.id, at.article_title, at.article_content,ai.image_url,at.article_summary,at.created_at FROM article as at LEFT JOIN article_image ai ON at.id=ai.article_ID where 1=1" . $condition . " GROUP BY at.id ORDER BY at.created_at desc limit 50 offset 0";
                                $query = mysqli_query($con, $sql);
                                if ($query && mysqli_num_rows($query) != 0) {
                                    $rowRecent = mysqli_fetch_all($query);
                                    //print_r($row[0]);exit;
                                }
                                $setRec = 1;
                                for ($m = 0; $m < 50 && $setRec < 9; $m++) {
                                    if (!empty($rowRecent[$m])) {
                                        $file_type2 = ($rowRecent[$m][3] && file_exists("../../uploads/articles/" . $rowRecent[$m][0] . '/' . $rowRecent[$m][3])) ? finfo_file($finfo, "../../uploads/articles/" . $rowRecent[$m][0] . '/' . $rowRecent[$m][3]) : '';
                                        if (strstr($file_type2, "image/")) {

                                            $img_org = $rowRecent[$m][3] ? "../../uploads/articles/" . $rowRecent[$m][0] . '/' . $rowRecent[$m][3] : '';
                                            $img_src = file_exists("../../uploads/articles/" . $rowRecent[$m][0] . '/' . $rowRecent[$m][3]) ? $img_org : './images/no_images_small.jpg';

                                            ?>
                                            <div class="col-md-6 portfolio-item pr0">
                                                <div class="card h-100">
                                                    <a href="./post_details.php?id=<?php echo $rowRecent[$m][0]; ?>"><img class="card-img-top" src="<?php echo $img_src; ?>" alt=""></a>
                                                    <div class="card-body">
                                                        <div class="category-label"><?php echo $rowRecent[$m][1] ?></div>
                                                        <p class="card-text"><?php echo $rowRecent[$m][4] ?> </p>
                                                        <div class="post-date"><?php echo date('d/m/y', strtotime($rowRecent[$m][5])) ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $setRec++;
                                        } else {

                                            ?>
                                            <div class="col-md-6 portfolio-item pr0">
                                                <div class="card h-100">
                                                    <a href="./post_details.php?id=<?php echo $rowRecent[$m][0]; ?>"><img class="card-img-top" src="./images/no_images_small.jpg" alt=""></a>
                                                    <div class="card-body">
                                                        <div class="category-label"><?php echo $rowRecent[$m][1] ?></div>
                                                        <p class="card-text"><?php echo $rowRecent[$m][4] ?> </p>
                                                        <div class="post-date"><?php echo date('d/m/y', strtotime($rowRecent[$m][5])) ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        $setRec++;
                                    }
                                }

                                ?>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-3 pr0 pl25"><h2 class="sub-head clear-both width100pers">Get Our Daily Newsletter</h2>
                    <form id="subscriberAdd" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                        <div class="newsletter-wrap">
                            <input class="form-control" id='sub_name' type="text" name='sub_name' placeholder="Name" id="">
                            <input class="form-control" id='sub_email' type="text" name='sub_email' placeholder="Email" id="">
                            <input class="form-control submit" onclick="return validate()" type="submit" name="submit_btn" value="Subscribe" id="">

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
                        <?php
                        $sql_sub = "SELECT sub.subject_name FROM subject as sub ORDER BY sub.id desc limit 5 offset 0";
                        $query = mysqli_query($con, $sql_sub);
                        if ($query && mysqli_num_rows($query) != 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<li>" . $row['subject_name'] . "</li>";
                            }
                        }

                        ?>
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
                <div class="col-md-3 pl0"><h3>Topics</h3>
                    <ul>
                        <?php
                        $sql_tp = "SELECT tp.topic_name FROM topic as tp ORDER BY tp.id desc limit 5 offset 0";
                        $query = mysqli_query($con, $sql_tp);
                        if ($query && mysqli_num_rows($query) != 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<li>" . $row['topic_name'] . "</li>";
                            }
                        }

                        ?>
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
        <!--<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>-->
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
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (re.test(String(email).toLowerCase()))
                return true;
            else {
                alert('Invalid email!');
                return false
            }
        }
    }
</script>
