<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Siran's Home</title>
  <link rel="shortcut icon" href="images/favicon.ico" />

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="styles.css" rel="stylesheet">

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<body>
  <noscript>Your browser does not support JavaScript!</noscript>

  <div id="loader-wrapper">
    <div id="loader" class="xcenter ycenter"></div>
  </div>

  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container max-width-container">
      <div class="navbar-header">
        <a class="navbar-brand" href="http://www.illegalsimon.com"></a>

        <button type="button" class="navbar-toggle collapsed" id="navbarBtn" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

      <div id="navbar" class="navbar-collapse collapse">
        <form class="navbar-form navbar-right" style="display:none">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#subscribeModal">Subscribe!</button>
        </form>

        <ul class="nav navbar-nav navbar-right">
          <li class="selected"><a href="#home">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#projects">projects</a></li>
          <li><a href="#contacts">Contacts</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="subscribeModal" class="modal fade" role="dialog" aria-labelledby="subscribeLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">x</button>
          <h5 class="modal-title" id="subscribeLabel">Subscribe</h5>
        </div>

        <div class="modal-body">
          <p>I'm not sure if you'll receive any surprise, but I do hate spams for sure...</p>

          <div id="alertEmail1" class="alert alert-danger fade in" role="alert" style="display:none">
            <button id="closeAlertEmail1" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Is this email right?
          </div>

          <div id="alertEmail2" class="alert alert-success fade in" role="alert" style="display:none">
            <button id="closeAlertEmail2" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Success! Thank you!
          </div>

          <form>
            <div class="form-group">
              <label for="subscriberName">Name (Optional)</label>
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input id="subscriberName" type="text" class="form-control" placeholder="Your name please!">
              </div>
            </div>

            <div class="form-group">
              <label for="subscriberEmail1">Email address</label>
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                <input id="subscriberEmail1" type="email" class="form-control" placeholder="Your email please!">
              </div>
            </div>

            <div class="form-group">
              <label for="subscriberComment">Comments (Optional)</label>
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-comment"></span></span>
                <textarea id="subscriberComment" class="form-control" maxlength="220" placeholder="Anything you wish to tell me?"></textarea>
              </div>
            </div>

            <button type="submit" id="confirmBtn1-h" hidden></button>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Let me think it over</button>
          <button id="confirmBtn1" type="button" class="btn btn-success">Just go ahead!</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid" id="home">
    <div class="row center-text letterSpacing" id="homeRow">
      <div class="col-md-6 col-md-offset-3">
        <h2><span class="glyphicon glyphicon-home h2-margin-right"></span>This Is Siran's Home</h2>
        <p class="lead">Unfortunately, nothing illegal, illicit, or unlawful is getting underway here.</p>
        <p>It's just that "Siran" is my legal name, whereas "Simon" is not...
          <br>Alright, I know it's kinda mind-dumbing, so keep scrolling to spot something interesting.</p>
      </div>
    </div>
  </div>

  <div class="wrapper">
    <div class="container max-width-container" id="about">
      <div class="row center-text letterSpacing row-1">
        <div class="col-md-8 col-md-offset-2">
          <h2><span class="glyphicon glyphicon-thumbs-down h2-margin-right"></span>Who Am I?</h2>
          <p class="lead" style="color:grey">"It is the best of times, it is the worst of times. I am in between."</p>
          <p class="lead">This is <strong>Siran Shen</strong> from China. Call me <strong>Simon</strong> if you wish.
            <br> If you are interested, my <a href="#projects">projects</a> are listed below in the next section.
            <br>Do take a glance at least please!</p>
        </div>
      </div>

      <div class="row row-2">
        <div class="col-md-4 media-offset">
          <div class="media">
            <div class="media-left">
              <a href="//www.ucla.edu">
                <img class="media-object" src="images/UCLA_logo.png" alt="UCLA">
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading">Student</h4> I'm a student at UCLA, flying all the way from China to study Computer Science.
            </div>
          </div>
        </div>
        <div class="col-md-4 media-offset">
          <div class="media">
            <div class="media-left">
              <img class="media-object" src="images/webdesign.png" alt="UCLA">
            </div>
            <div class="media-body">
              <h4 class="media-heading">Web Developer</h4> My very personal website is just a start. I'm unstoppably absorbing new stuff.
            </div>
          </div>
        </div>
        <div class="col-md-4 media-offset">
          <div class="media">
            <div class="media-left">
              <img class="media-object" src="images/speed_limit.png" alt="UCLA">
            </div>
            <div class="media-body">
              <h4 class="media-heading">Others</h4> Android developer? Game developer? Though far from creating a masterpiece, I'm on my highway.
            </div>
          </div>
        </div>
      </div>

      <a href="" id="secretLink">Secret Link</a>
    </div>
  </div>

  <div class="wrapper" style="background-color:#F0F0F0">
    <div class="container max-width-container" id="projects">
      <div class="row center-text letterSpacing row-1">
        <div class="col-md-8 col-md-offset-2">
          <h2><span class="glyphicon glyphicon-star h2-margin-right"></span>Here Are My Projects</h2>
          <p class="lead" style="color:grey">"We beat on, boats against the current, facing forward forever at the future."</p>
          <p class="lead">This is a list of the projects I did that are courageous enough to showcase themselves.
            <br>
        </div>
      </div>

      <div class="row letterSpacing row-2">
        <div class="col-md-8 col-md-offset-2">
          <div class="media media-offset-lg">
            <div class="media-left media-middle">
              <a href="curveball/">
                <img class="media-object img-rounded" src="images/curveball-logo.png" alt="CurveBall">
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading">
                CurveBall
                  <a href="curveball/">
                      <button class="btn btn-info hide-sm" style="margin-left:15px">Play it!</button>
                  </a>
              </h4> It is called "curve" ball just because the ball can be curved by a swing of the paddle. Made in <a href="https://get.webgl.org/">WebGL</a> by my team for a graphics class, in which it topped the final vote for all 30 team projects.
            </div>
          </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
          <div class="media media-offset-lg">
            <div class="media-left media-middle">
              <a href="todos/" target="_blank">
                <img class="media-object img-rounded" src="images/todos-logo.png" alt="ToDos">
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading">
                ToDos
                  <a href="todos/" target="_blank">
                      <button class="btn btn-info hide-sm" style="margin-left:15px">Check!</button>
                  </a>
              </h4> An AngularJS practice. An online to-do list. You can open it anywhere with Internet and check out what are left to do!
            </div>
          </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
          <div class="media media-offset-lg">
            <div class="media-left media-middle">
              <a href="weatherboy/" target="_blank">
                <img class="media-object img-rounded" src="images/weatherboy-logo.png" alt="WeatherBoy">
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading">
                WeatherBoy
                  <a href="weatherboy/" target="_blank">
                      <button class="btn btn-info hide-sm" style="margin-left:15px">Forecast!</button>
                  </a>
              </h4> This is a simple application that enables you to type in a city name and pop up its weather in 3 days.
            </div>
          </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
          <div class="media media-offset-lg">
            <div class="media-left media-middle">
              <a href="codeplayer/" target="_blank">
                <img class="media-object img-rounded" src="images/codeplayer-logo.png" alt="CodePlayer">
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading">
                CodePlayer
                  <a href="codeplayer/" target="_blank">
                      <button class="btn btn-info hide-sm" style="margin-left:15px">Try it!</button>
                  </a>
              </h4> This is a lame clone of <a href="//www.jsbin.com/">JS Bin</a> using easy HTML, CSS, and JavaScript (with jQuery). Simply simple. But the JavaScript section is disabled due to security issues.
            </div>
          </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
          <p class="media-heading">
            <br>More on the way...</p>
        </div>
      </div>
    </div>
  </div>

  <div class="container max-width-container" id="contacts">
    `
    <div class="row center-text letterSpacing row-1">
      <div class="col-md-8 col-md-offset-2">
        <h2><span class="glyphicon glyphicon-earphone h2-margin-right"></span>Contact Me!</h2>
        <p class="lead" style="color:grey">"Programmers of the world, unite!"</p>
        <p class="lead">If anyhow you want to contact me after browsing through, GREAT, send me some lines of words.
          <br>Advice, comments, greetings...Anything, except spams...
          <br> Please click the icons below to reach me.</p>
      </div>
    </div>

    <div class="row letterSpacing row-2">
      <div class="col-md-8 col-md-offset-2">
        <ul>
          <li>
            <a href="https://www.facebook.com/siransimonshen" target="_blank">
              <img class="contacts-image" src="images/facebook.png" alt="Facebook">
            </a>
          </li>
          <li>
            <a href="//www.linkedin.com/in/siranshen" target="_blank">
              <img class="contacts-image" src="images/linkedin.png" alt="LinkedIn">
            </a>
          </li>
          <li>
            <a href="https://github.com/Ssr1994" target="_blank">
              <img class="contacts-image" src="images/github.png" alt="GitHub">
            </a>
          </li>
          <li>
            <input type="image" id="wechat" data-toggle="tooltip" data-placement="top" data-trigger="focus hover" title="Find me by searching '1335965438'" class="contacts-image" src="images/wechat.png" alt="WeChat">
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="wrapper" id="footerWrapper">
    <div class="container max-width-container" id="footer">
      <div class="row">
        <div class="col-md-6">
          <form id="subscribeForm">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
              <input id="subscriberEmail2" type="email" class="form-control" placeholder="No worry for spams">
            </div>
          </form>

          <a id="confirmBtn2" tabindex="0" class="btn btn-danger" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="!">Subscribe!</a>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <p style="color:white; margin-top:10px">@IllegalSimon</p>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="main.js"></script>
</body>

</html>