<?php
  ob_start();
  require($_SERVER['DOCUMENT_ROOT'] . "/static/module/core/headers.php"); 

    $_base_utils->initialize_page_compass("Videos");

    $category = "All";

    // "All", "Film & Animation", "Autos & Vehicles", "Music", "Pets & Animals", "Sports", "Travel & Events", "Gaming", "People & Blogs", "Comedy", "Entertainment", "News & Politics", "Howto & Style", "Education", "Science & Technology", "Nonprofits & Activism"
    //handle category

    if(isset($_GET['c'])) 
        $category = ($_GET['c']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SubRocks - <?php echo $_base_utils->return_current_page(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/static/css/new/www-core.css">
    </head>
    <body>
        <div class="www-core-container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/header.php"); ?>
            <div class="www-videos-left">
                <h2>Videos</h2><br>
                <ul class="videos-list">
                    <?php $categories = ["All", "Film & Animation", "Autos & Vehicles", "Music", "Pets & Animals", "Sports", "Travel & Events", "Gaming", "People & Blogs", "Comedy", "Entertainment", "News & Politics", "Howto & Style", "Education", "Science & Technology", "Nonprofits & Activism"]; ?>
                    <?php foreach($categories as $categoryTag) { ?>
                        <?php if($categoryTag == $category) { ?>
                            <li class=""><?php echo $categoryTag; ?></li>
                        <?php } else { ?>
                            <li class=""><a href="/videos?c=<?php echo urlencode($categoryTag); ?>"><?php echo $categoryTag; ?></a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <div class="www-videos-right">
                <h3><?php echo htmlspecialchars($category); ?></h3>
                <div class="videos-box">
                    <div class="videos-title-box-browse">
                    
                    </div>
                    <div class="videos-title-box-contents">
                            <?php
                            if($category != "All") { 
                                $stmt56 = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos WHERE category = ? ORDER BY id DESC");
                                $stmt56->bind_param("s", $category);
                                $stmt56->execute();
                                $result854 = $stmt56->get_result();
                                $result56 = $result854->num_rows;
                            } else {
                                $stmt56 = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos ORDER BY id DESC");
                                $stmt56->execute();
                                $result854 = $stmt56->get_result();
                                $result56 = $result854->num_rows;
                            }
                            ?>
                            <?php
                            $results_per_page = 20;

                            if($category != "All") { 
                                $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos WHERE category = ? ORDER BY id DESC");
                                $stmt->bind_param("s", $category);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $results = $result->num_rows;
                            } else {
                                $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos ORDER BY id DESC");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $results = $result->num_rows;
                            }

                            $number_of_result = $result->num_rows;
                            $number_of_page = ceil ($number_of_result / $results_per_page);  

                            if (!isset ($_GET['page']) ) {  
                                $page = 1;  
                            } else {  
                                $page = (int)$_GET['page'];  
                            }  

                            $page_first_result = ($page - 1) * $results_per_page;  

                            $stmt->close();

                            if($category != "All") { 
                                $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos WHERE category = ? ORDER BY id DESC LIMIT ?, ?");
                                $stmt->bind_param("sss", $category, $page_first_result, $results_per_page);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            } else { 
                                $stmt = $conn->prepare("SELECT rid, title, thumbnail, duration, title, author, publish, description FROM videos ORDER BY id DESC LIMIT ?, ?");
                                $stmt->bind_param("ss", $page_first_result, $results_per_page);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            }

                            while($video = $result->fetch_assoc()) { 
                                $video['stars'] = $_video_fetch_utils->get_video_stars($video['rid']);
                                $video['star_1'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 1);
                                $video['star_2'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 2);
                                $video['star_3'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 3);
                                $video['star_4'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 4);
                                $video['star_5'] = $_video_fetch_utils->get_video_stars_level($video['rid'], 5);
                            
                                if($video['stars'] != 0) {
                                    @$video['star_ratio'] = (
                                        $video['star_5'] * 5 + 
                                        $video['star_4'] * 4 + 
                                        $video['star_3'] * 3 + 
                                        $video['star_2'] * 2 + 
                                        $video['star_1'] * 1
                                    ) / (
                                        $video['star_5'] + 
                                        $video['star_4'] + 
                                        $video['star_3'] + 
                                        $video['star_2'] + 
                                        $video['star_1']
                                    );
                            
                                    $video['star_ratio'] = floor($video['star_ratio'] * 2) / 2;
                                } else { 
                                    $video['star_ratio'] = 0;
                                }
								$constructVideoGrid($video);
                                ?>
                            
                        <?php } ?>
                    </div>
                </div>

                <center>
                <?php for($page = 1; $page<= $number_of_page; $page++) {  ?>
                    <a href="videos?category=<?php echo urlencode($category); ?>&page=<?php echo $page ?>"><span class="yt-uix-button-content"><?php echo $page; ?></span></a>&nbsp;
                <?php } ?>
                </center>  
            </div>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>

    </body>
</html>
<?php
	ob_end_flush();