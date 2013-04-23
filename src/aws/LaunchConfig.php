<?php

require_once( "../vendor/autoload.php" );
require_once( "../util/service_functions.php" );

require_once( "../config/aws_credentials.php" );

use Aws\AutoScaling\AutoScalingClient;

function extract_important( $config ) {
	$response = array( );

	$response[ "LaunchConfigurationName" ] = $config[ "LaunchConfigurationName" ];
	$response[ "ImageId" ] = $config[ "ImageId" ];
	$response[ "InstanceType" ] = $config[ "InstanceType" ];

	return $response;
}

function get_launch_config( $aws_credentials ) {
	$response = array( );

	$as_client = AutoScalingClient::factory( $aws_credentials );
	$model = $as_client->describeLaunchConfigurations( );
	$configs = $model->get( "LaunchConfigurations" );

	$important = array( );
	foreach( $configs as $config ) {
		$important[] = extract_important( $config );
	}

	$response[ "LaunchConfigurations" ] = $important;
	return json_encode( $response );
}

function put_launch_config( $aws_credentials ) {
	$args = get_json_body( );
	if( $args === false ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	if( !isset( $args[ "LaunchConfigurationName" ] ) || !isset( $args[ "ImageId" ] ) || !isset( $args[ "InstanceType" ] ) ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	$as_client = AutoScalingClient::factory( $aws_credentials );
	$as_client->createLaunchConfiguration( $args );

	return "{}";
}

function delete_launch_config( $aws_credentials ) {
	if( !isset( $_REQUEST[ "LaunchConfigurationName" ] ) ) {
		http_response_code( 400 ); // bad request
		return "{}";
	}

	$args = array(
		"LaunchConfigurationName" => $_REQUEST[ "LaunchConfigurationName" ]
	);

	$as_client = AutoScalingClient::factory( $aws_credentials );
	$as_client->deleteLaunchConfiguration( $args );

	return "{}";
}

$allowed = array( "GET", "PUT", "DELETE" );

$response = "";
switch ( $_SERVER[ "REQUEST_METHOD" ] ) {
	case 'GET':
		$response = get_launch_config( $aws_credentials );
		break;
	case "PUT":
		$response = put_launch_config( $aws_credentials );
		break;
	case "DELETE":
		$response = delete_launch_config( $aws_credentials );
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