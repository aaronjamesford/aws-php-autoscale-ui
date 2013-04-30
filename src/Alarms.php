
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Metric Alarms &middot; Aaron Ford</title>
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
        <ul class="nav nav-pills pull-right">
          <li class="dropdown">
            <a class="dropdown-toggle" id="nav-drop" role="button" data-toggle="dropdown" href="#">Navigation <b class="caret"></b></a>
            <ul id="nav-menu" class="dropdown-menu" role="menu" aria-labelledby="nav-drop">
              <li role="presentation"><a role="menuitem" tabindex="-1" href="LaunchConfiguration.php">Launch Configs</a></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="AutoScaleGroup.php">AutoScale Groups</a></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="ScalingPolicy.php">Scaling Policies</a></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="Alarms.php">Alarms</a></li>
            </ul>
          </li>
        </ul>
        <h3 class="muted">AWS AutoScale Configuration Helper</h3>
      </div>

      <hr>

      <div class="container-narrow">
        <h1>Metric Alarms</h1>
        <p>
        	Here you can see your current alarms as well as create a new alarm for use with AWS AutoScale.
        </p>
        <table id="AlarmMetricTable" class="table">
        	<thead>
        		<tr>
        			<th>Name</th>
        			<th>Description</th>
        			<th>Metric</th>
              <th>State</th>
        			<th>Delete</th>
        		</tr>
        	</thead>
        	<tbody>
        	</tbody>
        </table>

        <div class="container-narrow" >
          <div class="accordion" id="create-new">
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle btn btn-success" data-toggle="collapse" data-parent="#create-new" href="#new-form">
                  Create New Alarm
                </a>
              </div>
              <div class="accordion-body collapse" id="new-form">
                <div class="accordion-inner">
                  <h2>New Alarm</h2>
                  <p>
                    This form provides the base components to create an alarm to automatically scale your applications based on metrics of one of your previously defined auto scaling groups.
                  </p>
                  <hr>
                  <form class="form-horizontal" id="AlarmMetricForm">
                    <div class="control-group">
                      <label class="control-label" for="AlarmName">Alarm Name</label>
                      <div class="controls">
                        <input id="AlarmName" type="text" placeholder="e.g. my-alarm">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="AlarmDescription">Alarm Description</label>
                      <div class="controls">
                        <input id="AlarmDescription" type="text" placeholder="e.g. An alarm to react to...">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="PolicyARN">Policy ARN</label>
                      <div class="controls">
                        <input autocomplete="off" id="PolicyARN" type="text" placeholder="e.g. my-scale/my-policy">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="AutoScalingGroupName">Auto Scaling Group Name</label>
                      <div class="controls">
                        <input autocomplete="off" id="AutoScalingGroupName" type="text" placeholder="e.g. my-scale-group">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="MetricName">Metric Name</label>
                      <div class="controls">
                        <input autocomplete="off" id="MetricName" type="text" placeholder="e.g. CPUUtilization">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="Statistic">Statistic</label>
                      <div class="controls">
                        <input autocomplete="off" id="Statistic" type="text" placeholder="e.g. Average">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="Unit">Unit</label>
                      <div class="controls">
                        <input autocomplete="off" id="Unit" type="text" placeholder="e.g. Percent">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="Period">Period (Seconds - 60 minumum)</label>
                      <div class="controls">
                        <input id="Period" type="text" placeholder="e.g. 60">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="EvaluationPeriods">Evaluation Periods</label>
                      <div class="controls">
                        <input id="EvaluationPeriods" type="text" placeholder="e.g. 2">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="Threshold">Threshold</label>
                      <div class="controls">
                        <input id="Threshold" type="text" placeholder="e.g. 50 (Percent)">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="ComparisonOperator">Comparison Operator</label>
                      <div class="controls">
                        <input autocomplete="off" id="ComparisonOperator" type="text" placeholder="e.g. GreaterThanThreshold">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="Namespace">Namespace</label>
                      <div class="controls">
                        <input id="Namespace" type="text" placeholder="e.g. AWS/EC2">
                      </div>
                    </div>
                    <div class="form-actions">
                      <button type="submit" id="CreateConfigBtn" class="btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      <hr>

      <div class="footer">
        <p>&copy; Aaron Ford 2013</p>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="./bootstrap/js/jquery.js"></script>-->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/default.js"></script>
    <script src="./bootstrap/js/bootstrap.js"></script>

    <script type="text/javascript">
      $( document ).ready( function( ) {
        getAlarmMetrics( );
        setARNSource( );
        setComparisonOperators( );
        setStatisticValues( );
        setUnitValues( );
        setAutoScalingGroups( );
        setMetrics( );
        $( "#CreateConfigBtn" ).click( function( ) {
          putAlarmMetric( );
          return false;
        } );
      } );
    </script>

  </body>
</html>
