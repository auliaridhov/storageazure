<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Computer Vision</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/grayscale.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Computer Vision</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#projects">Projects</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#signup">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead">
    <div class="container d-flex h-100 align-items-center">
      <div class="mx-auto text-center">
        <h1 class="mx-auto my-0 text-uppercase">Computer Vison</h1>
        <h2 class="text-white-50 mx-auto mt-2 mb-5">A free, responsive, one page Bootstrap theme created by Start Bootstrap.</h2>
        <a href="#projects" class="btn btn-primary js-scroll-trigger">Analyze Image</a>
      </div>
    </div>
  </header>

  <!-- About Section -->
  <section id="about" class="about-section text-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2 class="text-white mb-4">Built with Bootstrap 4</h2>
          <p class="text-white-50">Grayscale is a free Bootstrap theme created by Start Bootstrap. It can be yours right now, simply download the template on
            <a href="http://startbootstrap.com/template-overviews/grayscale/">the preview page</a>. The theme is open source, and you can use it for any purpose, personal or commercial.</p>
        </div>
      </div>
      <img src="img/ipad.png" class="img-fluid" alt="">
    </div>
  </section>

  <!-- Projects Section -->
  <section id="projects" class="projects-section bg-light">
    <div class="container">



    <script type="text/javascript">
        function processImage(){
            var subscriptionKey = "59917bfc68cb40878a43c6f601ede222";

            var uriBase = "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";

            var params = {
                "visualFeatures": "Categories,Description,Color",
                "details": "",
                "language": "en",
            };

            // Display the image.
            var sourceImageUrl = document.getElementById("inputImage").value;
            document.querySelector("#sourceImage").src = sourceImageUrl;

            // Make the REST API call.
            $.ajax({
                url: uriBase + "?" + $.param(params),

                // Request headers.
                beforeSend: function(xhrObj){
                    xhrObj.setRequestHeader("Content-Type","application/json");
                    xhrObj.setRequestHeader(
                        "Ocp-Apim-Subscription-Key", subscriptionKey);
                },

                type: "POST",

                // Request body.
                data: '{"url": ' + '"' + sourceImageUrl + '"}',
            })

            .done(function(data) {
                // Show formatted JSON on webpage.
                $("#responseTextArea").val(JSON.stringify(data, null, 2));
            })

            .fail(function(jqXHR, textStatus, errorThrown) {
                // Display error message.
                var errorString = (errorThrown === "") ? "Error. " :
                    errorThrown + " (" + jqXHR.status + "): ";
                errorString += (jqXHR.responseText === "") ? "" :
                    jQuery.parseJSON(jqXHR.responseText).message;
                alert(errorString);
            });
        };
    </script>

    <div class="container">
		<div class="card">
			<div class="card-body">
                <?php
                error_reporting(0);
                    require_once 'vendor/autoload.php';
                    require_once "./random_string.php";
                    // use WindowsAzure\Common\ServicesBuilder;
                    use MicrosoftAzure\Storage\Blob\BlobRestProxy;
                    use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
                    use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
                    use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
                    use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;


                    $connect_string = "DefaultEndpointsProtocol=https;AccountName=miderstorage;AccountKey=FxCwRG5/TCpZzkZiC1MnLoe2hldeiL3cPiJ6jQLn39FW6wBohVTNuTF9Bjv/g3vprz7yqEVAUhVxgc1NfIb5pw==;EndpointSuffix=core.windows.net";
                    $blob_client = BlobRestProxy::createBlobService($connect_string);

                    $create_container_options = new CreateContainerOptions();
                    $create_container_options->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

                    //setup metadata container
                    $create_container_options->addMetaData("key1", "value1");
                    $create_container_options->addMetaData("key2", "value2");

                    //create container name
                    $container_name = "mider".generateRandomString();

                    $filename = $_FILES['image']['name'];

                    if (($_POST['upload'])){
                        $ekstensi_diperbolehkan	= array('png','jpg', 'JPG', 'jpeg');
                        $nama = $_FILES['image']['name'];
                        $x = explode('.', $nama);
                        $ekstensi = strtolower(end($x));
                        $ukuran	= $_FILES['image']['size'];
                        $file_tmp = $_FILES['image']['tmp_name'];

                        // $filename = $nama;

                        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                            if($ukuran < 1044070){
                                move_uploaded_file($nama, 'files/'.$nama);

                                try {
                                    //container create
                                    $blob_client->createContainer($container_name, $create_container_options);

                                    $upload = fopen($file_tmp, "r") or die("Unable to upload file");
                                    fclose($upload);


                                    $content = fopen($file_tmp, "r");

                                    //upload to container and blob
                                    $blob_client->createBlockBlob($container_name, $filename, $content);

                                    // get list blobs
                                    $bloblists = new ListBlobsOptions();
                                    $bloblists->setPrefix("FinalSubmission");

                                    $urlImage = "https://miderstorage.blob.core.windows.net/".$container_name."/".$nama;


                                    // echo "The url image is : https://miderstorage.blob.core.windows.net/".$container_name."/".$nama;
                                    // echo "<br/>";
                                    // echo '<img src="'.$urlImage.'" width="200" height="200"/>';

                                    do{
                                        $result = $blob_client->listBlobs($container_name, $bloblists);
                                        foreach ($result->getBlobs() as $blob)
                                        {

                                            echo '<img src="'.$blob->getUrl().'" width="200" height="200"/>';

                                        }
                                        $bloblists->setContinuationToken($result->getContinuationToken());
                                    } while($result->getContinuationToken());

                                    ?>

                                    <input type="text" name="inputImage" id="inputImage" width="200"
                                        value="<?php echo  $urlImage;?>" />
                                    <button onclick="processImage()">Analyze image</button>

                                    <?php
                                    $blob = $blob_client->getBlob($container_name, $name);
                                    fpassthru($blob->getContentStream());

                                } catch(ServiceException $e){
                                    $code = $e->getCode();
                                    $error_message = $e->getMessage();
                                    echo $code.": ".$error_message."<br />";
                                }
                                catch(InvalidArgumentTypeException $e){
                                    $code = $e->getCode();
                                    $error_message = $e->getMessage();
                                    echo $code.": ".$error_message."<br />";
                                }
                            }else{
                                echo 'UKURAN FILE TERLALU BESAR';
                                echo "<br/>";
                                echo '<a href="index.php" class="btn btn-warning">Back</a>';

                            }
                        }else{
                            echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
                            echo "<br/>";
                            echo '<a href="index.php" class="btn btn-warning">Back</a>';
                        }


                    }
                ?>

            </div>

            <div class="card-body">
                <div id="wrapper" style="width:1020px; display:table;">
                    <div id="jsonOutput" style="width:600px; display:table-cell;">
                        Response:
                        <br><br>
                        <textarea id="responseTextArea" class="UIInput"
                                style="width:580px; height:400px;"></textarea>
                    </div>
                    <div id="imageDiv" style="width:420px; display:table-cell;">
                        Source image:
                        <br><br>
                        <img id="sourceImage" width="400" />
                    </div>
                </div>
            </div>

        </div>
    </div>

      <!-- Project One Row -->
      <div class="row justify-content-center no-gutters mb-5 mb-lg-0">
        <div class="col-lg-6">
          <img class="img-fluid" src="img/demo-image-01.jpg" alt="">
        </div>
        <div class="col-lg-6">
          <div class="bg-black text-center h-100 project">
            <div class="d-flex h-100">
              <div class="project-text w-100 my-auto text-center text-lg-left">
                <h4 class="text-white">Misty</h4>
                <p class="mb-0 text-white-50">An example of where you can put an image of a project, or anything else, along with a description.</p>
                <hr class="d-none d-lg-block mb-0 ml-0">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Project Two Row -->
      <div class="row justify-content-center no-gutters">
        <div class="col-lg-6">
          <img class="img-fluid" src="img/demo-image-02.jpg" alt="">
        </div>
        <div class="col-lg-6 order-lg-first">
          <div class="bg-black text-center h-100 project">
            <div class="d-flex h-100">
              <div class="project-text w-100 my-auto text-center text-lg-right">
                <h4 class="text-white">Mountains</h4>
                <p class="mb-0 text-white-50">Another example of a project with its respective description. These sections work well responsively as well, try this theme on a small screen!</p>
                <hr class="d-none d-lg-block mb-0 mr-0">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- Signup Section -->
  <section id="signup" class="signup-section">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-lg-8 mx-auto text-center">

          <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
          <h2 class="text-white mb-5">Subscribe to receive updates!</h2>

          <form class="form-inline d-flex">
            <input type="email" class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" id="inputEmail" placeholder="Enter email address...">
            <button type="submit" class="btn btn-primary mx-auto">Subscribe</button>
          </form>

        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="contact-section bg-black">
    <div class="container">

      <div class="row">

        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card py-4 h-100">
            <div class="card-body text-center">
              <i class="fas fa-map-marked-alt text-primary mb-2"></i>
              <h4 class="text-uppercase m-0">Address</h4>
              <hr class="my-4">
              <div class="small text-black-50">4923 Market Street, Orlando FL</div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card py-4 h-100">
            <div class="card-body text-center">
              <i class="fas fa-envelope text-primary mb-2"></i>
              <h4 class="text-uppercase m-0">Email</h4>
              <hr class="my-4">
              <div class="small text-black-50">
                <a href="#">hello@yourdomain.com</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card py-4 h-100">
            <div class="card-body text-center">
              <i class="fas fa-mobile-alt text-primary mb-2"></i>
              <h4 class="text-uppercase m-0">Phone</h4>
              <hr class="my-4">
              <div class="small text-black-50">+1 (555) 902-8832</div>
            </div>
          </div>
        </div>
      </div>

      <div class="social d-flex justify-content-center">
        <a href="#" class="mx-2">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="#" class="mx-2">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="mx-2">
          <i class="fab fa-github"></i>
        </a>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-black small text-center text-white-50">
    <div class="container">
      Copyright &copy; Your Website 2019
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/grayscale.min.js"></script>

</body>

</html>
