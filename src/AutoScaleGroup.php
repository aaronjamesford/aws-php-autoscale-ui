
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Auto Scaling Groups &middot; Aaron Ford</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
    </style>
    <link href="./bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="./bootstrap/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./bootstrap/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./bootstrap/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="./bootstrap/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="./bootstrap/ico/favicon.png">
  </head>

  <body>

    <div class="container-narrow">

      <div class="masthead">
        <!--<ul class="nav nav-pills pull-right">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>
        </ul>-->
        <h3 class="muted">AWS AutoScale Configuration Helper</h3>
      </div>

      <hr>

      <div class="container-narrow">
        <h1>Auto Scaling Groups</h1>
        <p>
        	Here you can see your current auto scaling groups as well as create a new group for use with AWS AutoScale.
        </p>
        <table id="AutoScaleGroupTable" class="table">
        	<thead>
        		<tr>
        			<th>Name</th>
        			<th>Launch Config</th>
        			<th>Min Instances</th>
        			<th>Max Instances</th>
              <th>Delete</th>
        		</tr>
        	</thead>
        	<tbody>
        	</tbody>
        </table>

        <div class="container-narrow">
          <a href="#createModal" role="button" class="btn btn-primary" data-toggle="modal">Create Group</a>
        </div>
      </div>

      <hr>

      <div class="footer">
        <p>&copy; Aaron Ford 2013</p>
      </div>

    </div> <!-- /container -->

    <div id="createModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Create Auto Scaling Group</h3>
      </div>
      <div class="modal-body">
        <form id="AutoScalingGroupForm">
          <fieldset>
            <label>AutoScale Group Name</label>
            <input id="AutoScalingGroupName" type="text" placeholder="e.g. my-auto-scale-group">
            <label>Launch Configuration Name</label>
            <input id="LaunchConfigurationName" type="text" placeholder="e.g. my-launch-config">
            <label>Minimum Instances</label>
            <input id="MinSize" type="text" placeholder="e.g. 1">
            <label>Maximum Instances</label>
            <input id="MaxSize" type="text" placeholder="e.g. 10">
            <label>Availability Zone(s)</label>
            <input id="AvailabilityZones" type="text" placeholder="e.g. eu-west-1a+eu-west-1b">
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <a href="#" role="button" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
        <a id="CreateConfigBtn" href="#" class="btn btn-primary">Create</a>
      </div>
    </div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="./bootstrap/js/jquery.js"></script>-->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/default.js"></script>
    <script src="./bootstrap/js/bootstrap.js"></script>

    <script type="text/javascript">
      $( document ).ready( function( ) {
        getAutoScalingGroups( );
        $( "#CreateConfigBtn" ).click( function( ) {
          putAutoScalingGroup( );
          return false;
        } );
      } );
    </script>

  </body>
</html>
