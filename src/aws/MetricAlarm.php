<?php

require_once( "../vendor/autoload.php" );
require_once( "../util/service_functions.php" );

require_once( "../config/aws_credentials.php" );

use Aws\CloudWatch\CloudWatchClient;

function extract_important( $alarm ) {
	$response = array( );

	$response[ "AlarmName" ] = $alarm[ "AlarmName" ];
	$response[ "AlarmDescription" ] = $alarm[ "AlarmDescription" ];
	$response[ "StateValue" ] = $alarm[ "StateValue" ];
	$response[ "MetricName" ] = $alarm[ "MetricName" ];

	return $response;
}

function get_alarm( $aws_credentials ) {
	$response = array( );

	$as_client = CloudWatchClient::factory( $aws_credentials );
	$model = $as_client->describeAlarms( );
	$alarms = $model->get( "MetricAlarms" );

	$important = array( );
	foreach( $alarms as $alarm ) {
		$important[] = extract_important( $alarm );
	}

	$response[ "MetricAlarms" ] = $important;
	return json_encode( $response );
}

function put_alarm( $aws_credentials ) {
	$args = get_json_body( );
	if( $args === false ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	if( !isset( $args[ "AlarmName" ] ) || !isset( $args[ "AutoScalingGroupName" ] )
		 || !isset( $args[ "MetricName" ] ) || !isset( $args[ "Namespace" ] )
		 || !isset( $args[ "Statistic" ] ) || !isset( $args[ "Period" ] ) 
		 || !isset( $args[ "EvaluationPeriods" ] ) || !isset( $args[ "Threshold" ] )
		 || !isset( $args[ "ComparisonOperator" ] ) || !isset( $args[ "Unit" ] )
		 || !isset( $args[ "PolicyARN" ] ) ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	$params = array(
		"AlarmName" => $args[ "AlarmName" ],
		"AlarmActions" => array( $args[ "PolicyARN" ] ),
		"MetricName" => $args[ "MetricName" ],
		"Namespace" => $args[ "Namespace" ],
		"Statistic" => $args[ "Statistic" ],
		"Dimensions" => array( array( "Name" => "AutoScalingGroupName", "Value" => $args[ "AutoScalingGroupName" ] ) ),
		"Period" => $args[ "Period" ],
		"Unit" => $args[ "Unit" ],
		"EvaluationPeriods" => $args[ "EvaluationPeriods" ],
		"Threshold" => $args[ "Threshold" ],
		"ComparisonOperator" => $args[ "ComparisonOperator" ]
	);

	if( isset( $args[ "AlarmDescription" ] ) ) {
		$params[ "AlarmDescription" ] = $args[ "AlarmDescription" ];
	}

	$as_client = CloudWatchClient::factory( $aws_credentials );
	$as_client->putMetricAlarm( $params );

	return "{}";
}

function delete_alarm( $aws_credentials ) {
	if( !isset( $_REQUEST[ "AlarmName" ] ) ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	$args = array(
		"AlarmNames" => array( $_REQUEST[ "AlarmName" ] )
	);

	$as_client = CloudWatchClient::factory( $aws_credentials );
	$as_client->deleteAlarms( $args );

	return "{}";
}

$allowed = array( "GET", "PUT", "DELETE" );

$response = "";
switch ( $_SERVER[ "REQUEST_METHOD" ] ) {
	case 'GET':
		$response = get_alarm( $aws_credentials );
		break;
	case "PUT":
		$response = put_alarm( $aws_credentials );
		break;
	case "DELETE":
		$response = delete_alarm( $aws_credentials );
		break;
	default:
		http_response_code( 405 ); // Method not allowed
		set_allowed_header( $allowed );
		$response = method_not_supported( );
		break;
}

header('Content-type: application/json');
echo $response;

?>