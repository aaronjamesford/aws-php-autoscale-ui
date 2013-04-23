<?php

require_once( "../vendor/autoload.php" );
require_once( "../util/service_functions.php" );

require_once( "../config/aws_credentials.php" );

use Aws\AutoScaling\AutoScalingClient;

function extract_important( $group ) {
	$response = array( );

	$response[ "AutoScalingGroupName" ] = $group[ "AutoScalingGroupName" ];
	$response[ "LaunchConfigurationName" ] = $group[ "LaunchConfigurationName" ];
	$response[ "MinSize" ] = $group[ "MinSize" ];
	$response[ "MaxSize" ] = $group[ "MaxSize" ];

	return $response;
}

function get_scaling_group( $aws_credentials ) {
	$response = array( );

	$as_client = AutoScalingClient::factory( $aws_credentials );
	$model = $as_client->describeAutoScalingGroups( );
	$groups = $model->get( "AutoScalingGroups" );

	$important = array( );
	foreach( $groups as $group ) {
		$important[] = extract_important( $group );
	}

	$response[ "AutoScalingGroups" ] = $important;
	return json_encode( $response );
}

function put_scaling_group( $aws_credentials ) {
	$args = get_json_body( );
	if( $args === false ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	if( !isset( $args[ "AutoScalingGroupName" ] ) || !isset( $args[ "LaunchConfigurationName" ] )
		 || !isset( $args[ "MinSize" ] ) || !isset( $args[ "MaxSize" ] ) || !isset( $args[ "AvailabilityZones" ] ) ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	if( !is_array( $args[ "AvailabilityZones" ] ) ) {
		$args[ "AvailabilityZones" ] = explode( "+", $args[ "AvailabilityZones" ] );
	}

	$as_client = AutoScalingClient::factory( $aws_credentials );
	$as_client->createAutoScalingGroup( $args );

	return "{}";
}

function delete_scaling_group( $aws_credentials ) {
	if( !isset( $_REQUEST[ "AutoScalingGroupName" ] ) ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	$args = array(
		"AutoScalingGroupName" => $_REQUEST[ "AutoScalingGroupName" ],
		"ForceDelete" => true
	);

	$as_client = AutoScalingClient::factory( $aws_credentials );
	$as_client->deleteAutoScalingGroup( $args );

	return "{}";
}

$allowed = array( "GET", "PUT", "DELETE" );

$response = "";
switch ( $_SERVER[ "REQUEST_METHOD" ] ) {
	case 'GET':
		$response = get_scaling_group( $aws_credentials );
		break;
	case "PUT":
		$response = put_scaling_group( $aws_credentials );
		break;
	case "DELETE":
		$response = delete_scaling_group( $aws_credentials );
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